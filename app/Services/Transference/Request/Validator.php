<?php


namespace App\Services\Transference\Request;

use App\Domain\Payment;
use App\Entity\Wallet;
use App\Enums\UserType as UserTypeEnum;
use App\Contracts\Repository\WalletRepositoryInterface;
use App\Contracts\Services\User\Payment\ValidatorInterface as UserPaymentValidatorInterface;

/**
 * Validates Transference action
 */
class Validator implements UserPaymentValidatorInterface
{
    /**
     * @var WalletRepositoryInterface
     */
    private $walletRepository;

    /**
     * Validator constructor.
     * @param WalletRepositoryInterface $walletRepository
     */
    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * @param Payment $payment
     * @return array
     */
    public function validate(Payment $payment)
    {
        $errors = [];
        $originUser = $payment->getOriginUser();

        if ($originUser->type !== UserTypeEnum::INDIVIDUAL()->getValue()) {
            $errors[] = 'Only individual user can transfer';
        }

        $originUserWallet = $this->walletRepository->findOneByUser($originUser);

        if (!$originUserWallet instanceof Wallet) {
            $errors[] = sprintf('User [%s] does not have a valid Wallet', $originUser->id);
            return $errors;
        }

        if ($originUserWallet->amount < $payment->getValue()) {
            $errors[] = 'User does not have enough credit';
        }

        return $errors;
    }
}
