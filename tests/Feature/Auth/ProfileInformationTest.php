<?php

namespace Tests\Feature;

use App\Models\User;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use Inertia\Testing\AssertableInertia;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can show his profile', function () {
    $this->actingAs(User::factory()->admin()->create());

    $response = get('/admin/user/profile');

    $response->assertInertia(
        fn (AssertableInertia $page) => $page->component('profile/Show')
    );
});

test('profile information can be updated', function () {
    $this->actingAs($user = User::factory()->create());

    put('/user/profile-information', [
        'name' => 'Name',
        'email' => 'test@example.com',
    ]);

    expect($user->fresh()->name)->toBe('Name');
    expect($user->fresh()->email)->toBe('test@example.com');
});

test('profile information cannot be updated with invalid data', function (array $data, array $errors) {
    User::factory()->create([
        'email' => 'other@example.com',
    ]);
    $this->actingAs(User::factory()->create());

    $response = put('/user/profile-information', $data);

    $response->assertSessionHasErrorsIn('updateProfileInformation', $errors);
})->with([
    [['email' => 'example.com'], ['email']],
    [['email' => 'other@example.com'], ['email']],
]);
