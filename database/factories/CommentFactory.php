<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
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
            'product_id' => random_int(0, 5000),
            'user_id' => random_int(0, 50),
            'name' => $this->faker->name,
            'slugProduct' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'star' => random_int(0, 5),
        ];
    }
}
