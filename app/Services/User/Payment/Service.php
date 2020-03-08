<?php

namespace App\Services\User\Payment;

use App\Domain\Payment;
use App\Contracts\Services\Transference\ServiceInterface as TransferenceServiceInterface;
use App\Services\Transference\Message\Publisher as TransferenceMessagePublisher;
use App\Contracts\Services\User\Payment\ServiceInterface as UserPaymentServiceInterface;

class Service implements UserPaymentServiceInterface
{
    /**
     * @var TransferenceServiceInterface
     */
    private $transferenceService;

    /**
     * Service constructor.
     * @param TransferenceServiceInterface $transferenceService
     */
    public function __construct(TransferenceServiceInterface $transferenceService)
    {
        $this->transferenceService = $transferenceService;
    }

    /**
     * @inheritDoc
     */
    public function execute(Payment $payment)
    {
        $validationErrors = Validator::validate($payment);

        if (sizeof($validationErrors)) {
            throw new \InvalidArgumentException('Erro de validação de pagamento');
        }

        $transference = $this->transferenceService->processPayment($payment);

        TransferenceMessagePublisher::publish($transference);
    }
}
