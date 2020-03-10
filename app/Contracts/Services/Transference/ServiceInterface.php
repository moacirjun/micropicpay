<?php

namespace App\Contracts\Services\Transference;

use App\Domain\Payment;
use App\Entity\Transference;

interface ServiceInterface
{
    /**
     * Insets a Transference in database and modify the value of the destination and source wallets
     * @param Payment $payment
     * @return Transference
     */
    public function processPayment(Payment $payment) : Transference;
}
