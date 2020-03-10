<?php

namespace App\Services\Transference\Process;

use App\Domain\Payment;
use App\Contracts\Services\Transference\ServiceInterface as TransferenceServiceInterface;
use App\Contracts\Services\User\Payment\ServiceInterface as UserPaymentServiceInterface;
use App\Contracts\Services\User\Payment\ValidatorInterface as UserPaymentValidatorInterface;
use App\Contracts\Services\Transference\Message\RabbitMQPublisherInterface;

class Service implements UserPaymentServiceInterface
{
    /**
     * @var TransferenceServiceInterface
     */
    private $transferenceService;

    /**
     * @var UserPaymentValidatorInterface
     */
    private $validator;

    /**
     * @var RabbitMQPublisherInterface
     */
    private $rabbitMQPublisher;

    /**
     * Service constructor.
     * @param TransferenceServiceInterface $transferenceService
     * @param UserPaymentValidatorInterface $validator
     * @param RabbitMQPublisherInterface $rabbitMQPublisher
     */
    public function __construct(
        TransferenceServiceInterface $transferenceService,
        UserPaymentValidatorInterface $validator,
        RabbitMQPublisherInterface $rabbitMQPublisher
    ) {
        $this->transferenceService = $transferenceService;
        $this->validator = $validator;
        $this->rabbitMQPublisher = $rabbitMQPublisher;
    }

    /**
     * Process the transference
     * @param Payment $payment
     */
    public function execute(Payment $payment)
    {
        $validationErrors = $this->validator->validate($payment);

        if (sizeof($validationErrors)) {
            throw new \InvalidArgumentException('Erro de validação de pagamento');
        }

        $transference = $this->transferenceService->processPayment($payment);

        $this->rabbitMQPublisher->publish($transference->toArray());
    }
}
