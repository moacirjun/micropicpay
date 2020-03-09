<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * @inheritDoc
     */
    protected $table = 'tb_user';

    /**
     * @inheritDoc
     */
    protected $fillable = ['name', 'age', 'type'];

    public function Wallet()
    {
        return $this->hasOne('App\Entity\Wallet');
    }
}
