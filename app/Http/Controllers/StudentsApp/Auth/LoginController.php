<?php

namespace App\Http\Controllers\StudentsApp\Auth;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Auth/Login');
    }
}
