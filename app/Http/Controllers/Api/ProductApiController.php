<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\ProductCatalogService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductApiController extends Controller
{
    public function __construct(
        private readonly ProductCatalogService $catalog,
    ) {}

    public function featured(): AnonymousResourceCollection
    {
        return ProductResource::collection($this->catalog->featured());
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $keyword = $request->string('q')->toString();

        return ProductResource::collection(
            $this->catalog->search($keyword !== '' ? $keyword : null)
        );
    }

    public function show(int $id): ProductResource
    {
        $product = $this->catalog->find($id);

        if ($product === null) {
            abort(404);
        }

        return new ProductResource($product);
    }
}
