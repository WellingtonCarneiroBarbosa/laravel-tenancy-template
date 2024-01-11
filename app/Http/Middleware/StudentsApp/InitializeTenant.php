<?php

namespace App\Http\Middleware\StudentsApp;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Stancl\Tenancy\Exceptions\RouteIsMissingTenantParameterException;
use Stancl\Tenancy\Resolvers\PathTenantResolver;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Route $route */
        $route = $request->route();

        if ($tenant = session('tenant')) {
            if ($route->parameterNames()[0] === PathTenantResolver::$tenantParameterName && $route->parameter(PathTenantResolver::$tenantParameterName) === $tenant->id) {
                tenancy()->initialize($tenant);
            } else {
                session()->forget('tenant');
            }
        }

        throw_if($route->parameterNames()[0] !== PathTenantResolver::$tenantParameterName, new RouteIsMissingTenantParameterException());

        $id = $route->parameter(PathTenantResolver::$tenantParameterName);

        $tenant = \App\Models\Tenant::findOrFail($id);

        tenancy()->initialize($tenant);

        session()->put('tenant', $tenant);

        return $next($request);
    }
}
