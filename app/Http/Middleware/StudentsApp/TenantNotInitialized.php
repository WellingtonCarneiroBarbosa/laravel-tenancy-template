<?php

namespace App\Http\Middleware\StudentsApp;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantNotInitialized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (tenancy()->initialized || session('tenant') !== null) {
            $tenantId = tenancy()->tenant?->id ?? session('tenant')->id;

            return redirect()->route('students-app.initialized-app.home', [
                'tenant' => $tenantId,
            ]);
        }

        return $next($request);
    }
}
