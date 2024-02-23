<?php

it('admin login screen can be rendered', function () {
    $response = $this->get('/admin');

    $response->assertStatus(200);
});
