<?php

namespace Tests\Feature;

use App\Services\ProductCatalogService;
use Tests\Support\FakeStoreResponses;
use Tests\TestCase;

class ProductCatalogServiceTest extends TestCase
{
    public function test_featured_returns_top_five_by_rating(): void
    {
        FakeStoreResponses::fake();

        $featured = app(ProductCatalogService::class)->featured();

        $this->assertCount(5, $featured);
        $this->assertSame('Delta Headphones', $featured[0]->title);
        $this->assertSame('Alpha Backpack', $featured[1]->title);
    }

    public function test_search_filters_products_by_keyword(): void
    {
        FakeStoreResponses::fake();

        $results = app(ProductCatalogService::class)->search('keyboard');

        $this->assertCount(1, $results);
        $this->assertSame('Zeta Keyboard', $results[0]->title);
    }
}
