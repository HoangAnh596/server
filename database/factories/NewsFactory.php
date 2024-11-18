<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
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
            'slug' => Str::slug($this->faker->name),
            'slugParent' => Str::slug($this->faker->name),
            'cate_id' => random_int(1, 500),
            'user_id' => random_int(0, 5),
            'content' => $this->faker->text(20),
            'image' => 'storage/images/aaaa.jpg',
            'title_img' => $this->faker->text(20),
            'alt_img' => $this->faker->text(20),
            'title_seo' => $this->faker->text(20),
            'keyword_seo' => $this->faker->text(20),
            'des_seo' => $this->faker->text(20),
        ];
    }
}
