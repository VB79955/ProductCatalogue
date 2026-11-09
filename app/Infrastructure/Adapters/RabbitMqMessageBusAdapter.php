<?php

namespace App\Infrastructure\Adapters;

use App\Infrastructure\Contracts\MessageBusInterface;
use RuntimeException;

class RabbitMqMessageBusAdapter implements MessageBusInterface
{
    public function publish(string $topic, array $payload): void
    {
        if (! config('infrastructure.rabbitmq.enabled')) {
            throw new RuntimeException('RabbitMQ message bus is not enabled. Set RABBITMQ_ENABLED=true.');
        }

        throw new RuntimeException('RabbitMQ adapter is a future extension point — implement with php-amqplib.');
    }
}
