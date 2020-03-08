<?php

namespace App\Services\Transference\Message;

use App\Entity\Transaction;

class Publisher
{

    public static function publish(Transaction $transference)
    {
        return true;
    }
}
