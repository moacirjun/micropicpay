<?php

namespace App\Contracts\Services\Transference;

use App\Domain\Payment;
use App\Entity\Transaction;

interface ServiceInterface
{
    /**
     * Insets a Transference in database and modify the value of the destination and source wallets
     * @param Payment $payment
     * @return Transaction
     */
    public function processPayment(Payment $payment) : Transaction;
}
