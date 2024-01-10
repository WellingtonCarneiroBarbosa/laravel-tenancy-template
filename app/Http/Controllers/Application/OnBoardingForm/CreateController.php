<?php

namespace App\Http\Controllers\Application\OnBoardingForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\OnBoardingForm;

class CreateController extends Controller
{
    public function __invoke(OnBoardingForm\CreateRequest $request)
    {
        dd(tenant());

        $data = $request->validated();

        dd($data);
    }
}
