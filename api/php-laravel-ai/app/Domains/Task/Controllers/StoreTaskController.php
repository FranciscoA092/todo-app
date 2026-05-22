<?php

namespace App\Domains\Task\Controllers;

use App\Domains\Project\Models\Project;
use App\Domains\Task\Actions\CreateTaskAction;
use App\Domains\Task\DTOs\CreateTaskDTO;
use App\Domains\Task\Requests\StoreTaskRequest;
use App\Domains\Task\Resources\TaskResource;
use Illuminate\Http\JsonResponse;

class StoreTaskController
{
    public function __construct(
        private readonly CreateTaskAction $createTaskAction,
    ) {}

    public function __invoke(StoreTaskRequest $request, Project $project): JsonResponse
    {
        $task = $this->createTaskAction->execute(
            CreateTaskDTO::fromArray($request->validated()),
            $project,
        );

        return response()->json(new TaskResource($task), 201);
    }
}
