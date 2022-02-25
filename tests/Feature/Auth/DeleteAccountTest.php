<?php

use App\Models\User;
use function Pest\Laravel\delete;
use function Pest\Laravel\assertGuest;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user accounts can be deleted', function () {
    $this->actingAs($user = User::factory()->create());

    $response = delete('/user', [
        'password' => 'password',
    ]);

    $response->assertRedirect('/admin/login');
    expect($user->fresh())->toBeNull();
    assertGuest('web');
});

test('correct password must be provided before account can be deleted', function () {
    $this->actingAs($user = User::factory()->create());

    $response = delete('/user', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
    expect($user->fresh())->toBeObject();
});
