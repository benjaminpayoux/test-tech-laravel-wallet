<?php

use App\Models\User;
use App\Models\Wallet;
use function Pest\Laravel\actingAs;
use Illuminate\Support\Carbon;
use function Pest\Laravel\assertDatabaseHas;

test('create a recurring transfer', function () {
    $user = User::factory()
        ->has(Wallet::factory()->richChillGuy())
        ->create();
    
    actingAs($user);

    $start_date = Carbon::now();
    $end_date = Carbon::now()->add(7, 'day');

    $recurring_transfer_data = [
        'start_date' => $start_date,
        'end_date' => $end_date,
        'frequency' => 1,
        'recipient_email' => $user->email,
        'amount' => '10',
        'reason' => 'Just a recurring transfer',
    ];

    $response = $this->postJson('/api/v1/recurring-transfers', $recurring_transfer_data)
        ->assertNoContent(201);

    assertDatabaseHas('recurring_transfers', $recurring_transfer_data);
});