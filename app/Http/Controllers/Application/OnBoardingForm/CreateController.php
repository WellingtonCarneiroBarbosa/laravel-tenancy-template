<?php

namespace App\Http\Controllers\Application\OnBoardingForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\OnBoardingForm\CreateRequest as OnBoardingFormCreateRequest;
use App\Models\Application\OnBoardingForm;

class CreateController extends Controller
{
    public function __invoke(OnBoardingFormCreateRequest $request)
    {
        $data = $request->validated();

        $tenant = tenant();

        if (OnBoardingForm::whereApplicationId($tenant->id)->exists()) {
            return response()->json([
                'message' => 'Onboarding form already exists',
            ], 400);
        }

        $onBoarding = new OnBoardingForm();

        $onBoarding->forceFill($data)->save();

        return response()->json([
            'message' => 'Onboarding form created',
            'data'    => $onBoarding,
        ], 201);
    }
}
