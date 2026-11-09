<?php

namespace App\Infrastructure\Adapters;

use App\Infrastructure\Contracts\MessageBusInterface;
use Illuminate\Support\Facades\Log;

class RedisLogMessageBusAdapter implements MessageBusInterface
{
    public function publish(string $topic, array $payload): void
    {
        Log::info('Redis message bus (log-only)', compact('topic', 'payload'));
    }
}
