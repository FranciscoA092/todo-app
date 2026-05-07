<?php

namespace App\Domains\Project\Controllers;

use App\Domains\Project\Actions\CreateProjectAction;
use App\Domains\Project\DTOs\CreateProjectDTO;
use App\Domains\Project\Requests\StoreProjectRequest;
use App\Domains\Project\Resources\ProjectResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreProjectController
{
    public function __construct(
        private CreateProjectAction $createProjectAction
    ) {}

    public function __invoke(
        StoreProjectRequest $request
    ): JsonResponse
    {
        return response()->json(
            new ProjectResource(
                $this->createProjectAction->execute(
                    CreateProjectDTO::fromArray($request->validated())
                )
            )
        );
    }
}
