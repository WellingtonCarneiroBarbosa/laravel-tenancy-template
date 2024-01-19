<?php

namespace App\Http\Middleware\UsersApp;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class KeepSessionForeverToAuthenticatedUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()) {
            Config::set('session.lifetime', 35791394); // 68 YEARS
        }

        return $next($request);
    }
}
