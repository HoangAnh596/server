<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CmtNewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->text(20),
            'parent_id' => random_int(0, 100),
            'new_id' => random_int(0, 1500),
            'user_id' => random_int(0, 5),
            'name' => $this->faker->name,
            'slugNew' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'star' => random_int(0, 5),
        ];
    }
}
