<?php

namespace App\Services\Payment;

use App\Services\Payment\Gateways\Momo;

/**
 * @property-read Momo $momo
 *
 * Class PaymentContainer
 * @package App\Services\Payment
 */
class PaymentContainer
{
    public function __get($name)
    {
        return app()->make($name);
    }
}
