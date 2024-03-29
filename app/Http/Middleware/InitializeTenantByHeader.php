<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenantByHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader('X-Tenant-Id')) {
            $tenant = \App\Models\Tenant::find($request->header('X-Tenant-Id'));

            if (!$tenant) {
                abort(403, 'Tenant not exists');
            }

            if (tenancy()->initialized) {
                if (tenancy()->tenant->id != $tenant->id) {
                    tenancy()->initialize($tenant);
                }
            } else {
                tenancy()->initialize($tenant);
            }
        }

        if (tenant() === null) {
            abort(403, 'Tenant not exists');
        }

        return $next($request);
    }
}
