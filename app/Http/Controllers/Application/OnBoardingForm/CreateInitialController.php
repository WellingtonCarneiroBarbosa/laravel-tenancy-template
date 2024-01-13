<?php

namespace App\Http\Controllers\Application\OnBoardingForm;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class CreateInitialController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('OnBoardingForm/CreateInitial');
    }
}
