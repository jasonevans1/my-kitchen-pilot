<?php

beforeEach(function () {
    $this->loggedInUser = loginAsUser();
});

it('can login to pilot and can be rendered and authenticate', function () {
    $response = $this->get('/pilot/1');

    $response->assertStatus(200);
    $this->assertAuthenticated();
});
