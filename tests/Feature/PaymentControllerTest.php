<?php

use App\Models\{Merchant, Payment, PaymentMethod, User};

it('can fetch a list of payments', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    Payment::factory()->count(3)->create();

    $response = $this->getJson('/api/payments');

    expect($response)->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name_client',
                        'cpf',
                        'description',
                        'amount',
                        'status',
                        'payment_method',
                        'paid_at',
                    ]
                ]
            ]);
});

it('can fetch a single payment', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $payment = Payment::factory()->create();

    $response = $this->getJson("/api/payments/{$payment->id}");

    expect($response)->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name_client',
                'cpf',
                'description',
                'amount',
                'status',
                'payment_method',
                'paid_at',
            ]);
});

it('returns empty data when no payments are found', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    Payment::query()->delete();

    $response = $this->getJson('/api/payments');

    expect($response)->assertStatus(200)
            ->assertJson([
                'data' => []
            ]);
});

it('returns 404 when payment is not found', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $response = $this->getJson("/api/payments/non-existing-payment-id");

    expect($response)->assertStatus(404)
             ->assertJson([
                 'message' => 'Payment not found'
             ]);
});

it('can create a new payment with pix', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    PaymentMethod::factory()->create(['name' => 'Pix', 'slug' => 'pix']);

    Merchant::factory()->create(['user_id' => $user->id]);

    $payment = Payment::factory()->make(['payment_method' => 'pix'])->toArray();

    $response = $this->postJson('/api/payments', $payment);

    expect($response)->assertStatus(201)
            ->assertJson([
                "name_client" => $payment['name_client'],
                "cpf" => $payment['cpf'],
                "description" => $payment['description'],
                "amount" => $payment['amount'],
                "payment_method" => $payment['payment_method'],
            ]);
});

it('can create a new payment with boleto', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    PaymentMethod::factory()->create(['name' => 'Boleto', 'slug' => 'boleto']);

    Merchant::factory()->create(['user_id' => $user->id]);

    $payment = Payment::factory()->make(['payment_method' => 'boleto'])->toArray();

    $response = $this->postJson('/api/payments', $payment);

    expect($response)->assertStatus(201)
            ->assertJson([
                "name_client" => $payment['name_client'],
                "cpf" => $payment['cpf'],
                "description" => $payment['description'],
                "amount" => $payment['amount'],
                "payment_method" => $payment['payment_method'],
            ]);
});

it('can create a new payment with bank transfer', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    PaymentMethod::factory()->create(['name' => 'Bank Transfer', 'slug' => 'bank_transfer']);

    Merchant::factory()->create(['user_id' => $user->id]);

    $payment = Payment::factory()->make(['payment_method' => 'bank_transfer'])->toArray();

    $response = $this->postJson('/api/payments', $payment);

    expect($response)->assertStatus(201)
            ->assertJson([
                "name_client" => $payment['name_client'],
                "cpf" => $payment['cpf'],
                "description" => $payment['description'],
                "amount" => $payment['amount'],
                "payment_method" => $payment['payment_method'],
            ]);
});

it('returns 422 on invalid input', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $invalidPaymentData = [
        'cpf' => '',
        'name_client' => '',
        'description' => '',
        'amount' => 'invalid data',
        'payment_method' => 'invalida data'
    ];

    $response = $this->postJson('/api/payments', $invalidPaymentData);

    expect($response)->assertStatus(422)
            ->assertJsonValidationErrors([
                'cpf',
                'name_client',
                'description',
                'amount',
                'payment_method'
            ]);
});
