<?php

namespace App\Http\Controllers\Application\OnBoardingForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\OnBoardingForm\CreateRequest as OnBoardingFormCreateRequest;
use App\Models\Application\OnBoardingForm;
use Inertia\Inertia;

class CreateInitialController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('OnBoardingForm/CreateInitial');
    }

    public function store(OnBoardingFormCreateRequest $request)
    {
        $data = $request->validated();

        $tenant = tenant();

        if (OnBoardingForm::whereApplicationId($tenant->id)->exists()) {
            return response()->json([
                'message' => 'Initial onboarding form already exists',
            ], 400);
        }

        $onBoarding = new OnBoardingForm();

        $onBoarding->forceFill($data)->save();

        return response()->json([
            'message' => 'Initial onboarding form created',
            'data'    => $onBoarding,
        ], 201);
    }
}
