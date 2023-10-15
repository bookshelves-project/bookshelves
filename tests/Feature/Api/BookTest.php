<?php

use function Pest\Laravel\get;

it('can list books', function () {
    get('/api/books')->assertStatus(200)
        ->assertJsonCount(0, 'data')
        ->assertSee('{"data":[', escape: false)
        ->assertSee('"links":{', escape: false)
        ->assertSee('"meta":{', escape: false);

    expect(true)->toBeTrue();
});
