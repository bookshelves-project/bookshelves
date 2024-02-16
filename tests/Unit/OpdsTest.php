<?php

use function Pest\Laravel\get;

it('has a welcome page', function () {
    get('/opds')->assertStatus(200);
});
