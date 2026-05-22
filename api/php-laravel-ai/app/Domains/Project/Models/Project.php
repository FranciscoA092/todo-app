<?php

namespace App\Domains\Project\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** @use HasFactory<ProjectFactory> */
#[Fillable(['title', 'description'])]
class Project extends Model
{
    use HasFactory;

    protected static function newFactory(): ProjectFactory
    {
        return ProjectFactory::new();
    }
}