<?php

namespace App\Services\Transference\Request\HttpRequest;

use App\Contracts\Repository\UserRepositoryInterface;
use App\Contracts\Services\User\Payment\Request\HandlerInterface;
use App\Contracts\Services\User\Payment\ServiceInterface;
use App\Domain\Payment;
use App\Services\Transference\Messages\ProcessTransferenceRequest\Publisher;
use Illuminate\Http\Request;

class Handler implements HandlerInterface
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
    public function handle(Request $request) : HandlerResult
    {
        try {
            $originUser = $request->route('id');
            $payload = $request->all();

            $validationErrors = Validator::validate($originUser, $payload);

            if (sizeof($validationErrors)) {
                return new HandlerResult($request, null, $validationErrors);
            }

            $originUserInstance = $this->userRepository->find($originUser);
            $targetUserInstance = $this->userRepository->find($payload['target_user']);

            $payment = new Payment($originUserInstance, $targetUserInstance, $payload['value']);

            (new Publisher)->publish(serialize($payment)); //Executing payment asynchronously
            //$this->userPaymentService->execute($payment); //Execute payment in User Request

            return new HandlerResult($request, $payment);
        } catch (\Exception $exception) {
            return new HandlerResult($request, null, [$exception->getCode() => $exception->getMessage()]);
        }
    }
}
