<?php

namespace Tests\Support;

use Illuminate\Support\Facades\Http;

class FakeStoreResponses
{
    /**
     * @return list<array<string, mixed>>
     */
    public static function products(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Alpha Backpack',
                'price' => 109.95,
                'description' => 'Durable backpack for daily use.',
                'category' => 'bags',
                'image' => 'https://example.com/1.jpg',
                'rating' => ['rate' => 4.8, 'count' => 120],
            ],
            [
                'id' => 2,
                'title' => 'Beta Jacket',
                'price' => 89.5,
                'description' => 'Warm jacket for winter.',
                'category' => 'clothing',
                'image' => 'https://example.com/2.jpg',
                'rating' => ['rate' => 4.2, 'count' => 80],
            ],
            [
                'id' => 3,
                'title' => 'Gamma Watch',
                'price' => 199.0,
                'description' => 'Smart watch with notifications.',
                'category' => 'electronics',
                'image' => 'https://example.com/3.jpg',
                'rating' => ['rate' => 3.5, 'count' => 40],
            ],
            [
                'id' => 4,
                'title' => 'Delta Headphones',
                'price' => 59.99,
                'description' => 'Noise cancelling headphones.',
                'category' => 'electronics',
                'image' => 'https://example.com/4.jpg',
                'rating' => ['rate' => 4.9, 'count' => 200],
            ],
            [
                'id' => 5,
                'title' => 'Epsilon Shoes',
                'price' => 49.99,
                'description' => 'Comfortable running shoes.',
                'category' => 'clothing',
                'image' => 'https://example.com/5.jpg',
                'rating' => ['rate' => 4.0, 'count' => 60],
            ],
            [
                'id' => 6,
                'title' => 'Zeta Keyboard',
                'price' => 129.0,
                'description' => 'Mechanical keyboard for coders.',
                'category' => 'electronics',
                'image' => 'https://example.com/6.jpg',
                'rating' => ['rate' => 2.0, 'count' => 10],
            ],
        ];
    }

    public static function fake(): void
    {
        $products = self::products();

        Http::fake(function ($request) use ($products) {
            $url = $request->url();

            if (str_ends_with($url, '/products/categories')) {
                return Http::response(['bags', 'clothing', 'electronics'], 200);
            }

            if (preg_match('#/products/category/([^/]+)$#', $url, $matches)) {
                $category = rawurldecode($matches[1]);
                $filtered = array_values(array_filter(
                    $products,
                    fn (array $p) => $p['category'] === $category
                ));

                return Http::response($filtered, 200);
            }

            if (preg_match('#/products/(\d+)$#', $url, $matches)) {
                $id = (int) $matches[1];
                $product = collect($products)->firstWhere('id', $id);

                return $product
                    ? Http::response($product, 200)
                    : Http::response(['message' => 'not found'], 404);
            }

            if (str_ends_with($url, '/products')) {
                return Http::response($products, 200);
            }

            return Http::response([], 404);
        });
    }
}
