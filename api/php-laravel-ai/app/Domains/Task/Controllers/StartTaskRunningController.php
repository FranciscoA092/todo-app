<?php

namespace App\Domains\Task\Controllers;

use App\Domains\Project\Models\Project;
use App\Domains\Task\Actions\StartTaskRunningAction;
use App\Domains\Task\Models\Task;
use Illuminate\Http\JsonResponse;

class StartTaskRunningController
{
    public function __construct(
        private readonly StartTaskRunningAction $startTaskRunningAction,
    ) {}

    public function __invoke(Project $project, Task $task): JsonResponse
    {
        $this->startTaskRunningAction->execute($task);

        return response()->json(['message' => 'Execução da atividade iniciada com sucesso']);
    }
}
