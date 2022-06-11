<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->name(),
            'telp' => $this->faker->phoneNumber(),
            'image_url' => $this->faker->imageUrl(),
            'user_id' => null,
            'address' => $this->faker->address(),
        ];
    }
}
