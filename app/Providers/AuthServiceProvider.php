<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Application as ApplicationModels;
use App\Policies\Application as ApplicationPolicies;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ApplicationModels\User::class => ApplicationPolicies\UsersPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
