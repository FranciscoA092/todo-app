<?php

namespace App\Domains\Task\Controllers;

use App\Domains\Project\Models\Project;
use App\Domains\Task\Actions\UpdateTaskAction;
use App\Domains\Task\DTOs\UpdateTaskDTO;
use App\Domains\Task\Models\Task;
use App\Domains\Task\Requests\UpdateTaskRequest;
use Illuminate\Http\JsonResponse;

class UpdateTaskController
{
    public function __construct(
        private readonly UpdateTaskAction $updateTaskAction,
    ) {}

    public function __invoke(UpdateTaskRequest $request, Project $project, Task $task): JsonResponse
    {
        $this->updateTaskAction->execute(
            UpdateTaskDTO::fromArray($request->validated()),
            $task,
        );

        return response()->json(['message' => 'Atividade atualizada com sucesso']);
    }
}
