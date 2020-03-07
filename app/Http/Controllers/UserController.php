<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Services\User\Payment\Service as UserPaymentService;
use App\Services\User\Payment\JsonResponseFactory as UserPaymentResponseFactory;

class UserController extends BaseController
{
    public function pay(Request $request)
    {
        $result = UserPaymentService::resolve($request);
        return UserPaymentResponseFactory::make($result);
    }
}
