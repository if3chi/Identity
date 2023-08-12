<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth;

use Throwable;
use Illuminate\Http\Response;
use App\Commands\CreateNewUser;
use App\Commands\CreateUserToken;
use App\Http\Responses\TokenResponse;
use App\Exceptions\FailedToCreateUserRecord;
use App\Http\Requests\V1\Auth\RegistrationRequest;

final class RegistrationController
{
    public function __construct(
        private readonly CreateNewUser $command,
        private readonly CreateUserToken $tokenCommand
    ) {
    }

    public function __invoke(RegistrationRequest $request)
    {
        try {
            $user = $this->command->handle($request->payloads());
        } catch (Throwable $e) {
            throw new FailedToCreateUserRecord(
                message: "Failed to create user",
                code: $e->getCode(),
                previous: $e
            );
        }

        try {
            $token = $this->tokenCommand->handle(
                user: $user,
                name: 'Tokn',
            );

            return new TokenResponse(
                token: $token,
                status: Response::HTTP_CREATED,
            );
        } catch (Throwable $e) {
            throw new FailedToCreateUserRecord(
                message: "Failed to create token for user.",
                code: $e->getCode(),
                previous: $e
            );
        }
    }
}
