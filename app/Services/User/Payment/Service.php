<?php

namespace App\Services\User\Payment;

use Illuminate\Http\Request;

class Service
{
    public static function resolve(Request $request)
    {
        return new Result();
    }
}
