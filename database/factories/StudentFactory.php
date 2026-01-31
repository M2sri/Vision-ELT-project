<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'branch' => $this->faker->randomElement(['Eldoge', 'Nasr City', 'Online']),
            'age' => $this->faker->numberBetween(18, 35),
            'phone' => $this->faker->phoneNumber,
            'whatsapp' => $this->faker->optional()->phoneNumber,
            'prefer_time' => $this->faker->randomElement(['Morning', 'Afternoon', 'Evening']),
            'attempts' => $this->faker->numberBetween(1, 5),
        ];
    }
}