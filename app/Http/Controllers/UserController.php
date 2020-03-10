<?php

namespace App\Http\Controllers;

use App\Contracts\Services\User\Payment\Request\ResolverInterface as UserPaymentRequestResolverInterface;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Services\Transference\Request\HttpRequest\JsonResponseFactory as UserPaymentResponseFactory;

class UserController extends BaseController
{
    /**
     * @var UserPaymentRequestResolverInterface
     */
    private $requestResolver;

    /**
     * UserController constructor.
     * @param UserPaymentRequestResolverInterface $requestResolver
     */
    public function __construct(UserPaymentRequestResolverInterface $requestResolver)
    {
        $this->requestResolver = $requestResolver;
    }

    public function pay(Request $request)
    {
        $result = $this->requestResolver->handle($request);
        return UserPaymentResponseFactory::make($result);
    }
}
