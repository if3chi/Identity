<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth;

use Throwable;
use App\Commands\CreateUserToken;
use Illuminate\Support\Facades\Auth;
use App\Http\Responses\TokenResponse;
use App\Exceptions\FailedToCreateToken;
use App\Http\Requests\V1\Auth\LoginRequest;
use Illuminate\Contracts\Support\Responsable;

final readonly class LoginController
{

    public function __construct(private CreateUserToken $command)
    {
    }

    public function __invoke(LoginRequest $request): Responsable
    {
        $request->authenticate();

        try {
            $token = $this->command->handle(
                /** @phpstan-ignore-next-line */
                user: Auth::user(),
                name: 'Tokn',
                abilities: ['*']
            );

            return new TokenResponse(token: $token);
        } catch (Throwable $e) {
            throw new FailedToCreateToken(
                message: "Authenticated, but failed to ceate API token.",
                code: $e->getCode(),
                previous: $e
            );
        }
    }
}
