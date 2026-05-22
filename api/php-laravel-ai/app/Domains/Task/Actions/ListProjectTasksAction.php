<?php

namespace App\Domains\Task\Actions;

use App\Domains\Project\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListProjectTasksAction
{
    public function execute(Project $project): LengthAwarePaginator
    {
        return $project->tasks()
            ->latest('id')
            ->paginate(10);
    }
}