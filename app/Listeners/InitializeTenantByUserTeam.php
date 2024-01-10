<?php

namespace App\Listeners;

use App\Models\Tenant;
use Illuminate\Auth\Events\Authenticated;

class InitializeTenantByUserTeam
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Authenticated $event): void
    {
        if (tenant() !== null) {
            return;
        }

        $tenant = Tenant::whereId($event->user->current_team_id)->firstOrFail();

        tenancy()->initialize($tenant);
    }
}
