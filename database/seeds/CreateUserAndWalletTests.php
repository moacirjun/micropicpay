<?php

use Illuminate\Database\Seeder;
use App\Entity\User;
use App\Enums\UserType;
use \Illuminate\Support\Facades\DB;

class CreateUserAndWalletTests extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userOne = User::query()->create([
            'name' => 'Charlinho Menezes',
            'age' => 23,
            'type' => UserType::INDIVIDUAL()->getValue(),
        ]);
        $userTwo = User::query()->create([
            'name' =>  'Bruno vieira',
            'age' => 43,
            'type' => UserType::CORPORATION()->getValue(),
        ]);
        $userThree = User::query()->create([
            'name' =>  'Alberto Cunha',
            'age' => 20,
            'type' => UserType::INDIVIDUAL()->getValue(),
        ]);

        DB::table('tb_wallet')->insert([
            [
                'amount' => 100,
                'user_id' => $userOne->id,
                'created_at' => date('Y-m-d H:s:i'),
                'updated_at' => date('Y-m-d H:s:i'),
            ], [
                'amount' => 100,
                'user_id' => $userTwo->id,
                'created_at' => date('Y-m-d H:s:i'),
                'updated_at' => date('Y-m-d H:s:i'),
            ], [
                'amount' => 100,
                'user_id' => $userThree->id,
                'created_at' => date('Y-m-d H:s:i'),
                'updated_at' => date('Y-m-d H:s:i'),
            ],
        ]);

    }
}
