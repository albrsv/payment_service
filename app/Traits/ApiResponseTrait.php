<?php

declare(strict_types=1);

namespace App\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;

trait ApiResponseTrait
{
    const string FAILURE = 'failure';
    const string SUCCESS = 'success';

    public function jsonResponse(?string $status, ?string $message, ?array $data, int $code = 200): JsonResponse
    {
        return new JsonResponse([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function jsonSuccessResponse(?string $message = null, ?array $data = null, int $code = 200): JsonResponse
    {
        return $this->jsonResponse(self::SUCCESS, $message, $data, $code);
    }

    public function jsonFailureResponse(?string $message = null, ?array $data = null, int $code = 400): JsonResponse
    {
        return $this->jsonResponse(self::FAILURE, $message, $data, $code);
    }
}
