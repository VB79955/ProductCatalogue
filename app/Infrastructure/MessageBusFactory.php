<?php

namespace App\Infrastructure;

use App\Infrastructure\Adapters\KafkaMessageBusAdapter;
use App\Infrastructure\Adapters\LaravelQueueMessageBusAdapter;
use App\Infrastructure\Adapters\RabbitMqMessageBusAdapter;
use App\Infrastructure\Adapters\RedisLogMessageBusAdapter;
use App\Infrastructure\Contracts\MessageBusInterface;
use InvalidArgumentException;

class MessageBusFactory
{
    public function make(?string $driver = null): MessageBusInterface
    {
        $driver ??= config('infrastructure.message_bus', 'laravel_queue');

        return match ($driver) {
            'laravel_queue' => new LaravelQueueMessageBusAdapter,
            'redis_log' => new RedisLogMessageBusAdapter,
            'kafka' => new KafkaMessageBusAdapter,
            'rabbitmq' => new RabbitMqMessageBusAdapter,
            default => throw new InvalidArgumentException("Unknown message bus driver [{$driver}]"),
        };
    }
}
