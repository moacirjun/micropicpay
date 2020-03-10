<?php


namespace App\Contracts\Services\User\Payment\Request;


use App\Services\Transference\Request\HttpRequest\Result;
use Illuminate\Http\Request;

interface ResolverInterface
{
    /**
     * Resolves the User Payment Request. This method validate request, and create a PaymentResolver Queue
     * or already executes the payment
     * @param Request $request
     * @return Result
     */
    public function resolve(Request $request) : Result;
}
