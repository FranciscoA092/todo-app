<?php

use App\Domains\Project\Controllers\IndexProjectController;
use App\Domains\Project\Controllers\StoreProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/projects', IndexProjectController::class)
    ->name('projects.index');

Route::post('/projects', StoreProjectController::class)
    ->name('projects.store');
