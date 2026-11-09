<?php

namespace App\Infrastructure\Contracts;

interface MessageBusInterface
{
    /**
     * @param  array<string, mixed>  $payload
     */
    public function publish(string $topic, array $payload): void;
}
