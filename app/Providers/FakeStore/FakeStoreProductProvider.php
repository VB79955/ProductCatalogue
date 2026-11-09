<?php

namespace App\Providers\FakeStore;

use App\Contracts\ProductProviderInterface;
use App\DTOs\ProductDTO;
use App\Infrastructure\Resilience\ResilientHttpClient;

class FakeStoreProductProvider implements ProductProviderInterface
{
    public function __construct(
        private readonly ResilientHttpClient $http,
    ) {}

    public function all(): array
    {
        return $this->mapProducts(
            $this->http->get('/products')->json()
        );
    }

    public function categories(): array
    {
        $categories = $this->http->get('/products/categories')->json();

        return is_array($categories) ? array_map('strval', $categories) : [];
    }

    public function byCategory(string $category): array
    {
        return $this->mapProducts(
            $this->http->get('/products/category/'.rawurlencode($category))->json()
        );
    }

    public function find(int $id): ?ProductDTO
    {
        $response = $this->http->get("/products/{$id}", allowNotFound: true);

        if ($response->status() === 404) {
            return null;
        }

        return ProductDTO::fromArray($response->json());
    }

    /**
     * @param  mixed  $payload
     * @return list<ProductDTO>
     */
    private function mapProducts(mixed $payload): array
    {
        if (! is_array($payload)) {
            return [];
        }

        return array_map(
            fn (array $item) => ProductDTO::fromArray($item),
            $payload
        );
    }
}
