<?php

declare(strict_types=1);

namespace App\Commands;

use App\Models\User;
use App\Http\Payloads\V1\NewUser;
use Illuminate\Database\DatabaseManager;

final readonly class CreateNewUser
{
    public function __construct(private DatabaseManager $database)
    {
    }

    public function handle(NewUser $payload): User
    {
        return $this->database->transaction(
            callback: fn () => User::query()->create($payload->toArray()),
            attempts: 2
        );
    }
}
