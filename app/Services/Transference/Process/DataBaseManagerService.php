<?php

namespace App\Services\Transference\Process;

use App\Contracts\Repository\TransactionRepositoryInterface;
use App\Contracts\Repository\WalletRepositoryInterface;
use App\Domain\Payment;
use App\Entity\Transference;
use App\Entity\Wallet;
use Faker\Provider\Uuid;
use Illuminate\Support\Facades\DB;
use App\Contracts\Services\Transference\Process\DataBaseManagerServiceInterface as DataBaseManagerInterface;

/**
 * Class responsible for making the sequence of changes in the database of a transfer action
 * @package App\Services\Transference
 */
class DataBaseManagerService implements DataBaseManagerInterface
{
    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;

    /**
     * @var WalletRepositoryInterface
     */
    private $walletRepository;

    /**
     * Service constructor.
     * @param TransactionRepositoryInterface $transactionRepository
     * @param WalletRepositoryInterface $walletRepository
     */
    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        WalletRepositoryInterface $walletRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->walletRepository = $walletRepository;
    }

    /**
     * Insets a Transference in database and modify the value of the destination and source wallets
     * @param Payment $payment
     * @return Transference
     */
    public function persist(Payment $payment) : Transference
    {
        $originUser = $payment->getOriginUser();
        $originWallet = $this->walletRepository->findOneByUser($originUser);

        if (!$originWallet instanceof Wallet) {
            throw new \InvalidArgumentException(sprintf('User [%s] does not have a wallet', $originUser->id));
        }

        $targetUser = $payment->getTargetUser();
        $targetWallet = $this->walletRepository->findOneByUser($targetUser);

        if (!$targetWallet instanceof Wallet) {
            throw new \InvalidArgumentException(sprintf('User [%s] does not have a wallet', $targetUser->id));
        }

        DB::beginTransaction();

        $newTransference = $this->transactionRepository->create([
            'origin_wallet_id' => $originWallet->id,
            'target_wallet_id' => $targetWallet->id,
            'value' => $payment->getValue(),
            'hash' => Uuid::uuid()
        ]);

        $originWallet->amount = $originWallet->amount - $payment->getValue();
        $originWallet->save();

        $targetWallet->amount = $targetWallet->amount + $payment->getValue();
        $targetWallet->save();

        DB::commit();

        return $newTransference;
    }
}
