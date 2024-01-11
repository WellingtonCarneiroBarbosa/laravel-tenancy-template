<?php

namespace App\Http\Middleware\StudentsApp;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Stancl\Tenancy\Exceptions\RouteIsMissingTenantParameterException;
use Stancl\Tenancy\Resolvers\PathTenantResolver;

class InitializeTenant
{
    public function handle(Request $request, $next)
    {
        /** @var Route $route */
        $route = $request->route();

        if ($tenant = session('tenant')) {
            if ($route->parameterNames()[0] === PathTenantResolver::$tenantParameterName && $route->parameter(PathTenantResolver::$tenantParameterName) === $tenant->id) {
                tenancy()->initialize($tenant);

                return $next($request);
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
