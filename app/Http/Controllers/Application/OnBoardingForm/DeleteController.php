<?php

namespace App\Http\Controllers\Application\OnBoardingForm;

use App\Http\Controllers\Controller;
use App\Models\Application\OnBoardingForm;

class DeleteController extends Controller
{
    public function __invoke(string $id)
    {
        $onBoardingForm = OnBoardingForm::findOrFail($id);

        $this->authorize('delete', $onBoardingForm);

        $onBoardingForm->delete();

        return redirect()->back()
            ->with('flash', [
                'type'    => 'success',
                'message' => "Seu formulário de OnBoarding do ciclo {$onBoardingForm->cicle} foi deletado.",
            ]);
    }
}
