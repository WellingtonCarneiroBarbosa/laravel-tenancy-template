<?php

namespace App\Http\Controllers\Application\OnBoardingForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\OnBoardingForm\UpdateRequest;
use App\Models\Application\OnBoardingForm;
use Inertia\Inertia;

class UpdateController extends Controller
{
    public function __invoke(string $id)
    {
        $onBoardingForm =  OnBoardingForm::query()
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('update', $onBoardingForm);

        return Inertia::render('OnBoardingForm/Edit', [
            'onBoardingForm' => $onBoardingForm,
        ]);
    }

    public function update(UpdateRequest $request, string $id)
    {
        $onBoardingForm =  OnBoardingForm::query()
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('update', $onBoardingForm);

        $data = $request->validated();

        $onBoardingForm->forceFill($data)->save();

        return redirect()->back()
            ->with('flash', [
                'type'    => 'success',
                'message' => "Seu formulário de OnBoarding do ciclo {$onBoardingForm->cicle} foi atualizado.",
            ]);
    }
}
