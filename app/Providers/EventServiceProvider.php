<?php

namespace App\Providers;

use App\Listeners\InitializeTenantByUserTeam;
use App\Models\Team;
use App\Models\Tenant;
use App\Observers\ApplicationObserver;
use App\Observers\TenantObserver;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        Authenticated::class => [
            InitializeTenantByUserTeam::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Team::observe(ApplicationObserver::class);
        Tenant::observe(TenantObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
