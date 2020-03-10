<?php

namespace App\Exceptions;

use Throwable;

class TransferenceValidationException extends \InvalidArgumentException
{
    /**
     * @var array
     */
    private $errors;

    public function __construct($message = "", array $errors = [], $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
