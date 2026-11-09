<?php

namespace Tests\Feature;

use App\Infrastructure\Resilience\CircuitBreaker;
use App\Infrastructure\Resilience\CircuitOpenException;
use App\Services\ProductCatalogService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\Support\FakeStoreResponses;
use Tests\TestCase;

class CircuitBreakerTest extends TestCase
{
    public function test_circuit_opens_after_repeated_failures(): void
    {
        Config::set('resilience.fakestore.failure_threshold', 2);
        Config::set('resilience.fakestore.open_seconds', 60);
        Config::set('resilience.fakestore.store', 'array');

        Http::fake([
            '*' => Http::response('error', 503),
        ]);

        $breaker = new CircuitBreaker(
            Cache::store('array'),
            name: 'fakestore-test',
            failureThreshold: 2,
            openSeconds: 60,
        );

        try {
            $breaker->call(fn () => throw new \RuntimeException('fail'));
        } catch (\RuntimeException) {
        }

        try {
            $breaker->call(fn () => throw new \RuntimeException('fail'));
        } catch (\RuntimeException) {
        }

        $this->expectException(CircuitOpenException::class);
        $breaker->call(fn () => 'never');
    }

    public function test_cached_product_list_uses_stale_data_when_upstream_fails(): void
    {
        FakeStoreResponses::fake();

        $service = app(ProductCatalogService::class);
        $products = $service->search(null);
        $this->assertNotEmpty($products);

        Http::fake([
            '*' => Http::response('unavailable', 503),
        ]);

        Config::set('resilience.fakestore.failure_threshold', 1);
        Config::set('resilience.fakestore.store', 'array');

        app()->forgetInstance(CircuitBreaker::class);
        app()->forgetInstance(\App\Infrastructure\Resilience\ResilientHttpClient::class);
        app()->forgetInstance(\App\Providers\FakeStore\FakeStoreProductProvider::class);

        $stale = app(ProductCatalogService::class)->search(null);

        $this->assertCount(count($products), $stale);
        $this->assertSame($products[0]->title, $stale[0]->title);
    }
}
