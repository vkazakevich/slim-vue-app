<?php

namespace App\Http\Actions;

use App\Http\JsonResponse;

class HomeAction
{
    /**
     * Index route action
     *
     * @return JsonResponse
     * @throws \JsonException
     */
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'status' => true
        ]);
    }
}