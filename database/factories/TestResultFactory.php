<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestResultFactory extends Factory
{
    public function definition()
    {
        return [
            'reading_text' => $this->faker->paragraphs(3, true),
            'writing_response' => $this->faker->paragraphs(5, true),
            'reading_score' => $this->faker->numberBetween(50, 100),
            'writing_score' => $this->faker->numberBetween(50, 100),
            'total_score' => function (array $attributes) {
                return round(($attributes['reading_score'] + $attributes['writing_score']) / 2);
            },
        ];
    }
}