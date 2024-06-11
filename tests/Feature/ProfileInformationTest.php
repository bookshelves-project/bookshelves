<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

test('profile information can be updated', function () {
    actingAs($user = User::factory()->create());

    $res = put('/user/profile-information', [
        'name' => 'Test Name',
        'email' => 'test@example.com',
    ]);

    expect($user->fresh())
        ->name->toEqual('Test Name')
        ->email->toEqual('test@example.com');
});
