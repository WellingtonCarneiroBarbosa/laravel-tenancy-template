<?php

namespace App\Http\Controllers\Application\OnBoardingForm;

use App\Actions\Application\OnBoardingForm\Create;
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
        $creator = new Create($request);

        $creator->execute();

        return redirect()->route('app.on-boarding-form.index')
            ->with('flash', [
                'type'    => 'success',
                'message' => 'Formulário de Onboarding criado com sucesso!',
            ]);
    }
}
