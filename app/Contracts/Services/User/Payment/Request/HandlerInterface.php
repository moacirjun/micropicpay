<?php


namespace App\Contracts\Services\User\Payment\Request;


use App\Services\Transference\Request\HttpRequest\HandlerResult;
use Illuminate\Http\Request;

interface HandlerInterface
{
    /**
     * Resolves the User Payment Request. This method validate request, and create a PaymentResolver Queue
     * or already executes the payment
     * @param Request $request
     * @return HandlerResult
     */
    public function handle(Request $request) : HandlerResult;
}
