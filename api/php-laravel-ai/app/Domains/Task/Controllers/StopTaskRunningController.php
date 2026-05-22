<?php

namespace App\Domains\Task\Controllers;

use App\Domains\Project\Models\Project;
use App\Domains\Task\Actions\StopTaskRunningAction;
use App\Domains\Task\Models\Task;
use Illuminate\Http\JsonResponse;

class StopTaskRunningController
{
    public function __construct(
        private readonly StopTaskRunningAction $stopTaskRunningAction,
    ) {}

    public function __invoke(Project $project, Task $task): JsonResponse
    {
        $this->stopTaskRunningAction->execute($task);

        return response()->json(['message' => 'Execução parada']);
    }
}
