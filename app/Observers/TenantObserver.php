<?php

namespace App\Observers;

use App\Models\Tenant;
use Illuminate\Support\Str;
use Stancl\Tenancy\Database\Models\Domain;

class TenantObserver
{
    /**
     * Handle the Tenant "created" event.
     */
    public function created(Tenant $tenant): void
    {
        $name = preg_replace(
            '/[^A-Za-z0-9\-]/',
            '',
            Str::slug($tenant->name, language: 'pt_BR')
        );

        $host = config('tenancy.hostname');

        $domain = "{$name}.{$host}";

        while (Domain::where('domain', $domain)->exists()) {
            $name .= '-' . Str::random(5);
        }

        Domain::create([
            'domain'    => $domain,
            'tenant_id' => $tenant->id,
        ]);
    }

    /**
     * Handle the Tenant "deleted" event.
     */
    public function deleted(Tenant $tenant): void
    {
        Domain::where('tenant_id', $tenant->id)->delete();
    }

    /**
     * Handle the Tenant "restored" event.
     */
    public function restored(Tenant $tenant): void
    {
        Domain::withTrashed()->where('tenant_id', $tenant->id)->restore();
    }

    /**
     * Handle the Tenant "force deleted" event.
     */
    public function forceDeleted(Tenant $tenant): void
    {
        Domain::withTrashed()->where('tenant_id', $tenant->id)->forceDelete();
    }
}
