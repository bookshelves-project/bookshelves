<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('guest can see homepage', function () {
    get('/')->assertSee('Go to admin !');
});
