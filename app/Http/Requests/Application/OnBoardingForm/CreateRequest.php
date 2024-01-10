<?php

namespace App\Http\Requests\Application\OnBoardingForm;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        $stepsLength = count($this->input('steps', []));

        return [
            'steps' => ['required', 'array', 'min:1'],

            'steps.*.title' => ['required', 'string', 'min:1', 'max:255'],

            'questions' => ['required', 'array', "min:{$stepsLength}"],

            'questions.*.*.title'      => ['required', 'string', 'min:1', 'max:255'],
            'questions.*.*.input_type' => ['required', 'string', 'min:1', 'max:255', 'in:text,textarea,select,checkbox,radio'],

            'questions.*.*.options' => ['required_if:questions.*.input_type,select,checkbox,radio', 'array', 'min:1'],

            'questions.*.*.options.*.title' => ['required', 'string', 'min:1', 'max:255'],
        ];
    }
}
