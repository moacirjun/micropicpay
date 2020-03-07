<?php

namespace App\Services\User\Payment;

use Illuminate\Http\JsonResponse;

class JsonResponseFactory
{
    /**
     * @param Result $result
     * @return JsonResponse
     */
    public static function make(Result $result) : JsonResponse
    {
        return response()->json(['message' => 'Sua solicitação de pagamento foi recebida. Você será notificado quando o pagamento for concluído!']);
    }
}
