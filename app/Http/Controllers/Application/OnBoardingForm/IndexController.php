<?php

namespace App\Http\Controllers\Application\OnBoardingForm;

use App\Http\Controllers\Controller;
use App\Models\Application\OnBoardingForm;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $onBoardings = OnBoardingForm::query()
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('OnBoardingForm/Index', [
            'onBoardings' => $onBoardings,
        ]);
    }
}
