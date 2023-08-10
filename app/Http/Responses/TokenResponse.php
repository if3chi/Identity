<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Contracts\Support\Responsable;

final class TokenResponse implements Responsable
{
    public function __construct(
        private readonly NewAccessToken $token,
        private readonly int $status = Response::HTTP_OK,
        private readonly array $headers = ['Content-Type' => 'application/json']
    ) {
    }

    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: ['token' => $this->token->plainTextToken],
            status: $this->status,
            headers: $this->headers
        );
    }
}
