<?php

namespace App\Infrastructure;

use App\Infrastructure\Adapters\NullSearchIndexAdapter;
use App\Infrastructure\Adapters\OpenSearchAdapter;
use App\Infrastructure\Contracts\SearchIndexInterface;
use InvalidArgumentException;

class SearchIndexFactory
{
    public function make(?string $driver = null): SearchIndexInterface
    {
        $driver ??= config('infrastructure.search_driver', 'null');

        return match ($driver) {
            'null' => new NullSearchIndexAdapter,
            'opensearch' => new OpenSearchAdapter,
            default => throw new InvalidArgumentException("Unknown search driver [{$driver}]"),
        };
    }
}
