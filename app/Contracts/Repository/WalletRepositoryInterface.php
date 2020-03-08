<?php

namespace App\Contracts\Repository;

use App\Entity\User;
use Prettus\Repository\Contracts\RepositoryInterface;

interface WalletRepositoryInterface extends RepositoryInterface
{
    /**
     * @param User|integer $user
     * @return mixed
     */
    public function findOneByUser($user);
}
