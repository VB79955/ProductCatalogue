<?php

namespace Tests\Unit;

use App\Infrastructure\Adapters\NullSearchIndexAdapter;
use App\Infrastructure\MessageBusFactory;
use App\Infrastructure\SearchIndexFactory;
use Tests\TestCase;

class InfrastructureAdapterTest extends TestCase
{
    public function test_null_search_index_returns_empty_results(): void
    {
        $adapter = new NullSearchIndexAdapter;

        $adapter->index('products', '1', ['title' => 'Test']);

        $this->assertSame([], $adapter->search('products', 'test'));
    }

    public function test_message_bus_factory_resolves_default_driver(): void
    {
        $factory = new MessageBusFactory;

        $bus = $factory->make('laravel_queue');
        $bus->publish('catalog.product.updated', ['id' => 1]);

        $this->assertTrue(true);
    }

    public function test_search_factory_resolves_null_driver(): void
    {
        $factory = new SearchIndexFactory;

        $index = $factory->make('null');

        $this->assertInstanceOf(NullSearchIndexAdapter::class, $index);
    }
}
