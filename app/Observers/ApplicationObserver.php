<?php

namespace App\Observers;

use App\Models\Team;
use App\Models\Tenant;

class ApplicationObserver
{
    public function created(Team $team): void
    {
        $tenant =  new Tenant();
        $tenant->forceFill([
            'id'   => $team->id,
            'name' => $team->name,
        ])->save();
    }

    /**
     * Handle the Team "updated" event.
     */
    public function updated(Team $team): void
    {
        if ($team->wasChanged('name')) {
            Tenant::find($team->id)->forceFill([
                'name' => $team->name,
            ])->save();
        }
    }

    /**
     * Handle the Team "deleted" event.
     */
    public function deleted(Team $team): void
    {
        Tenant::destroy($team->id);
    }

    /**
     * Handle the Team "restored" event.
     */
    public function restored(Team $team): void
    {
        Tenant::withTrashed()->find($team->id)->restore();
    }

    /**
     * Handle the Team "force deleted" event.
     */
    public function forceDeleted(Team $team): void
    {
        Tenant::withTrashed()->find($team->id)->forceDelete();
    }
}
