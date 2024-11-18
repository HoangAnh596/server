<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
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
            'slug' => $this->faker->slug,
            'parent_id' => random_int(0, 100),
            'user_id' => random_int(0, 1),
            'image' => 'storage/images/aaaa.jpg',
            'content' => $this->faker->text(20),
            'title_img' => $this->faker->name,
            'alt_img' => $this->faker->name,
            'title_seo' => $this->faker->name,
            'keyword_seo' => $this->faker->name,
            'des_seo' => $this->faker->name,
        ];
    }
}
