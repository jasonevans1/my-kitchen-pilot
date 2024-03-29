<?php

namespace Database\Factories;

use App\Models\Household;
use App\Models\Recipe;
use App\Models\User;
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
            'user_id' => User::factory(),
            'household_id' => Household::factory(),
        ];
    }
}
