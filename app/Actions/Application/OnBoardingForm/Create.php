<?php

namespace App\Actions\Application\OnBoardingForm;

use App\Http\Requests\Application\OnBoardingForm\CreateRequest;
use App\Models\Application\OnBoardingForm;

class Create
{
    public function __construct(
        protected CreateRequest $request
    ) {
        //
    }

    public function execute(): OnBoardingForm
    {
        $data = $this->request->validated();

        $lastOnBoarding = OnBoardingForm::query()
            ->orderBy('cicle', 'desc')
            ->first();

        $onBoarding        = new OnBoardingForm();
        $onBoarding->cicle = $lastOnBoarding ? $lastOnBoarding->cicle + 1 : 1;

        $onBoarding->forceFill($data)->save();

        return $onBoarding;
    }
}
