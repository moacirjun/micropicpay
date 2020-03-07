<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    /**
     * @inheritDoc
     */
    protected $table = 'tb_wallet';

    public function user()
    {
        return $this->belongsTo('App\Entity\User');
    }

    public function payments()
    {
        return $this->hasMany('App\Entity\Transaction', 'origin_wallet_id');
    }

    public function paymentsReceived()
    {
        return $this->hasMany('App\Entity\Transaction', 'target_wallet_id');
    }
}
