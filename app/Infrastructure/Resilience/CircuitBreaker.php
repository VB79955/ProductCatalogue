<?php

namespace App\Infrastructure\Resilience;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Throwable;

class CircuitBreaker
{
    private const STATE_CLOSED = 'closed';

    private const STATE_OPEN = 'open';

    public function __construct(
        private readonly CacheRepository $cache,
        private readonly string $name,
        private readonly int $failureThreshold,
        private readonly int $openSeconds,
    ) {}

    /**
     * @template T
     *
     * @param  callable(): T  $operation
     * @return T
     */
    public function call(callable $operation)
    {
        if ($this->isOpen()) {
            throw new CircuitOpenException($this->name);
        }

        try {
            $result = $operation();
            $this->recordSuccess();

            return $result;
        } catch (Throwable $throwable) {
            $this->recordFailure();

            throw $throwable;
        }
    }

    public function isOpen(): bool
    {
        return $this->state() === self::STATE_OPEN;
    }

    private function recordSuccess(): void
    {
        $this->cache->forget($this->key('failures'));
        $this->cache->put($this->key('state'), self::STATE_CLOSED, $this->openSeconds);
    }

    private function recordFailure(): void
    {
        $failures = (int) $this->cache->increment($this->key('failures'));

        if ($failures >= $this->failureThreshold) {
            $this->cache->put($this->key('state'), self::STATE_OPEN, $this->openSeconds);
        }
    }

    private function state(): string
    {
        return (string) $this->cache->get($this->key('state'), self::STATE_CLOSED);
    }

    private function key(string $suffix): string
    {
        return "circuit:{$this->name}:{$suffix}";
    }
}
