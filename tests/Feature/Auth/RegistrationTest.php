<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/auth/create-staff-5s8k2m9x');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/auth/create-staff-5s8k2m9x', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
