<?php

namespace App\Repositories;

use App\Contracts\ProductProviderInterface;
use App\Contracts\ProductRepositoryInterface;
use App\DTOs\ProductDTO;

class FakeStoreProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private readonly ProductProviderInterface $provider,
    ) {}

    public function all(): array
    {
        return $this->provider->all();
    }

    public function categories(): array
    {
        return $this->provider->categories();
    }

    public function byCategory(string $category): array
    {
        return $this->provider->byCategory($category);
    }

    public function find(int $id): ?ProductDTO
    {
        return $this->provider->find($id);
    }
}
