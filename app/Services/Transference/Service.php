<?php

namespace App\Services\Transference;

use App\Domain\Payment;
use App\Entity\Transaction;

class Service
{
    /**
     * @param Payment $payment
     * @return Transaction
     */
    public static function processPayment(Payment $payment) : Transaction
    {
        return new Transaction();
    }
}
