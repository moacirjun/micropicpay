<?php

namespace App\Services\User\Payment\Request;

use App\Contracts\Repository\UserRepositoryInterface;
use App\Contracts\Services\User\Payment\Request\ResolverInterface;
use App\Contracts\Services\User\Payment\ServiceInterface;
use App\Domain\Payment;
use App\Services\Payment\Publisher;
use App\Services\Payment\RabbitMQPublisher;
use Illuminate\Http\Request;

class Resolver implements ResolverInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var ServiceInterface
     */
    private $userPaymentService;

    /**
     * Resolver constructor.
     * @param UserRepositoryInterface $userRepository
     * @param ServiceInterface $userPaymentService
     */
    public function __construct(UserRepositoryInterface $userRepository, ServiceInterface $userPaymentService)
    {
        $this->userRepository = $userRepository;
        $this->userPaymentService = $userPaymentService;
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

            (new RabbitMQPublisher)->publish(serialize($payment)); //Executing payment asynchronously
            //$this->userPaymentService->execute($payment); //Execute payment in User Request

            return new Result($request, $payment);
        } catch (\Exception $exception) {
            return new Result($request, null, [$exception->getCode() => $exception->getMessage()]);
        }
    }
}
