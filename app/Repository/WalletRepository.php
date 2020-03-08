<?php

namespace App\Repository;

use App\Contracts\Repository\WalletRepositoryInterface;
use App\Entity\User;
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

    /**
     * @param User|integer $user
     * @return mixed
     */
    public function findOneByUser($user)
    {
        $userID = $user instanceof User ? $user->id : $user;
        $collection = $this->findWhere(['user_id' => $userID]);

        if (sizeof($collection) === 0) {
            return null;
        }

        return $collection->first();
    }
}
