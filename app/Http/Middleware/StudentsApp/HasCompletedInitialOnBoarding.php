<?php

namespace App\Http\Middleware\StudentsApp;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasCompletedInitialOnBoarding
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->initial_on_boarding_completed_at === null) {
            return redirect()->route(
                'students-app.app.initial-on-boarding',
                [
                    'tenant' => tenant('id'),
                ]
            );
        }

        return $next($request);
    }
}
