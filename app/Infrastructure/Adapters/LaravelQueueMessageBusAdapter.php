<?php

namespace App\Infrastructure\Adapters;

use App\Infrastructure\Contracts\MessageBusInterface;
use Illuminate\Support\Facades\Log;

class LaravelQueueMessageBusAdapter implements MessageBusInterface
{
    public function publish(string $topic, array $payload): void
    {
        Log::debug('MessageBus publish', ['topic' => $topic, 'payload' => $payload]);
    }
}
