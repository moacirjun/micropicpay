<?php


namespace App\Services\User\Payment;


use App\Domain\Payment;

class Validator
{
    /**
     * @param Payment $payment
     * @return array
     */
    public static function validate(Payment $payment)
    {
        return [];
    }
}
