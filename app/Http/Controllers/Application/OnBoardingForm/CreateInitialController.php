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
        $this->authorize('createInitial', OnBoardingForm::class);

        return Inertia::render('OnBoardingForm/CreateInitial');
    }

    public function store(OnBoardingFormCreateRequest $request)
    {
        $this->authorize('createInitial', OnBoardingForm::class);

        $data = $request->validated();

        $onBoarding = new OnBoardingForm();

        $onBoarding->forceFill($data)->save();

        return Inertia::resolved(function () {
            return redirect()->route('app.on-boarding-form.index')
                ->with('flash', [
                    'type'    => 'success',
                    'message' => 'Formulário de Onboarding criado com sucesso!',
                ]);
        });
    }
}
