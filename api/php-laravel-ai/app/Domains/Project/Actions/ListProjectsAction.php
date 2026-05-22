<?php

namespace App\Domains\Project\Actions;

use App\Domains\Project\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListProjectsAction
{
    public function execute(): LengthAwarePaginator
    {
        return Project::query()
            ->latest('id')
            ->paginate(10);
    }
}