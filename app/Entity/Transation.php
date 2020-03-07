<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * @inheritDoc
     */
    protected $table = 'tb_transaction';

    public function originWallet()
    {
        return $this->belongsTo('App\Entity\Wallet', 'origin_wallet_id');
    }

    public function targetWallet()
    {
        return $this->belongsTo('App\Entity\Wallet', 'target_wallet_id');
    }
}