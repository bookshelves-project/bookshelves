<?php

use function Pest\Laravel\get;

test('has a welcome page', function () {
    get('/opds')->assertFound();
});
