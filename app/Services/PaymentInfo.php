<?php
/**
 * Created by PhpStorm.
 * User: mhd
 * Date: 2016-05-15
 * Time: 오전 3:25
 */

namespace App\Services;


use Illuminate\Support\Facades\Validator;

class PaymentInfo
{
    const MIN_AMOUNT = 0;
    const MAX_AMOUNT = 2500000;

    private $cardNumber;
    private $expiry;
    private $birth;
    private $password;
    private $amount;
    private $customerUid;
    private $merchantUid;

    public function withSignature($userId, $projectId)
    {
        $appType = env('APP_TYPE');
        if($appType)
        {
          $appType = '_'.$appType;
        }

        $this->validateOrFail('user_id', $userId, 'integer');
        $this->validateOrFail('project_id', $projectId, 'integer');
        $this->customerUid = sprintf('user_%d%s', $userId, $appType);
        $this->merchantUid = sprintf('project_%d_user_%d_%d%s', $projectId, $userId, time(), $appType);
    }

    public function withCardNumber($cardNumber)
    {
        //$this->validateOrFail('card_number', $cardNumber, 'digits_between:15,16');
        $this->validateOrFail('card_number', $cardNumber, 'integer');
        $this->cardNumber = $this->formatCardNumber($cardNumber);
    }

    public function withExpiry($year, $month)
    {
        $currentYear = date('Y');
        $maxYear = $currentYear + 100;
        $this->validateOrFail('expiry_year', $year, sprintf('integer|min:%d', $currentYear, $maxYear));
        $this->validateOrFail('expiry_month', $month, 'integer|between:1,12');
        $month2Digit = ((int)$month) < 10 ? '0' . $month : $month;
        $this->expiry = $year . '-' . $month2Digit;
    }

    public function withBirth($birth)
    {
        $this->validateOrFail('birth', $birth, 'digits_between:1,10');
        $this->birth = $birth;
    }

    public function withPassword($pass2Digits)
    {
        $this->validateOrFail('password', $pass2Digits, 'digits:2');
        $this->password = $pass2Digits;
    }

    public function withAmount($amount)
    {
      $rule = sprintf('integer|min:%d|max:%d', self::MIN_AMOUNT, self::MAX_AMOUNT);
      $this->validateOrFail('amount', $amount, $rule);
      $this->amount = $amount;

      /*
        $rule = sprintf('integer|min:%d|max:%d', self::MIN_AMOUNT, self::MAX_AMOUNT);
        $this->validateOrFail('amount', $amount, $rule);
        $this->amount = $amount;
        */
    }

    private function formatCardNumber($cardNumber)
    {
        $split = str_split($cardNumber, 4);
        $formatNumber = '';
        for ($i = 0, $l = sizeof($split); $i < $l; $i++) {
            $formatNumber .= $split[$i];
            if ($i < $l - 1) {
                $formatNumber .= '-';
            }
        }
        return $formatNumber;
    }

    private function validateOrFail($name = '', $item, $rule)
    {
        $items = [$name => $item];
        $rules = [$name => '|required|' . $rule];
        $v = Validator::make($items, $rules);
        $errors = $v->errors();
        $message = '';
        foreach ($errors->all() as $error) {
            $message .= $error;
        }
        if ($message) {
            throw new \InvalidArgumentException($message);
        }
    }

    public function getCustomerUid()
    {
        return $this->customerUid;
    }

    public function getMerchantUid()
    {
        return $this->merchantUid;
    }

    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    public function getExpiry()
    {
        return $this->expiry;
    }

    public function getBirth()
    {
        return $this->birth;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getAmount()
    {
        return $this->amount;
    }

}
