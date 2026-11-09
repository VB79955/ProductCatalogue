<?php

namespace App\Search;

use App\Contracts\ProductSearchStrategyInterface;
use App\DTOs\ProductDTO;

class KeywordSearchStrategy implements ProductSearchStrategyInterface
{
    /**
     * @param  list<ProductDTO>  $products
     * @return list<ProductDTO>
     */
    public function search(array $products, string $keyword): array
    {
        $needle = mb_strtolower($keyword);

        return array_values(array_filter(
            $products,
            fn (ProductDTO $product) => str_contains(mb_strtolower($product->title), $needle)
                || str_contains(mb_strtolower($product->description), $needle)
                || str_contains(mb_strtolower($product->category), $needle)
        ));
    }
}
