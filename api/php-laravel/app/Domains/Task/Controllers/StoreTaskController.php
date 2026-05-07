<?php

namespace App\Domains\Task\Controllers;

use App\Domains\Project\Models\Project;
use App\Domains\Task\Actions\CreateTaskAction;
use App\Domains\Task\DTOs\CreateTaskDTO;
use App\Domains\Task\Request\StoreTaskRequest;
use App\Domains\Task\Resources\TaskResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreTaskController
{
    public function __construct(
        private CreateTaskAction $action
    ) {}

    public function __invoke(
        StoreTaskRequest $request,
        Project $project_id
    ): JsonResponse
    {
        $task = $this->action->execute(
            CreateTaskDTO::fromArray($request->validated()),
            $project_id
        );

        return response()->json(new TaskResource($task), 201);
    }
}
