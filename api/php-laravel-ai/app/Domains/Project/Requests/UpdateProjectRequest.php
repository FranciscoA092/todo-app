<?php

namespace App\Domains\Project\Requests;

use App\Domains\Project\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $project = $this->route('project');
        $projectId = $project instanceof Project ? $project->id : $project;

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects', 'title')->ignore($projectId),
            ],
            'description' => [
                'required',
                'string',
            ],
        ];
    }
}
