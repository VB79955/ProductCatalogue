<?php

namespace App\Factories;

use App\Contracts\ProductProviderInterface;
use App\Providers\FakeStore\FakeStoreProductProvider;
use Illuminate\Contracts\Foundation\Application;
use InvalidArgumentException;

class ProductProviderFactory
{
    public function __construct(
        private readonly Application $app,
    ) {}

    public function make(?string $provider = null): ProductProviderInterface
    {
        $provider ??= config('catalog.provider', 'fakestore');

        return match ($provider) {
            'fakestore' => $this->app->make(FakeStoreProductProvider::class),
            default => throw new InvalidArgumentException("Unknown catalog provider [{$provider}]"),
        };
    }
}
