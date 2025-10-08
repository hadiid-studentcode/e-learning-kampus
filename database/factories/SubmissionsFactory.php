<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submissions>
 */
class SubmissionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assignment_id' => 1,
            'student_id' => 1,
            'file_path' => $this->faker->sentence(),
            'score' => $this->faker->numberBetween(0, 100),
        ];
    }
}
