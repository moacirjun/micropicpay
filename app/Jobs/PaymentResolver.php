<?php

namespace App\Jobs;

use App\Domain\Payment;
use App\Contracts\Services\User\Payment\ServiceInterface as UserPaymentServiceInterface;

class PaymentResolver extends Job
{
    /**
     * @var string
     */
    public $queue = 'payment-resolver';

    /**
     * @var array
     */
    public $payment;

    /**
     * PaymentResolver constructor.
     * @param Payment $payment
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * @param UserPaymentServiceInterface $service
     */
    public function handle(UserPaymentServiceInterface $service)
    {
        $service->execute($this->payment);
    }
}
