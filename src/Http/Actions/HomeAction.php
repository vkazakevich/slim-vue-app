<?php

namespace App\Http\Actions;

use App\Http\JsonResponse;

/**
 * @OA\Server(url="http://localhost:8080")
 * @OA\Info(title="Book Management System", version="0.1")
 */
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