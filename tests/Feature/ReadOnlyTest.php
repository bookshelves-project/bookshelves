<?php

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

beforeEach(function () {
    Config::set('app.read_only', true);
});

test('admin cannot create new user when read only active', function () {
    $this->actingAs(User::factory()->admin()->create());

    $response = post('/admin/users', [
        'name' => 'example',
        'email' => 'user@example.com',
        'password' => 'password',
        'active' => true,
        'role' => RoleEnum::user(),
    ]);

    $response->assertRedirect()->assertSessionHasErrors();
    assertDatabaseMissing('users', [
        'name' => 'example',
        'email' => 'user@example.com',
    ]);
});

test('admin can still logout when read only active', function () {
    $this->actingAs(User::factory()->admin()->create());

    $response = post('/logout');

    $response->assertRedirect('/admin/login');
    assertGuest('web');
});

test('super admin can create new user when read only active', function () {
    $this->actingAs(User::factory()->superAdmin()->create());

    $response = post('/admin/users', [
        'name' => 'example',
        'email' => 'user@example.com',
        'password' => 'password',
        'active' => true,
        'role' => RoleEnum::user(),
    ]);

    $response->assertSessionMissing('flash.error');
    assertDatabaseHas('users', [
        'name' => 'example',
        'email' => 'user@example.com',
    ]);
});
