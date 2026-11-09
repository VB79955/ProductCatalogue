<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use Tests\Support\FakeStoreResponses;
use Tests\TestCase;

class ApiRateLimitTest extends TestCase
{
    public function test_api_returns_429_after_rate_limit_exceeded(): void
    {
        FakeStoreResponses::fake();

        Config::set('rate_limiting.api.max_attempts', 3);

        $this->getJson('/api/products')->assertOk();
        $this->getJson('/api/products')->assertOk();
        $this->getJson('/api/products')->assertOk();
        $this->getJson('/api/products')->assertStatus(429);
    }
}
