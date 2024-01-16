<?php

namespace App\Http\Controllers\Application\OnBoardingForm;

use App\Http\Controllers\Controller;
use App\Models\Application\OnBoardingForm;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __invoke()
    {
        $this->authorize('viewAny', OnBoardingForm::class);

        $onBoardings = OnBoardingForm::query()
            ->orderBy('cicle', 'asc')
            ->get();

        return Inertia::render('OnBoardingForm/Index', [
            'onBoardings' => $onBoardings,
        ]);
    }
}
