<?php

namespace App\Services\Transference;

use App\Domain\Payment;
use App\Entity\Transaction;
use App\Entity\Wallet;
use Faker\Provider\Uuid;
use Illuminate\Support\Facades\DB;

class Service
{
    /**
     * Insets a Transference in database and modify the value of the destination and source wallets
     * @param Payment $payment
     * @return Transaction
     */
    public static function processPayment(Payment $payment) : Transaction
    {
        $originUser = $payment->getOriginUser();
        $originWallet = (new Wallet)->newQuery()->where('user_id', $originUser->id)->first();

        if (!$originWallet instanceof Wallet) {
            throw new \InvalidArgumentException(sprintf('User [%s] does not have a wallet', $originUser->id));
        }

        $targetUser = $payment->getTargetUser();
        $targetWallet = (new Wallet)->newQuery()->where('user_id', $targetUser->id)->first();

        if (!$targetWallet instanceof Wallet) {
            throw new \InvalidArgumentException(sprintf('User [%s] does not have a wallet', $targetUser->id));
        }

        DB::beginTransaction();

        $newTransference = (new Transaction)->newQuery()->create([
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
