<?php

namespace Database\Factories;

use App\Models\Maker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
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
            'user_id' => random_int(0, 1),
            'code' => $this->faker->regexify('[A-Za-z0-9]{5,20}'),
            'price' => $this->faker->randomFloat(8, 2, 10000),
            'image_ids' => json_encode(['1','2','3']),
            'title_seo' => $this->faker->name,
            'keyword_seo' => $this->faker->name,
            'des_seo' => $this->faker->name,
            'des' => $this->faker->text(20),
            'content' => $this->faker->text(20),
        ];
    }
}
