<?php

namespace App\Services\User\Payment\Request;

use App\Contracts\Repository\UserRepositoryInterface;
use App\Contracts\Services\User\Payment\Request\ResolverInterface;
use App\Domain\Payment;
use App\Services\Payment\Publisher;
use Illuminate\Http\Request;

class Resolver implements ResolverInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * Resolver constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Request $request) : Result
    {
        try {
            $originUser = $request->route('id');
            $payload = $request->all();

            $validationErrors = Validator::validate($originUser, $payload);

            if (sizeof($validationErrors)) {
                return new Result($request, null, $validationErrors);
            }

            $originUserInstance = $this->userRepository->find($originUser);
            $targetUserInstance = $this->userRepository->find($payload['target_user']);

            $payment = new Payment($originUserInstance, $targetUserInstance, $payload['value']);

            Publisher::publishMessage($payment);

            return new Result($request, $payment);
        } catch (\Exception $exception) {
            return new Result($request, null, [$exception->getCode() => $exception->getMessage()]);
        }
    }
}
