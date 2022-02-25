<?php

use function Pest\Laravel\get;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest can see homepage', function () {
    get('/features')->assertSee('Admin');
});
