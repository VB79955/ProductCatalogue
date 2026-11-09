<?php

namespace Tests\Feature;

use Tests\Support\FakeStoreResponses;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_application_returns_a_successful_response(): void
    {
        FakeStoreResponses::fake();

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
