<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class AuthorsTest extends TestCase
{
    public function firstPageAvailable()
    {
        $response = $this->get(route('api.authors.index'));
        $response->assertStatus(200);
    }
}
