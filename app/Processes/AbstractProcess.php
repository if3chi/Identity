<?php

declare(strict_types=1);

namespace App\Processes;

use Illuminate\Support\Facades\Pipeline;

abstract class AbstractProcess
{
    public array $tasks = [];

    public function handle(object $payload)
    {
        return Pipeline::send(passable: $payload)
            ->through(pipes: $this->tasks)->thenReturn();
    }
}
