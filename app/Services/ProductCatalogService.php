<?php

namespace App\Services;

use App\Contracts\ProductRepositoryInterface;
use App\Contracts\ProductSearchStrategyInterface;
use App\DTOs\CategoryDTO;
use App\DTOs\ProductDTO;

class ProductCatalogService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly ProductSearchStrategyInterface $searchStrategy,
    ) {}

    /**
     * @return list<ProductDTO>
     */
    public function featured(): array
    {
        $limit = (int) config('catalog.featured_limit', 5);
        $products = $this->repository->all();

        usort(
            $products,
            fn (ProductDTO $a, ProductDTO $b) => ($b->rating ?? 0) <=> ($a->rating ?? 0)
        );

        return array_slice($products, 0, $limit);
    }

    /**
     * @return list<ProductDTO>
     */
    public function search(?string $keyword): array
    {
        if ($keyword === null || trim($keyword) === '') {
            return $this->repository->all();
        }

        return $this->searchStrategy->search(
            $this->repository->all(),
            trim($keyword)
        );
    }

    /**
     * @return list<ProductDTO>
     */
    public function byCategory(string $category): array
    {
        return $this->repository->byCategory($category);
    }

    public function find(int $id): ?ProductDTO
    {
        return $this->repository->find($id);
    }

    /**
     * @return list<CategoryDTO>
     */
    public function categories(): array
    {
        return array_map(
            fn (string $slug) => CategoryDTO::fromSlug($slug),
            $this->repository->categories()
        );
    }
}
