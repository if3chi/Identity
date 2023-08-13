<?php

declare(strict_types=1);

namespace App\Processes;

use App\Processes\Tasks\CreateUserTask;
use App\Processes\Tasks\CreateTokenForUserTask;

final class RegistrationProcess extends AbstractProcess
{
    public array $tasks = [
        CreateUserTask::class,
        CreateTokenForUserTask::class,
    ];
}
