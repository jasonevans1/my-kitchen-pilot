<?php

namespace Database\Seeders;

use App\Models\Household;
use App\Models\Recipe;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.test',
            'password' => Hash::make('admin'),
            'is_admin' => true,
        ]);

        $household = Household::factory()->create([
            'name' => 'Pilot Household',
        ]);

        $pilotUser = User::factory()->create([
            'name' => 'pilot',
            'email' => 'kitchen@pilot.test',
            'password' => Hash::make('pilot'),
        ]);
        $pilotUser->households()->attach($household);

        $recipe = Recipe::factory()->create([
            'title' => 'Pilot Recipe',
            'instructions' => 'Pilot Instructions',
            'prep_time' => 10,
            'cook_time' => 20,
            'serves' => '4',
        ]);
        $recipe->user()->associate($pilotUser);
        $recipe->household()->associate($household);

        $householdTwo = Household::factory()->create([
            'name' => 'Pilot Household Two',
        ]);

        $newPilotUser = User::factory()->create([
            'name' => 'new pilot',
            'email' => 'newkitchen@pilot.test',
            'password' => Hash::make('pilot'),
        ]);
        $newPilotUser->households()->attach($householdTwo);

        Notification::make()
            ->title('Welcome to Filament')
            ->body('You are ready to start building your application.')
            ->success()
            ->sendToDatabase($user);
    }
}
