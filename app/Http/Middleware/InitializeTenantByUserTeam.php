<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\IdentificationMiddleware;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;
use Stancl\Tenancy\Tenancy;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenantByUserTeam extends IdentificationMiddleware
{
    public function __construct(Tenancy $tenancy, DomainTenantResolver $resolver)
    {
        $this->tenancy  = $tenancy;
        $this->resolver = $resolver;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('ignores_tenant')) {
            $this->tenancy->initialize($request->user()->current_team_id);
        }

        return $next($request);
    }
}
