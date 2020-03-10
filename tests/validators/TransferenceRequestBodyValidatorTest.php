<?php

namespace validators;

use App\Enums\UserType;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TransferenceRequestBodyValidatorTest extends \TestCase
{
    use DatabaseTransactions;

    private $individualUser;
    private $corporationUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->individualUser = factory('App\Entity\User', UserType::INDIVIDUAL()->getKey())->create();
        $this->individualUser->each(function ($user) {
            $user->wallet()->save(factory('App\Entity\Wallet')->make(['amount' => 100]));
        });

        $this->corporationUser = factory('App\Entity\User', UserType::CORPORATION()->getKey())->create();
        $this->corporationUser->each(function ($user) {
            $user->wallet()->save(factory('App\Entity\Wallet')->make(['amount' => 100]));
        });
    }

    public function getApiEndpoint(string $originUserID)
    {
        return sprintf('/api/v1/user/%s/pay', $originUserID);
    }

    public function testEmptyTargetUser()
    {
        $this->json('POST', $this->getApiEndpoint($this->individualUser->id), ['value' => 50])
            ->seeStatusCode(400);
    }

    public function testOriginUserNotExists()
    {
        $request = $this->json('POST', $this->getApiEndpoint('xxx'), [
            'value' => 50,
            'target_user' => $this->individualUser->id
        ]);

        $request->seeStatusCode(400);
    }

    public function testTargetUserNotExists()
    {
        $request = $this->json('POST', $this->getApiEndpoint($this->individualUser->id), [
            'value' => 50,
            'target_user' => 'xxx'
        ]);

        $request->seeStatusCode(400);
    }

    public function testEmptyValueField()
    {
        $request = $this->json('POST', $this->getApiEndpoint($this->individualUser->id), [
            'target_user' => $this->corporationUser->id
        ]);

        $request->seeStatusCode(400);
    }

    public function testTargetUserEqualsOriginUSer()
    {
        $request = $this->json('POST', $this->getApiEndpoint($this->individualUser->id), [
            'target_user' => $this->individualUser->id,
            'value' => 50
        ]);

        $request->seeStatusCode(400);
    }

    public function testValidPayload()
    {
        $request = $this->json('POST', $this->getApiEndpoint($this->individualUser->id), [
            'target_user' => $this->corporationUser->id,
            'value' => 50
        ]);

        $request->seeStatusCode(201);
    }
}
