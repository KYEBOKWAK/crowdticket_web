<?php
/**
 * Created by PhpStorm.
 * User: mhd
 * Date: 2016-05-15
 * Time: 오전 2:55
 */

namespace App\Services;


abstract class Payment
{
    private $impId;
    private $merchantId;
    private $customerId;

    public function __construct($impId, $merchantId, $customerId)
    {
        $this->impId = $impId;
        $this->merchantId = $merchantId;
        $this->customerId = $customerId;
    }

    protected function getImpId()
    {
        return $this->impId;
    }

    protected function getMerchantId()
    {
        return $this->merchantId;
    }

    protected function getCustomerId()
    {
        return $this->customerId;
    }

    public abstract function cancel();

    public abstract function toJson();

    public abstract function isConcluded();
    
    /**
     * TODO: future implementation
     */
    // public abstract function getInfo();
    // public abstract function getStatus();
}