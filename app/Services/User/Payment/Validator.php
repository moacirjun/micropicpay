<?php


namespace App\Services\User\Payment;


use App\Domain\Payment;
use App\Entity\Wallet;
use App\Enums\UserType as UserTypeEnum;

class Validator
{
    /**
     * @param Payment $payment
     * @return array
     */
    public static function validate(Payment $payment)
    {
        $errors = [];
        $originUser = $payment->getOriginUser();

        if ($originUser->type !== UserTypeEnum::INDIVIDUAL()->getValue()) {
            $errors[] = 'Only individual user can transfer';
        }

        /** @var Wallet $originUserWallet */
        $originUserWallet = (new Wallet)->newQuery()->where('user_id', $originUser->id)->first();

        if ($originUserWallet->amount < $payment->getValue()) {
            $errors[] = 'User does not have enough credit';
        }

        return $errors;
    }
}
