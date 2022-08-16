<?php

namespace Database\Factories;

use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->sentence();
        return [
            'sub_category_id' => fake()->numberBetween(1, 10),
            'title' => $title,
            'slug' => Str::slug($title),
            'type' => fake()->numberBetween(1, 4),
            'description' => fake()->text(1000),
            'salary' => fake()->numberBetween(500, 5000) * 100,
            'deadline' => fake()->dateTimeBetween('+ 1 weeks', '+ 1 months'),
            'location' => fake()->city(),
            'duration' => fake()->numberBetween(4, 32),
        ];
    }
}
