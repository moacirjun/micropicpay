<?php

namespace App\Services\Transference\Request\HttpRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class JsonResponseFactory
{
    /**
     * @param HandlerResult $result
     * @return JsonResponse
     */
    public static function make(HandlerResult $result) : JsonResponse
    {
        if (sizeof($result->getErrors()) === 0) {
            return response()->json(
                [
                    'message' => 'Sua solicitação de pagamento foi recebida. ' .
                                'Você será notificado quando o pagamento for concluído!'
                ],
                Response::HTTP_CREATED
            );
        }

        return response()->json([
                'message' => 'Não foi possível solicitar o pagamento!',
                'errors' => $result->getErrors()
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
