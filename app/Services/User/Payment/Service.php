<?php

namespace App\Services\User\Payment;

use App\Domain\Payment;
use App\entity\User;
use App\Services\Payment\Publisher;
use Illuminate\Http\Request;

class Service
{
    public static function resolve(Request $request) : Result
    {
        try {
            $originUser = $request->route('id');
            $payload = $request->all();

            $validationErrors = Validator::validate($originUser, $payload);

            if (sizeof($validationErrors)) {
                return new Result($request, null, $validationErrors);
            }

            $originUserInstance = (new User)->newQuery()->find($originUser);
            $targetUserInstance = (new User)->newQuery()->find($payload['target_user']);

            $payment = new Payment($originUserInstance, $targetUserInstance, $payload['value']);

            Publisher::publishMessage($payment);

            return new Result($request, $payment);
        } catch (\Exception $exception) {
            return new Result($request, null, [$exception->getCode() => $exception->getMessage()]);
        }
    }
}
