<?php

namespace App\Services\Payment;

use App\Domain\Payment;

class Publisher
{
    public static function publishMessage(Payment $payment)
    {
        return true;
    }
}