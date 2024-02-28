<?php

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\EditAction;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->admin()->create());
});

it('can render user list page', function () {
    $this->assertAuthenticated();
    livewire(UserResource\Pages\ListUsers::class)->assertSuccessful();
});

it('cannot display list of users', function () {
    $users = User::factory()->count(4)->create();

    livewire(UserResource\Pages\ListUsers::class)
        ->assertCanSeeTableRecords($users)
        ->assertCountTableRecords(5);
});

it('can render user email column', function () {
    User::factory()->count(2)->create();

    livewire(UserResource\Pages\ListUsers::class)
        ->assertCanRenderTableColumn('email');
});

it('can validate edited user data', function () {
    $user = User::factory()->create();

    livewire(UserResource\Pages\ListUsers::class)
        ->callTableAction(EditAction::class, $user, data: [
            'email' => null,
        ])
        ->assertHasTableActionErrors(['email' => ['required']]);
});
