<?php

namespace App\Contracts;

use App\DTOs\ProductDTO;

interface ProductSearchStrategyInterface
{
    /**
     * @param  list<ProductDTO>  $products
     * @return list<ProductDTO>
     */
    public function search(array $products, string $keyword): array;
}
