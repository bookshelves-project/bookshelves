<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;

uses(RefreshDatabase::class);

test('confirm password screen can be rendered for admin', function () {
    $user = User::factory()->admin()->create();

    $response = $this->actingAs($user)->get('/admin/user/confirm-password');

    $response->assertInertia(
        fn (Assert $page) => $page->component('auth/ConfirmPassword')
    );
});

test('password can be confirmed', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/user/confirm-password', [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/user/confirm-password', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});
