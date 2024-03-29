<?php

namespace App\Http\Middleware\UsersApp;

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
            tenant()?->id ? route('users-app.auth.login', [
                'tenant' => tenant()->id,
            ]) : route('users-app.index')
        );
    }
}
