<?php

namespace App\Http\Requests\Application\Users;

use App\Models\Application\User;
use App\Rules\CPF;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;

class UpdateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'access_expires_at' => $this->access_expires_at ?? 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'name'              => ['required', 'max:255'],
            'email'             => [
                'required',
                'email:filter',
                (new Unique(User::class, 'email'))
                    ->ignore($this->route('user')),
            ],
            'cpf'               => ['sometimes', 'nullable', new CPF()],
            'access_expires_at' => ['required'],
        ];
    }
}
