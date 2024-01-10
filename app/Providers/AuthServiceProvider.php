<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Application\OnBoardingForm;
use App\Policies\OnBoardingFormPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        OnBoardingForm::class => OnBoardingFormPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
