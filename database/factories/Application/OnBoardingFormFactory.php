<?php

namespace Database\Factories\Application;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application\OnBoardingForm>
 */
class OnBoardingFormFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $steps = $this->fakeSteps();

        return [
            'steps'     => $steps,
            'questions' => $this->fakeQuestions($steps),
        ];
    }

    private function fakeQuestions(array $steps): array
    {
        return array_map(function (array $step) {
            $questions = random_int(1, 5);


            return [
                'step'      => $step['order'],
                'questions' => array_map(function (int $question) {
                    $inputType = $this->faker->randomElement(['text', 'textarea', 'select', 'radio', 'checkbox']);

                    $inputOptionsValues = null;
                    $inputOptionsLabels = null;

                    if (in_array($inputType, ['select', 'radio', 'checkbox'])) {
                        $options = random_int(2, 5);

                        $inputOptionsValues = array_map(function (int $option) {
                            return $this->faker->word;
                        }, range(1, $options));

                        $inputOptionsLabels = array_map(function (int $option) {
                            return $this->faker->word;
                        }, range(1, $options));
                    }

                    return [
                        'title'                 => $this->faker->sentence,
                        'description'           => $this->faker->paragraph,
                        'input_type'            => $inputType,
                        'input_options_values'  => $inputOptionsValues,
                        'input_options_labels'  => $inputOptionsLabels,
                        'order'                 => $question,
                    ];
                }, range(1, $questions)),
            ];
        }, $steps);
    }

    private function fakeSteps(): array
    {
        $steps = random_int(4, 10);

        return array_map(function (int $step) {
            return [
                'title'       => $this->faker->sentence,
                'description' => $this->faker->paragraph,
                'order'       => $step,
            ];
        }, range(1, $steps));
    }
}
