<?php

declare(strict_types=1);

namespace App\Processes\Tasks;

use Closure;
use Throwable;
use App\Commands\CreateNewUser;
use App\Http\Payloads\V1\NewUser;
use App\Exceptions\FailedToCreateUserRecord;

final class CreateUserTask
{
    public function __construct(private readonly CreateNewUser $command)
    {
    }

    public function __invoke(NewUser $payload, Closure $next): mixed
    {
        try {
            $payload->user = $this->command->handle($payload);

            return $next($payload);
        } catch (Throwable $e) {
            throw new FailedToCreateUserRecord(
                message: "Failed to create user with that payload",
                code: $e->getCode(),
                previous: $e
            );
        }
    }
}