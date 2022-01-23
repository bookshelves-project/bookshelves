<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\withSession;

uses(RefreshDatabase::class);

test('admin can impersonate other admin', function () {
    $this->actingAs(User::factory()->admin()->create());
    $user = User::factory()->admin()->create();

    $response = post("/admin/users/{$user->id}/impersonate");

    $response->assertRedirect('/admin/dashboard');
    $response->assertSessionHas('impersonate', $user->id);
});

test('admin can impersonate user', function () {
    $this->actingAs(User::factory()->admin()->create());
    $user = User::factory()->create();

    $response = post("/admin/users/{$user->id}/impersonate");

    $response->assertHeader('X-Inertia-Location', url('/'));
    $response->assertSessionHas('impersonate', $user->id);
});

test('inertia page return impersonated user when impersonate', function () {
    $this->actingAs(User::factory()->superAdmin()->create());
    $user = User::factory()->admin()->create();

    withSession(['impersonate' => $user->id]);

    $response = get('/admin/dashboard');

    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('Dashboard')
            ->where('auth.id', $user->id)
            ->where('auth.is_impersonating', true)
    );
});

test('user can stop impersonate', function () {
    $this->actingAs(User::factory()->superAdmin()->create());
    $user = User::factory()->admin()->create();

    withSession(['impersonate' => $user->id]);

    $response = post('/admin/users/stop-impersonate');

    $response->assertRedirect('/admin/dashboard');
    $response->assertSessionMissing('impersonate');
});

test('user cannot impersonate himself', function () {
    $this->actingAs($user = User::factory()->create());

    $response = post("/admin/users/{$user->id}/impersonate");

    $response->assertForbidden();
});

test('non admin user cannot impersonate', function () {
    $this->actingAs(User::factory()->create());
    $user = User::factory()->create();

    $response = post("/admin/users/{$user->id}/impersonate");

    $response->assertForbidden();
});

test('admin user cannot impersonate super admin user', function () {
    $this->actingAs(User::factory()->admin()->create());
    $user = User::factory()->superAdmin()->create();

    $response = post("/admin/users/{$user->id}/impersonate");

    $response->assertForbidden();
});
