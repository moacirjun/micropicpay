<?php

namespace App\Services\Transference\Message;

use App\Entity\Transference;

class Publisher
{

    public static function publish(Transference $transference)
    {
        return true;
    }
}
