<?php

use App\Http\Controllers\Api\Task\CreateTaskController;
use App\Http\Controllers\Api\Task\ListTasksController;
use App\Http\Controllers\Api\Task\ShowTaskController;
use App\Http\Controllers\Api\Task\UpdateTaskController;
use App\Http\Controllers\Api\TaskHistory\ListTaskHistoriesController;
use App\Http\Controllers\Api\User\ListUsersController;
use Illuminate\Support\Facades\Route;

require_once __DIR__ . '/auth.php';

Route::prefix('v1')->middleware(['auth:api'])->group(function () {

    Route::prefix('users')->group(function () {
        Route::get('/list', ListUsersController::class)->name('users.list');
    });

    Route::prefix('tasks')->group(function () {
        Route::get('/list', ListTasksController::class)->name('tasks.list');
        Route::post('/create', CreateTaskController::class)->name('tasks.create');
        Route::put('/{id}/update', UpdateTaskController::class)->name('tasks.update');
        Route::get('/{id}/show', ShowTaskController::class)->name('tasks.show');
    });

    Route::prefix('task-histories')->group(function () {
        Route::get('/list', ListTaskHistoriesController::class)->name('task-histories.list');
    });
});
