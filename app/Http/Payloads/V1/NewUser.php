<?php

declare(strict_types=1);

namespace App\Http\Payloads\V1;

use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

final class NewUser
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $password,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
