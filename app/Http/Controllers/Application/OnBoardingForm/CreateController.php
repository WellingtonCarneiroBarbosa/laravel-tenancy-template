<?php

namespace App\Http\Controllers\Application\OnBoardingForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\OnBoardingForm\CreateRequest as OnBoardingFormCreateRequest;
use App\Models\Application\OnBoardingForm;
use Inertia\Inertia;

class CreateController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('OnBoardingForm/Create');
    }

    public function store(OnBoardingFormCreateRequest $request)
    {
        $data = $request->validated();

        $onBoarding = new OnBoardingForm();

        $onBoarding->forceFill($data)->save();

        return response()->json([
            'message' => 'Onboarding form created',
            'data'    => $onBoarding,
        ], 201);
    }
}
