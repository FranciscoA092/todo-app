<?php

namespace App\Domains\Project\Controllers;

use App\Domains\Project\Actions\DeleteProjectAction;
use App\Domains\Project\Models\Project;
use Illuminate\Http\JsonResponse;

class DestroyProjectController
{
    public function __construct(
        private readonly DeleteProjectAction $deleteProjectAction,
    ) {}

    public function __invoke(Project $project): JsonResponse
    {
        $this->deleteProjectAction->execute($project);

        return response()->json([
            'message' => 'Projeto excluido com sucesso',
        ]);
    }
}
