<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    actingAs(User::factory()->admin()->create());
});

it('admin login screen can be rendered and authenticate', function () {
    $response = $this->get('/admin');

    $response->assertStatus(200);
    $this->assertAuthenticated();
});
