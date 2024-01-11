<?php

namespace App\Http\Middleware\StudentsApp;

use Illuminate\Http\Request;

class Authenticated
{
    public function handle(Request $request, $next, string $guard)
    {
        $authenticated = tenant()->run(function () use ($guard) {
            return auth()->check($guard);
        });

        if (!$authenticated) {
            return redirect(
                $this->redirectTo($request)
            );
        }

        return $next($request);
    }

    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : (
            tenant()?->id ? route('students-app.initialized-app.auth.login', [
                'tenant' => tenant()->id,
            ]) : route('students-app.index')
        );
    }
}
