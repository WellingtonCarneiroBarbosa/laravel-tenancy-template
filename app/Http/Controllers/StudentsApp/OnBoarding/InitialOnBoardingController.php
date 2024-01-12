<?php

namespace App\Http\Controllers\StudentsApp\OnBoarding;

use App\Http\Controllers\Controller;
use App\Models\Application\OnBoardingForm;
use Inertia\Inertia;

class InitialOnBoardingController extends Controller
{
    public function __invoke()
    {
        $onBoardingForm = OnBoardingForm::where('is_initial', true)->firstOrFail();

        return Inertia::render('App/OnBoarding/InitialOnBoarding/Index', [
            'onBoardingForm' => $onBoardingForm,
        ]);
    }
}
