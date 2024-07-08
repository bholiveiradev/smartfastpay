<?php

use App\Models\User;

it('can log in', function () {
    User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    $response = $this->post('/api/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    expect($response)->assertStatus(200)
                ->assertJsonStructure([
                    'access_token',
                    'token_type',
                    'expires_in',
                ]);
});

it('cannot log in with invalid credentials', function () {
    User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    $response = $this->post('/api/login', [
        'email' => 'test@example.com',
        'password' => 'wrongpassword',
    ]);

    expect($response)->assertStatus(401)
        ->assertJson([
            'error' => 'Invalid credentials',
        ]);
});

it('can get authenticated user', function () {
    $user = User::factory()->create();

    $token = auth()->login($user);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                     ->post('/api/me');

    expect($response)->assertStatus(200)
             ->assertJson([
                 'id' => $user->id,
                 'name' => $user->name,
                 'email' => $user->email,
             ]);
});

it('can log out', function () {
    $user = User::factory()->create();

    $token = auth()->login($user);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                     ->post('/api/logout');

    $response->assertStatus(200)
             ->assertJson([
                 'message' => 'Successfully logged out',
             ]);
});

it('can refresh token', function () {
    $user = User::factory()->create();

    $token = auth()->login($user);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                     ->post('/api/refresh');

    $response->assertStatus(200)
             ->assertJsonStructure([
                 'access_token',
                 'token_type',
                 'expires_in',
             ]);
});
