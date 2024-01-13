<?php

namespace App\Http\Middleware;

use App\Models\Application\OnBoardingForm;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShouldHaveAtLeastTwoOnBoardingForms
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (OnBoardingForm::count() < 2) {
            if (!OnBoardingForm::where('is_initial', true)->exists()) {
                return redirect()->route('app.on-boarding-form.create-initial')
                    ->with('error', 'Você precisa criar o formulário de onboarding inicial que seu aluno responderá no primeiro acesso ao sistema.');
            };

            return redirect()->route('app.on-boarding-form.create')
                ->with('error', 'Você precisa criar o formulário de onboarding que seu aluno responderá a cada ciclo.');
        }

        return $next($request);
    }
}
