<?php

namespace App\Repository;

use App\Contracts\Repository\UserRepositoryInterface;
use App\Entity\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return User::class;
    }
}
