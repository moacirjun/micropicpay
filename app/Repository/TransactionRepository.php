<?php

namespace App\Repository;

use App\Contracts\Repository\UserRepositoryInterface;
use App\Entity\Transaction;
use Prettus\Repository\Eloquent\BaseRepository;

class TransactionRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return Transaction::class;
    }
}
