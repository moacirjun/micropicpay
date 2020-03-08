<?php

namespace App\Services\User\Payment\Request;

use App\Domain\Payment;
use App\Entity\User;
use App\Services\Payment\Publisher;
use Illuminate\Http\Request;

class Resolver
{
    /**
     * Resolves the User Payment Request. This method validate request, and create a PaymentResolver Queue
     * @param Request $request
     * @return Result
     */
    public static function resolve(Request $request) : Result
    {
        try {
            $originUser = $request->route('id');
            $payload = $request->all();

            $validationErrors = Validator::validate($originUser, $payload);

            if (sizeof($validationErrors)) {
                return new Result($request, null, $validationErrors);
            }

            $originUserInstance = (new User)->newQuery()
                ->with('wallet')
                ->find($originUser);
            $targetUserInstance = (new User)->newQuery()
                ->with('wallet')
                ->find($payload['target_user']);

            $payment = new Payment($originUserInstance, $targetUserInstance, $payload['value']);

            Publisher::publishMessage($payment);

            return new Result($request, $payment);
        } catch (\Exception $exception) {
            return new Result($request, null, [$exception->getCode() => $exception->getMessage()]);
        }
    }
}
