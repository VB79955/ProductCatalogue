<?php

namespace App\Infrastructure\Adapters;

use App\Infrastructure\Contracts\MessageBusInterface;
use RuntimeException;

class KafkaMessageBusAdapter implements MessageBusInterface
{
    public function publish(string $topic, array $payload): void
    {
        if (! config('infrastructure.kafka.enabled')) {
            throw new RuntimeException('Kafka message bus is not enabled. Set KAFKA_ENABLED=true and configure MSK/Kafka brokers.');
        }

        throw new RuntimeException('Kafka adapter is a future extension point — implement with rdkafka or php-kafka producer.');
    }
}
