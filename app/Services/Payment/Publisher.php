<?php

namespace App\Services\Payment;

use App\Domain\Payment;
use App\Jobs\PaymentResolver;
use Illuminate\Support\Facades\Queue;

class Publisher
{
    public static function publishMessage(Payment $payment)
    {
        dispatch(new PaymentResolver($payment));
        return true;
    }
}
