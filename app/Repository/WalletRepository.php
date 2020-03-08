<?php

namespace App\Repository;

use App\Contracts\Repository\WalletRepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class WalletRepository extends BaseRepository implements WalletRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return 'App\Entity\Wallet';
    }
}
