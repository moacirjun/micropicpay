<?php

namespace App\Repository;

use App\Contracts\Repository\TransactionRepositoryInterface;
use App\Entity\Transference;
use Prettus\Repository\Eloquent\BaseRepository;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return Transference::class;
    }
}
