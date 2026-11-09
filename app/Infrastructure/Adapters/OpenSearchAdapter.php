<?php

namespace App\Infrastructure\Adapters;

use App\Infrastructure\Contracts\SearchIndexInterface;
use RuntimeException;

class OpenSearchAdapter implements SearchIndexInterface
{
    public function index(string $index, string $id, array $document): void
    {
        if (! config('infrastructure.opensearch.enabled')) {
            throw new RuntimeException('OpenSearch is not enabled. Set OPENSEARCH_ENABLED=true.');
        }

        throw new RuntimeException('OpenSearch adapter is a future extension point — wire to OpenSearch/Elasticsearch HTTP API.');
    }

    public function search(string $index, string $query, int $limit = 20): array
    {
        if (! config('infrastructure.opensearch.enabled')) {
            throw new RuntimeException('OpenSearch is not enabled. Set OPENSEARCH_ENABLED=true.');
        }

        throw new RuntimeException('OpenSearch search is not implemented yet.');
    }
}
