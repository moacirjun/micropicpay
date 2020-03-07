<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function pay(Request $request, $userId)
    {
        return response()->json(['user' => $userId]);
    }
}
