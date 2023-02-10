<?php

namespace App\Services\Payment\Factories;

use App\Services\Payment\Contracts\Payment;
use App\Services\Payment\PaymentContainer;

class PaymentFactory
{
    /**
     * Create a Payment instance
     * 
     * @param  string $method
     * @return Payment
     */
    public static function makeInstance($method): Payment
    {
        return (new PaymentContainer())->$method;
    }
}
