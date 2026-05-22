<?php

namespace App\Domains\Task\Controllers;

use App\Domains\Project\Models\Project;
use App\Domains\Task\Actions\DeleteTaskAction;
use App\Domains\Task\Models\Task;
use Illuminate\Http\JsonResponse;

class DestroyTaskController
{
    public function __construct(
        private readonly DeleteTaskAction $deleteTaskAction,
    ) {}

    public function __invoke(Project $project, Task $task): JsonResponse
    {
        $this->deleteTaskAction->execute($task);

        return response()->json(['message' => 'Atividade excluida com sucesso']);
    }
}
