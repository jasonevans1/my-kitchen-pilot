<?php

namespace Database\Seeders;

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

        $pilotUser = User::factory()->create([
            'name' => 'pilot',
            'email' => 'kitchen@pilot.test',
            'password' => Hash::make('pilot'),
        ]);

        Notification::make()
            ->title('Welcome to Filament')
            ->body('You are ready to start building your application.')
            ->success()
            ->sendToDatabase($user);
    }
}
