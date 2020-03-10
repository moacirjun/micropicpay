<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Transference extends Model
{
    /**
     * @inheritDoc
     */
    protected $table = 'tb_transaction';

    protected $fillable = [
        'origin_wallet_id',
        'target_wallet_id',
        'value',
        'hash'
    ];

    public function originWallet()
    {
        return $this->belongsTo('App\Entity\Wallet', 'origin_wallet_id');
    }

    public function targetWallet()
    {
        return $this->belongsTo('App\Entity\Wallet', 'target_wallet_id');
    }
}
