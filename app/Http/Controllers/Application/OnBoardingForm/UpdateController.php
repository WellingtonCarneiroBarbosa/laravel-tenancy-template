<?php

namespace App\Http\Controllers\Application\OnBoardingForm;

use App\Http\Controllers\Controller;
use App\Models\Application\OnBoardingForm;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UpdateController extends Controller
{
    public function __invoke(string $id)
    {
        return Inertia::render('OnBoardingForm/Edit', [
            'onBoardingForm' => OnBoardingForm::query()
                ->where('id', $id)
                ->firstOrFail(),
        ]);
    }

    public function update(Request $request)
    {
    }
}
