<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImagesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image' => 'storage/images/aaaa.jpg',
            'main_img' => random_int(0, 1),
            'title' => $this->faker->title,
            'alt' => $this->faker->alt,
            'stt_img' => random_int(1, 100),
        ];
    }
}
