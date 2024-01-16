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
        $this->authorize('create', OnBoardingForm::class);

        $lastOnBoarding = OnBoardingForm::query()
            ->orderBy('cicle', 'desc')
            ->first();

        return Inertia::render('OnBoardingForm/Create', [
            'lastOnBoarding' => $lastOnBoarding,
        ]);
    }

    public function store(OnBoardingFormCreateRequest $request)
    {
        $data = $request->validated();

        $lastOnBoarding = OnBoardingForm::query()
            ->orderBy('cicle', 'desc')
            ->first();

        $onBoarding        = new OnBoardingForm();
        $onBoarding->cicle = $lastOnBoarding ? $lastOnBoarding->cicle + 1 : 1;

        $onBoarding->forceFill($data)->save();

        return redirect()->route('app.on-boarding-form.index')
            ->with('flash', [
                'type'    => 'success',
                'message' => 'Formulário de Onboarding criado com sucesso!',
            ]);
    }
}
