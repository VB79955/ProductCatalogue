<?php

namespace Tests\Feature;

use Tests\Support\FakeStoreResponses;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    public function test_featured_api_returns_product_resource_shape(): void
    {
        FakeStoreResponses::fake();

        $response = $this->getJson('/api/products/featured');

        $response->assertOk()
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'title',
                        'price',
                        'description',
                        'category',
                        'image',
                        'rating',
                    ],
                ],
            ]);
    }

    public function test_product_show_api_returns_single_resource(): void
    {
        FakeStoreResponses::fake();

        $this->getJson('/api/products/4')
            ->assertOk()
            ->assertJsonPath('data.title', 'Delta Headphones');
    }
}
