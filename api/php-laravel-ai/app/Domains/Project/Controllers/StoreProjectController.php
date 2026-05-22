<?php

namespace App\Domains\Project\Controllers;

use App\Domains\Project\Actions\CreateProjectAction;
use App\Domains\Project\DTOs\CreateProjectDTO;
use App\Domains\Project\Requests\StoreProjectRequest;
use App\Domains\Project\Resources\ProjectResource;
use Illuminate\Http\JsonResponse;

class StoreProjectController
{
    public function __construct(
        private readonly CreateProjectAction $createProjectAction,
    ) {}

    public function __invoke(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->createProjectAction->execute(
            CreateProjectDTO::fromArray($request->validated()),
        );

        return response()->json(new ProjectResource($project), 201);
    }
}
