<?php

namespace App\Providers;

use App\Contracts\ProductProviderInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\ProductSearchStrategyInterface;
use App\Factories\ProductProviderFactory;
use App\Infrastructure\Contracts\MessageBusInterface;
use App\Infrastructure\Contracts\SearchIndexInterface;
use App\Infrastructure\MessageBusFactory;
use App\Infrastructure\Resilience\CircuitBreaker;
use App\Infrastructure\Resilience\ResilientHttpClient;
use App\Infrastructure\SearchIndexFactory;
use App\Models\ProductEnquiry;
use App\Observers\ProductEnquiryObserver;
use App\Providers\FakeStore\FakeStoreProductProvider;
use App\Repositories\CachedProductRepository;
use App\Repositories\FakeStoreProductRepository;
use App\Search\KeywordSearchStrategy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ProductProviderFactory::class);

        $this->app->singleton(CircuitBreaker::class, function ($app) {
            $config = config('resilience.fakestore');
            $store = (string) ($config['store'] ?? 'redis');

            return new CircuitBreaker(
                Cache::store($store),
                name: 'fakestore',
                failureThreshold: (int) ($config['failure_threshold'] ?? 5),
                openSeconds: (int) ($config['open_seconds'] ?? 60),
            );
        });

        $this->app->singleton(ResilientHttpClient::class, function ($app) {
            return new ResilientHttpClient(
                $app->make(CircuitBreaker::class),
                baseUrl: config('catalog.fakestore.base_url', 'https://fakestoreapi.com'),
            );
        });

        $this->app->singleton(FakeStoreProductProvider::class);

        $this->app->singleton(ProductProviderInterface::class, function ($app) {
            return $app->make(ProductProviderFactory::class)->make();
        });

        $this->app->singleton(FakeStoreProductRepository::class, function ($app) {
            return new FakeStoreProductRepository(
                $app->make(ProductProviderInterface::class)
            );
        });

        $this->app->singleton(ProductRepositoryInterface::class, function ($app) {
            return new CachedProductRepository(
                $app->make(FakeStoreProductRepository::class),
                Cache::store(config('cache.default', 'redis')),
                (int) config('catalog.cache_ttl', 3600),
            );
        });

        $this->app->singleton(ProductSearchStrategyInterface::class, KeywordSearchStrategy::class);

        $this->app->singleton(MessageBusFactory::class);
        $this->app->singleton(SearchIndexFactory::class);

        $this->app->singleton(MessageBusInterface::class, function ($app) {
            return $app->make(MessageBusFactory::class)->make();
        });

        $this->app->singleton(SearchIndexInterface::class, function ($app) {
            return $app->make(SearchIndexFactory::class)->make();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ProductEnquiry::observe(ProductEnquiryObserver::class);

        RateLimiter::for('api', function (Request $request) {
            $config = config('rate_limiting.api');

            return Limit::perMinute($config['max_attempts'] ?? 60)
                ->by($request->ip());
        });

        RateLimiter::for('api_strict', function (Request $request) {
            $config = config('rate_limiting.api_strict');

            return Limit::perMinute($config['max_attempts'] ?? 10)
                ->by($request->ip());
        });
    }
}
