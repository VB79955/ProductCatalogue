<?php

namespace App\Contracts;

use App\DTOs\ProductDTO;

interface ProductRepositoryInterface
{
    /**
     * @return list<ProductDTO>
     */
    public function all(): array;

    /**
     * @return list<string>
     */
    public function categories(): array;

    /**
     * @return list<ProductDTO>
     */
    public function byCategory(string $category): array;

    public function find(int $id): ?ProductDTO;
}
