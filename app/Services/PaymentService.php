<?php
/**
 * Created by PhpStorm.
 * User: mhd
 * Date: 2016-05-18
 * Time: 오전 1:39
 */

namespace App\Services;


use App\Exceptions\InvalidPaymentException;
use App\Exceptions\PaymentFailedException;
use App\Models\Order;

class PaymentService
{
    private $api;

    public function __construct()
    {
        $this->api = new IamPortApi();
    }

    public function rightNow(PaymentInfo $info)
    {
        $res = $this->api->post('/subscribe/payments/onetime', [
            'merchant_uid' => $info->getMerchantUid(),
            'customer_uid' => $info->getCustomerUid(),
            'amount' => $info->getAmount(),
            'vat' => '',
            'card_number' => $info->getCardNumber(),
            'expiry' => $info->getExpiry(),
            'birth' => $info->getBirth(),
            'pwd_2digit' => $info->getPassword(),
            'name' => '',
            'buyer_name' => '',
            'buyer_email' => '',
            'buyer_tel' => '',
            'buyer_addr' => '',
            'buyer_postcode' => ''
        ]);

        if ((int)$res->code === -1) {
            throw new PaymentFailedException($res->message);
        }
        $impId = $res->response->imp_uid;
        return new OneTimePayment($impId, $info->getMerchantUid(), $info->getCustomerUid());
    }

    public function schedule(PaymentInfo $info, $date)
    {
        $customerUid = $info->getCustomerUid();
        $checkRes = $this->api->post('/subscribe/customers/' . $customerUid, [
            'customer_uid' => $customerUid,
            'card_number' => $info->getCardNumber(),
            'expiry' => $info->getExpiry(),
            'birth' => $info->getBirth(),
            'pwd_2digit' => $info->getPassword()
        ]);

        if ((int)$checkRes->code === -1) {
            throw new PaymentFailedException($checkRes->message);
        }

        $res = $this->api->post('/subscribe/payments/schedule', [
            'customer_uid' => $customerUid,
            'card_number' => $info->getCardNumber(),
            'expiry' => $info->getExpiry(),
            'birth' => $info->getBirth(),
            'pwd_2digit' => $info->getPassword(),
            'schedules' => [
                [
                    'merchant_uid' => $info->getMerchantUid(),
                    'schedule_at' => strtotime($date),
                    'amount' => $info->getAmount()
                ]
            ]
        ]);

        if ((int)$res->code === -1) {
            throw new PaymentFailedException($res->message);
        }
        return new ScheduledPayment($info->getMerchantUid(), $info->getCustomerUid());
    }

    public static function getPayment($order)
    {
        $adapter = new PaymentAdapter();
        return $adapter->newInstance($order);
    }
}

class PaymentAdapter
{
    public function newInstance($order)
    {
        $meta = json_decode($order->imp_meta);
        switch ($meta->serializer_uid) {
            case OneTimePayment::SERIALIZER_UID:
                return new OneTimePayment($order, $meta->imp_uid, $meta->merchant_uid, $meta->customer_uid);

            case ScheduledPayment::SERIALIZER_UID:
                return new ScheduledPayment($meta->merchant_uid, $meta->customer_uid);

            default:
                throw new InvalidPaymentException();
        }
    }
}

class OneTimePayment extends Payment
{
    const SERIALIZER_UID = "onetime";

    private $order;

    public function __construct(Order $order, $impId, $merchantId, $customerId)
    {
        parent::__construct($impId, $merchantId, $customerId);
        $this->order = $order;
    }

    public function cancel()
    {
        $client = new IamPortApi();
        $res = $client->post('/payments/cancel', [
            'imp_uid' => $this->getImpId(),
            'merchant_uid' => '',
            'amount' => $this->order->getRefundAmount(),
            'reason' => '',
            'refund_holder' => '',
            'refund_bank' => '',
            'refund_account' => ''
        ]);
        return $res;
    }

    public function toJson()
    {
        return json_encode([
            'serializer_uid' => self::SERIALIZER_UID,
            'imp_uid' => $this->getImpId(),
            'merchant_uid' => $this->getMerchantId(),
            'customer_uid' => $this->getCustomerId()
        ]);
    }

    public function isConcluded()
    {
        return true;
    }
}

class ScheduledPayment extends Payment
{
    const SERIALIZER_UID = "scheduled";

    public function __construct($merchantId, $customerId)
    {
        parent::__construct('', $merchantId, $customerId);
    }

    public function getImpId()
    {
        throw new NotConcludedPaymentException();
    }

    public function cancel()
    {
        $client = new IamPortApi();
        $res = $client->post('/subscribe/payments/unschedule', [
            'customer_uid' => $this->getCustomerId(),
            'merchant_uid' => [$this->getMerchantId()]
        ]);
        return $res;
    }

    public function toJson()
    {
        return json_encode([
            'serializer_uid' => self::SERIALIZER_UID,
            'merchant_uid' => $this->getMerchantId(),
            'customer_uid' => $this->getCustomerId()
        ]);
    }

    public function isConcluded()
    {
        return false;
    }
}

class NotConcludedPaymentException extends \Exception
{

}