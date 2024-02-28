<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('can login to pilot and can be rendered and authenticate', function () {
    $response = $this->get('/pilot');

    $response->assertStatus(200);
    $this->assertAuthenticated();
});
