<?php

namespace App\Providers;

use App\Policies\TaskPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class PolicyServiceProvider extends ServiceProvider
{
    protected $policies = [
        'user' => UserPolicy::class,
        'task' => TaskPolicy::class,
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
        $this->registerPolicies();

        foreach ($this->policies as $name => $policy) {
            $methods = get_class_methods($policy);

            Gate::resource($name, $policy, array_combine($methods, $methods));
        }
    }
}
