<?php

namespace App\Http\Requests\StudentsApp\Auth;

use App\Rules\CPF;
use Illuminate\Foundation\Http\FormRequest;

class AuthenticateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'cpf' => preg_replace('/[^0-9]/is', '', $this->input('cpf', '')),
        ]);
    }

    public function rules(): array
    {
        return [
            'cpf'      => ['required', 'min:11', 'max:14', new CPF()],
            'password' => ['required', 'min:8', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'cpf'      => 'CPF',
            'password' => 'senha',
        ];
    }
}
