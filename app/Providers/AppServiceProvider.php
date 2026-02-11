<?php

namespace App\Providers;

use App\Events\TaskAssignedUsersChanged;
use App\Listeners\TaskAssignedUsersHistory;
use App\Models\Task;
use App\Models\TaskComment;
use App\Observers\TaskCommentObserver;
use App\Observers\TaskObserver;
use App\Repositories\Contracts\Task\TaskRepositoryInterface;
use App\Repositories\Contracts\TaskHistory\TaskHistoryRepositoryInterface;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use App\Repositories\TaskHistoryRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\Contracts\Auth\AuthServiceInterface;
use App\Services\Contracts\Task\TaskServiceInterface;
use App\Services\Contracts\TaskHistory\TaskHistoryServiceInterface;
use App\Services\Contracts\User\UserServiceInterface;
use App\Services\TaskHistoryService;
use App\Services\TaskService;
use App\Services\UserService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);

        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(TaskServiceInterface::class, TaskService::class);

        $this->app->bind(TaskHistoryRepositoryInterface::class, TaskHistoryRepository::class);
        $this->app->bind(TaskHistoryServiceInterface::class, TaskHistoryService::class);


        $this->app->singleton(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Task::observe(TaskObserver::class);
        TaskComment::observe(TaskCommentObserver::class);
        Event::listen(TaskAssignedUsersChanged::class, TaskAssignedUsersHistory::class);
    }
}
