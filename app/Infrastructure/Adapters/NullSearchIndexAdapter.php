<?php

namespace App\Infrastructure\Adapters;

use App\Infrastructure\Contracts\SearchIndexInterface;

class NullSearchIndexAdapter implements SearchIndexInterface
{
    public function index(string $index, string $id, array $document): void
    {
        // No-op until OpenSearch or another driver is enabled.
    }

    public function search(string $index, string $query, int $limit = 20): array
    {
        return [];
    }
}
