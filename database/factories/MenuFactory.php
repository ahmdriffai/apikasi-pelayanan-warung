<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'price' => rand(20000, 30000),
            'description' => $this->faker->text(),
            'image_url' => $this->faker->imageUrl(),
            'category_id' => Category::factory()->create(['name' => 'Makanan']),
        ];
    }
}
