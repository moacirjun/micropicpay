<?php


namespace App\Services\User\Payment\Request;

class Validator
{
    /**
     * Verify origin and target user exists, and if 'value' field is set
     * @param $originUserId
     * @param array $data
     * @return array
     */
    public static function validate($originUserId, array $data)
    {
        $array = array_merge($data, ['origin_user' => $originUserId]);

        return \Illuminate\Support\Facades\Validator::make($array, [
            'target_user' => 'required|numeric|exists:App\Entity\User,id',
            'origin_user' => 'required|numeric|exists:App\Entity\User,id',
            'value' => 'required|numeric'
        ])->errors()->toArray();
    }
}
