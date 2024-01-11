<?php

namespace App\Http\Controllers\StudentsApp\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentsApp\Auth\AuthenticateRequest;
use App\Models\Application\User;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Auth/Login');
    }

    public function authenticate(AuthenticateRequest $request)
    {
        $data = $request->validated();

        try {
            $user = User::whereCpf($data['cpf'])->firstOrFail();
        } catch (ModelNotFoundException) {
            throw ValidationException::withMessages([
                'cpf' => 'O CPF informado não está cadastrado. Entre em contato com seu treinador.',
            ]);
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'A senha informada está incorreta. Verifique os dígitos e tente novamente.',
            ]);
        }

        $request->session()->invalidate();

        $request->session()->put('user', $user);

        tenant()->run(function () use ($user) {
            Auth::login($user, true);
        });

        return Inertia::resolved(function () {
            return redirect()->intended(route('students-app.initialized-app.home', [
                'tenant' => tenant('id'),
            ]));
        });
    }
}
