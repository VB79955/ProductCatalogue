<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Services\ProductCatalogService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryApiController extends Controller
{
    public function __construct(
        private readonly ProductCatalogService $catalog,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection($this->catalog->categories());
    }

    public function products(string $category): AnonymousResourceCollection
    {
        return ProductResource::collection($this->catalog->byCategory($category));
    }
}
