<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
            'title' => $this->faker->sentence(4),
            'instructions' => $this->faker->sentence(40),
            'user_id' => 1,
            'household_id' => 1,
        ];
    }
}
