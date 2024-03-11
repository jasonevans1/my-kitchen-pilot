<?php

use App\Filament\Pilot\Resources\RecipeResource;
use App\Models\Household;
use App\Models\Recipe;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->loggedInUser = loginAsUser();
});

function createRecipesAndIngredients(User $user, int $recipesCount = 1)
{
    return Recipe::factory()
        ->count($recipesCount)
        ->for($user)
        ->for($user->households->first())
        ->create();
}

it('can render recipe page', function () {
    get(RecipeResource::getUrl('index', panel: 'pilot', tenant: $this->loggedInUser->households()->first()))->assertSuccessful();
});

it('renders the create recipe page', function () {
    $recipes = createRecipesAndIngredients($this->loggedInUser);

    get(RecipeResource::getUrl('create', panel: 'pilot', tenant: $this->loggedInUser->households()->first()))
        ->assertOk();
});

it('renders the recipe edit page', function () {
    $recipes = createRecipesAndIngredients($this->loggedInUser);

    get(RecipeResource::getUrl('edit', ['record' => $recipes[0]], panel: 'pilot', tenant: $this->loggedInUser->households()->first()))
        ->assertOk();
});

it('can render recipe list page', function () {
    $recipes = createRecipesAndIngredients($this->loggedInUser);

    Livewire::test(RecipeResource\Pages\ListRecipes::class)
        ->assertCanSeeTableRecords($recipes)
        ->assertSeeText($recipes->first()->title)
        ->assertSeeText($recipes->first()->prep_time)
        ->assertSeeText($recipes->first()->cook_time)
        ->assertSeeText($recipes->first()->serves);
});

it('only shows recipes for the household', function () {
    $recipes = createRecipesAndIngredients($this->loggedInUser);

    $anotherHousehold = Household::factory()->create([
        'name' => 'Pilot Household Two',
    ]);
    $anotherUser = User::factory()->create();
    $anotherUser->households()->attach($anotherHousehold);
    $anotherRecipes = createRecipesAndIngredients($anotherUser);

    get(RecipeResource::getUrl('index', panel: 'pilot', tenant: $this->loggedInUser->households()->first()))
        ->assertOk()
        ->assertSeeText($recipes[0]->name)
        ->assertDontSeeText($anotherRecipes[0]->name);
});

it('can create a recipe', function () {
    $recipe = Recipe::factory()
        ->for($this->loggedInUser)
        ->for($this->loggedInUser->households->first())
        ->make();

    Livewire::test(RecipeResource\Pages\CreateRecipe::class)
        ->fillForm([
            'user_id' => $this->loggedInUser->id,
            'household_id' => $this->loggedInUser->households()->first()->id,
            'title' => $recipe->title,
            'instructions' => $recipe->instructions,
            'prep_time' => $recipe->prep_time,
            'cook_time' => $recipe->cook_time,
            'serves' => $recipe->serves,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Recipe::class, [
        'user_id' => $this->loggedInUser->id,
        'household_id' => $this->loggedInUser->households()->first()->id,
        'title' => $recipe->title,
        'instructions' => $recipe->instructions,
        'prep_time' => $recipe->prep_time,
        'cook_time' => $recipe->cook_time,
        'serves' => $recipe->serves,
    ]);
});
