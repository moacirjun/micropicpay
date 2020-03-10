<?php

namespace App\Contracts\Services\Transference\Process;

use App\Domain\Payment;
use App\Entity\Transference;

interface DataBaseManagerServiceInterface
{
    /**
     * Insets a Transference in database and modify the value of the destination and source wallets
     * @param Payment $payment
     * @return Transference
     */
    public function persist(Payment $payment) : Transference;
}
