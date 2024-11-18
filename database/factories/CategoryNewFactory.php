<?php

namespace Database\Factories;

use App\Models\CategoryNew;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryNewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $ids = Category::pluck('id')->toArray();
        return [
            'name' => $this->faker->name,
            'slug' => Str::slug($this->faker->name),
            'related_pro' => json_encode(['1','2','3']),
            'user_id' => random_int(1, 5),
            'parent_id' => random_int(0, 100),
            'title_seo' => $this->faker->text(20),
            'keyword_seo' => $this->faker->text(20),
            'des_seo' => $this->faker->text(20),
        ];
    }
}
