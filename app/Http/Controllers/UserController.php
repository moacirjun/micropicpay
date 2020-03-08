<?php

namespace App\Http\Controllers;

use App\Services\User\Payment\Request\Resolver as UserPaymentRequestResolver;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Services\User\Payment\Request\JsonResponseFactory as UserPaymentResponseFactory;

class UserController extends BaseController
{
    public function pay(Request $request)
    {
        $result = UserPaymentRequestResolver::resolve($request);
        return UserPaymentResponseFactory::make($result);
    }
}
