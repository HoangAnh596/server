<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MakerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->regexify('[A-Z0-9]{5,20}'),
            'name' => $this->faker->name,
            'image' =>  $this->faker->image('storage/app/public/images/markers', 640, 480, null, false),
        ];
    }
}
