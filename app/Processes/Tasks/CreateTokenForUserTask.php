<?php

declare(strict_types=1);

namespace App\Processes\Tasks;

use Closure;
use App\Commands\CreateUserToken;
use App\Http\Payloads\V1\NewUser;
use App\Exceptions\FailedToCreateToken;

final class CreateTokenForUserTask
{
    public function __construct(private readonly CreateUserToken $command)
    {
    }

    public function __invoke(NewUser $payload, Closure $next): mixed
    {
        try {
            $payload->token = $this->command->handle(
                user: $payload?->user,
                name: $payload->tokenName,
                abilities: ['*']
            );

            return $next($payload);
        } catch (\Throwable $e) {
            throw new FailedToCreateToken(
                message: "Failed to create api token for user",
                code: $e->getCode(),
                previous: $e
            );
        }
    }
}