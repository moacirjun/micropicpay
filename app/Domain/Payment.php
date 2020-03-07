<?php

namespace App\Domain;

use App\Entity\User;

class Payment
{
    /**
     * Origin User
     * @var User
     */
    private $originUser;

    /**
     * Target User
     * @var User
     */
    private $targetUser;

    /**
     * Value of payment
     * @var float
     */
    private $value;

    public function __construct(User $originUser, User $targetUser, float $value)
    {
        $this->originUser = $originUser;
        $this->targetUser = $targetUser;
        $this->value = $value;
    }

    /**
     * @return User
     */
    public function getOriginUser() : User
    {
        return $this->originUser;
    }

    /**
     * @return User
     */
    public function getTargetUser() : User
    {
        return $this->targetUser;
    }

    /**
     * @return double
     */
    public function getValue() : float
    {
        return $this->value;
    }
}
