<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'gmail' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->numerify('##########'),
            'product' => random_int(0, 10000),
            'user_id' => random_int(0, 5),
            'quantity' => random_int(1, 5000),
        ];
    }
}
