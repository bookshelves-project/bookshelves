<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\get;
use function Pest\Laravel\getJson;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

test('admin login screen can be rendered', function () {
    $response = get('/admin/login');

    $response->assertInertia(fn (Assert $page) => $page->component('auth/Login'));
});

test('authenticated admin should be redirected to admin when go to login page', function () {
    $this->actingAs(User::factory()->admin()->create());

    $response = get('/admin/login');

    $response->assertRedirect('/admin');
});

test('guest user should be redirected to login when intent go to authenticated page', function () {
    $response = get('/admin');

    $response->assertRedirect('/admin/login');
});

test('guest user should be unauthorized to do authenticated json request', function () {
    $response = getJson('/admin/users');

    $response->assertUnauthorized();
});

test('admin should be redirected to dashboard when intent go to admin home', function () {
    $this->actingAs(User::factory()->admin()->create());

    $response = get('/admin');

    $response->assertRedirect('/admin/dashboard');
});

test('admin can go to dashboard', function () {
    $this->actingAs($user = User::factory()->admin()->create());

    $response = get('/admin/dashboard');

    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('Dashboard')
            ->where('auth.id', $user->id)
            ->where('auth.is_impersonating', false)
    );
});

test('non admin cannot go to admin dashboard', function () {
    $this->actingAs(User::factory()->create());

    $response = get('/admin/dashboard');

    $response->assertForbidden();
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertHeader('X-Inertia-Location', url('/'));
    assertAuthenticated();
});

test('admins can authenticate using the login screen', function () {
    $user = User::factory()->admin()->create();

    $response = post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/admin/dashboard');
    assertAuthenticated();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $response = post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
    assertGuest();
});

test('inactive users can not authenticate', function () {
    $user = User::factory()->inactive()->create();

    $response = post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertSessionHasErrors();
    assertGuest();
});

test('users can logout', function () {
    $this->actingAs(User::factory()->create());

    $response = post('/logout');

    $response->assertRedirect('/admin/login');
    assertGuest('web');
});
