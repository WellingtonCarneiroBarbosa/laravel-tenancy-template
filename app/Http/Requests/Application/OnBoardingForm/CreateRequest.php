<?php

namespace App\Http\Requests\Application\OnBoardingForm;

use Illuminate\Foundation\Http\FormRequest;
use Str;

class CreateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $questions = $this->input('questions', []);

        foreach ($questions as $stepKey => $q) {
            $questions[$stepKey]['questions'] = array_map(function ($question) {
                $base = [
                    'type'     => $question['type'] ?? null,
                    'question' => $question['question'] ?? null,
                    'options'  => $question['options'] ?? [],
                ];

                if (in_array($base['type'], ['checkbox', 'radio', 'select'])) {
                    $base['options'] = array_map(function ($option) {
                        return [
                            'label' => $option['label'] ?? '',
                            'value' => Str::slug(
                                preg_replace('/[^A-Za-z0-9\-]/', '', strtolower($option['label']) ?? '')
                            ),
                        ];
                    }, $base['options']);
                } else {
                    unset($base['options']);
                }

                return $base;
            }, $q['questions']);
        }

        $this->merge([
            'questions' => $questions,
        ]);
    }

    public function rules(): array
    {
        $stepsLength = count($this->input('steps', []));

        return [
            'steps' => ['required', 'array', 'min:1'],

            'steps.*.title' => ['required', 'string', 'min:1', 'max:255'],

            'questions' => ['required', 'array', "min:{$stepsLength}"],

            'questions.questions.*.title'      => ['required', 'string', 'min:1', 'max:255'],
            'questions.questions.*.type'       => ['required', 'string', 'min:1', 'max:255', 'in:text,textarea,select,checkbox,radio'],

            'questions.questions.*.options' => ['required_if:questions.questions.type,select,checkbox,radio', 'array', 'min:1'],

            'questions.questions.*.options.*.title' => ['required', 'string', 'min:1', 'max:255'],
        ];
    }
}
