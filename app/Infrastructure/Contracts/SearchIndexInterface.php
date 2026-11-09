<?php

namespace App\Infrastructure\Contracts;

interface SearchIndexInterface
{
    /**
     * @param  array<string, mixed>  $document
     */
    public function index(string $index, string $id, array $document): void;

    /**
     * @return list<array<string, mixed>>
     */
    public function search(string $index, string $query, int $limit = 20): array;
}
