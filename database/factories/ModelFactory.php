<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entity\User;
use App\Entity\Wallet;
use App\Enums\UserType;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->defineAs(User::class, UserType::INDIVIDUAL()->getKey(), function (Faker $faker) {
    return [
        'name' => $faker->name,
        'age' => $faker->randomDigit,
        'type' => UserType::INDIVIDUAL()->getValue()
    ];
});

$factory->defineAs(User::class, UserType::CORPORATION()->getKey(), function (Faker $faker) {
    return [
        'name' => $faker->name,
        'age' => $faker->randomDigit,
        'type' => UserType::CORPORATION()->getValue()
    ];
});

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'amount' => $faker->randomFloat(2, 10, 1000),
    ];
});
