<?php

namespace App\Contracts\Services\User\Payment;

use App\Domain\Payment;

interface ServiceInterface
{
    /**
     * Executes the User Payment
     * @param Payment $payment
     */
    public function execute(Payment $payment);
}
