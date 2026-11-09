<?php

namespace App\Infrastructure\Resilience;

use RuntimeException;

class CircuitOpenException extends RuntimeException
{
    public function __construct(string $service = 'external-api')
    {
        parent::__construct("Circuit breaker is open for [{$service}].");
    }
}
