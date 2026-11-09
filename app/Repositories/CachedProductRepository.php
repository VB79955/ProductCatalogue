<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\DTOs\ProductDTO;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Throwable;

class CachedProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly CacheRepository $cache,
        private readonly int $ttl,
    ) {}

    public function all(): array
    {
        return $this->remember('catalog:products:all', fn () => $this->repository->all());
    }

    public function categories(): array
    {
        return $this->remember('catalog:categories', fn () => $this->repository->categories());
    }

    public function byCategory(string $category): array
    {
        $key = 'catalog:products:category:'.md5($category);

        return $this->remember($key, fn () => $this->repository->byCategory($category));
    }

    public function find(int $id): ?ProductDTO
    {
        $key = "catalog:products:id:{$id}";

        try {
            $cached = $this->cache->remember($key, $this->ttl, function () use ($id) {
                $product = $this->repository->find($id);

                return $product?->toArray();
            });
        } catch (Throwable $throwable) {
            $stale = $this->cache->get($key);
            if ($stale === null) {
                throw $throwable;
            }

            $cached = $stale;
        }

        if ($cached === null) {
            return null;
        }

        return ProductDTO::fromArray($cached);
    }

    /**
     * @param  callable(): list<ProductDTO>|list<string>  $callback
     * @return list<ProductDTO>|list<string>
     */
    private function remember(string $key, callable $callback): array
    {
        try {
            $cached = $this->cache->remember($key, $this->ttl, function () use ($callback) {
                $result = $callback();

                return array_map(
                    fn ($item) => $item instanceof ProductDTO ? $item->toArray() : $item,
                    $result
                );
            });
        } catch (Throwable $throwable) {
            $stale = $this->cache->get($key);
            if ($stale === null || ! is_array($stale)) {
                throw $throwable;
            }

            $cached = $stale;
        }

        return $this->denormalizeCached($cached);
    }

    /**
     * @param  mixed  $cached
     * @return list<ProductDTO>|list<string>
     */
    private function denormalizeCached(mixed $cached): array
    {
        if (! is_array($cached)) {
            return [];
        }

        if ($cached === [] || ! isset($cached[0])) {
            return $cached;
        }

        if (is_string($cached[0])) {
            return $cached;
        }

        return array_map(fn (array $row) => ProductDTO::fromArray($row), $cached);
    }
}
