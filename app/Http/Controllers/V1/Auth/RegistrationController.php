<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth;

use Illuminate\Http\Response;
use App\Http\Responses\TokenResponse;
use App\Processes\RegistrationProcess;
use App\Http\Requests\V1\Auth\RegistrationRequest;

final class RegistrationController
{
    public function __construct(
        private readonly RegistrationProcess $process,
    ) {
    }

    public function __invoke(RegistrationRequest $request): TokenResponse
    {
        $process = $this->process->handle(
            payload: $request->payloads(),
        );

        return new TokenResponse(
            token: $process->token,
            status: Response::HTTP_CREATED,
        );
    }
}