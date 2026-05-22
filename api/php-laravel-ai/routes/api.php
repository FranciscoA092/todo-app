<?php

use App\Domains\Project\Controllers\StoreProjectController;
use Illuminate\Support\Facades\Route;

Route::post('/projects', StoreProjectController::class)
    ->name('projects.store');
