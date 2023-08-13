<?php

use function Pest\Laravel\get;

it('can list books', function () {
    get('/api/books')->assertStatus(200);

    expect(true)->toBeTrue();
});
