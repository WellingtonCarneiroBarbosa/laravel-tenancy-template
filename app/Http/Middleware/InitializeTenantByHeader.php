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
        $tenantId = $request->header('X-Tenant-Id');

        if (!$tenantId) {
            abort(400, 'X-Tenant-Id header is missing');
        }

        $tenant = \App\Models\Tenant::find($tenantId);

        if (!$tenant) {
            abort(403, 'X-Tenant-Id header is invalid');
        }

        if ($request->user()->currentTeam->id != $tenant->id) {
            abort(400, 'The current team is not the same as the tenant');
        }

        tenancy()->initialize($tenant);

        return $next($request);
    }
}
