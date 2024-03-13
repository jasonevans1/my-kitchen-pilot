<?php

namespace Database\Factories;

use App\Models\Household;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ingredient::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
            'name' => $this->faker->name(),
            'quantity' => $this->faker->numberBetween(0, 10000),
            'unit' => 'oz',
            'note' => $this->faker->sentence(),
            'household_id' => Household::factory(),
            'recipe_id' => Recipe::factory(),
        ];
    }
}
