<?php

use App\Domains\Project\Controllers\IndexProjectController;
use App\Domains\Project\Controllers\DestroyProjectController;
use App\Domains\Project\Controllers\StoreProjectController;
use App\Domains\Project\Controllers\UpdateProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/projects', IndexProjectController::class)
    ->name('projects.index');

Route::post('/projects', StoreProjectController::class)
    ->name('projects.store');

Route::put('/projects/{project}', UpdateProjectController::class)
    ->name('projects.update');

Route::delete('/projects/{project}', DestroyProjectController::class)
    ->name('projects.destroy');
