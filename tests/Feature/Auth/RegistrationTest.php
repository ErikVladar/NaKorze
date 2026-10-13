<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/auth/create-staff-5s8k2m9x');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $admin = User::factory()->create();

    $response = $this->actingAs($admin)->post('/auth/create-staff-5s8k2m9x', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticatedAs($admin);
    $this->assertDatabaseHas('users', ['email' => 'test@example.com', 'role' => 'staff']);
    $response->assertRedirect(route('dashboard', absolute: false));
});
