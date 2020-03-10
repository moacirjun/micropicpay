<?php

use App\Domain\Payment;
use App\Enums\UserType;
use App\Services\Transference\Request\Validator;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ProcessTransferenceValidatorTest extends TestCase
{
//    use DatabaseTransactions;

    private $connectionsToTransact = ['mysql'];

    /**
     * @var Validator
     */
    private $validator;

    private $individualUser;
    private $corporationUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = $this->app->make(App\Contracts\Services\User\Payment\ValidatorInterface::class);

        $this->individualUser = factory('App\Entity\User', UserType::INDIVIDUAL()->getKey())->create();
        $this->individualUser->each(function ($user) {
            $user->wallet()->save(factory('App\Entity\Wallet')->make(['amount' => 100]));
        });

        $this->corporationUser = factory('App\Entity\User', UserType::CORPORATION()->getKey())->create();
        $this->corporationUser->each(function ($user) {
            $user->wallet()->save(factory('App\Entity\Wallet')->make(['amount' => 100]));
        });
    }

    public function testOriginUserTypeValidation()
    {
        $invalidPayment = new Payment($this->corporationUser, $this->individualUser, 50);

        $errors = $this->validator->validate($invalidPayment);

        $this->assertGreaterThan(0, sizeof($errors));
        $this->assertEquals('Only individual user can transfer', $errors[0]);
    }

    public function testOriginUserDoesNotHaveEnoughCredits()
    {
        $invalidPayment = new Payment($this->individualUser, $this->corporationUser,101);

        $errors = $this->validator->validate($invalidPayment);

        $this->assertGreaterThan(0, sizeof($errors));
        $this->assertEquals('User does not have enough credit', $errors[0]);
    }
}
