<?php

namespace App\Infrastructure\Resilience;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ResilientHttpClient
{
    public function __construct(
        private readonly CircuitBreaker $circuitBreaker,
        private readonly string $baseUrl,
    ) {}

    public function get(string $path, bool $allowNotFound = false): Response
    {
        return $this->circuitBreaker->call(function () use ($path, $allowNotFound) {
            $response = Http::baseUrl(rtrim($this->baseUrl, '/'))
                ->acceptJson()
                ->timeout(10)
                ->get($path);

            if ($allowNotFound && $response->status() === 404) {
                return $response;
            }

            if (! $response->successful()) {
                throw new RuntimeException('HTTP error: '.$response->status());
            }

            return $response;
        });
    }
}
