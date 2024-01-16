<?php

namespace Database\Factories\Application;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application\UserNote>
 */
class UserNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'       => $this->faker->sentence,
            'description' => $this->faker->words(random_int(10, 30), true),
            'date'        => $this->faker->dateTimeBetween('-1 year', '+1 year'),
        ];
    }
}
