<?php

namespace App\Providers;

use App\Events\TaskAssignedUsersChanged;
use App\Listeners\TaskAssignedUsersHistory;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected array $listen = [
        TaskAssignedUsersChanged::class => [
            TaskAssignedUsersHistory::class,
        ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
