<?php

namespace App\Services\User\Payment;

use App\Domain\Payment;
use Illuminate\Http\Request;

class Result
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Payment
     */
    private $payment;

    /**
     * @var array
     */
    private $errors;

    /**
     * Result constructor.
     * @param Request $request
     * @param Payment $payment
     * @param array $errors
     */
    public function __construct(Request $request, Payment $payment = null, array $errors = [])
    {
        $this->request = $request;
        $this->payment = $payment;
        $this->errors = $errors;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return Payment
     */
    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
