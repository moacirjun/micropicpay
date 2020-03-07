<?php

namespace App\Jobs;

use App\Domain\Payment;
use App\Services\User\Payment\Service as UserPaymentService;

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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        UserPaymentService::execute($this->payment);
    }
}
