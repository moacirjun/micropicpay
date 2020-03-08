<?php

namespace App\Services\User\Payment;

use App\Domain\Payment;
use \App\Services\Transference\Service as TransferenceService;
use App\Services\Transference\Message\Publisher as TransferenceMessagePublisher;
use App\Contracts\Services\User\Payment\ServiceInterface as UserPaymentServiceInterface;

class Service implements UserPaymentServiceInterface
{
    /**
     * @inheritDoc
     */
    public function execute(Payment $payment)
    {
        $validationErrors = Validator::validate($payment);

        if (sizeof($validationErrors)) {
            throw new \InvalidArgumentException('Erro de validação de pagamento');
        }

        $transference = TransferenceService::processPayment($payment);

        TransferenceMessagePublisher::publish($transference);
    }
}
