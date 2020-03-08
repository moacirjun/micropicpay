<?php

namespace App\Services\Payment;

use App\Domain\Payment;
use App\Jobs\PaymentResolver;

class Publisher
{
    public static function publishMessage(Payment $payment)
    {
        dispatch(new PaymentResolver($payment));
    }
}
