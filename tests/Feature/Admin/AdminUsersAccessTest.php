<?php

use App\Models\User;
use function Pest\Laravel\put;
use function Pest\Laravel\delete;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user cannot update other user', function () {
    $this->actingAs(User::factory()->create());
    $user = User::factory()->create();

    $response = put("/admin/users/{$user->id}");

    $response->assertForbidden();
});

test('admin cannot update super admin', function () {
    $this->actingAs(User::factory()->admin()->create());
    $user = User::factory()->superAdmin()->create();

    $response = put("/admin/users/{$user->id}");

    $response->assertForbidden();
});

test('admin cannot delete super admin', function () {
    $this->actingAs(User::factory()->admin()->create());
    $user = User::factory()->superAdmin()->create();

    $response = delete("/admin/users/{$user->id}");

    $response->assertForbidden();
});
