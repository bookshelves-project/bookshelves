<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Inertia\Testing\Assert;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = get('/admin/register');

    $response->assertInertia(fn (Assert $page) => $page->component('auth/Register'));
});

test('first new user can register as super admin', function () {
    $response = post('/register', [
        'name' => 'User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect('/admin/dashboard');
    assertAuthenticated();
    assertDatabaseHas('users', [
        'name' => 'User',
        'email' => 'test@example.com',
        'role' => RoleEnum::super_admin(),
    ]);
});

test('new users can register with user role', function () {
    User::factory()->create();

    $response = post('/register', [
        'name' => 'User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertHeader('X-Inertia-Location', url('/'));
    assertAuthenticated();
    assertDatabaseHas('users', [
        'name' => 'User',
        'email' => 'test@example.com',
        'role' => RoleEnum::user(),
    ]);
});

test('new users can register with strong password if debug disabled', function () {
    Config::set('app.debug', false);

    post('/register', [
        'name' => 'User',
        'email' => 'test@example.com',
        'password' => 'p4$$w0rD',
        'password_confirmation' => 'p4$$w0rD',
    ]);

    assertAuthenticated();
});

test('new users cannot register with invalid data', function (array $data, array $errors) {
    $response = post('/register', $data);

    $response->assertSessionHasErrors($errors);
})->with([
    [
        [
            'name' => 'User',
            'email' => 'example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ],
        ['email'],
    ],
    [
        [
            'name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'wrong-password',
        ],
        ['password'],
    ],
]);

test('new users cannot register with weak password if debug disabled', function (string $password) {
    Config::set('app.debug', false);

    $response = post('/register', [
        'name' => 'User',
        'email' => 'test@example.com',
        'password' => $password,
        'password_confirmation' => $password,
    ]);

    $response->assertSessionHasErrors('password');
})->with([
    'password', 'PassWord', 'p4ssw0rd', 'pa$$word',
]);

test('new users cannot render registration page when feature disabled', function () {
    Config::set('auth.registration', false);

    $response = get('/admin/register');

    $response->assertNotFound();
});

test('new users cannot register when feature disabled', function () {
    Config::set('auth.registration', false);

    $response = post('/register', [
        'name' => 'User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertNotFound();
});
