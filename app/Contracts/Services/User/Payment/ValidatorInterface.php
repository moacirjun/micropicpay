<?php


namespace App\Contracts\Services\User\Payment;


use App\Domain\Payment;

interface ValidatorInterface
{
    /**
     * @param Payment $payment
     * @return array
     */
    public function validate(Payment $payment);
}
