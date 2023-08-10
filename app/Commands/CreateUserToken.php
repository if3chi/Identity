<?php

declare(strict_types=1);

namespace App\Commands;

use App\Models\User;
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\DatabaseManager;

final readonly class CreateUserToken
{
    public function __construct(private DatabaseManager $database)
    {
    }

    public function handle(User $user, string $name, array $abilities = ['*']): NewAccessToken|Model
    {
        return $this->database->transaction(
            callback: fn () => $user->createToken($name, $abilities),
            attempts: 2
        );
    }
}
