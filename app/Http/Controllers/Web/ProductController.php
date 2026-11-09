<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ProductCatalogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductCatalogService $catalog,
    ) {}

    public function index(Request $request): View
    {
        $keyword = $request->string('q')->toString();

        return view('products.index', [
            'products' => $this->catalog->search($keyword ?: null),
            'categories' => $this->catalog->categories(),
            'keyword' => $keyword,
            'title' => $keyword !== '' ? 'Search results' : 'All products',
        ]);
    }

    public function category(string $category): View
    {
        return view('products.index', [
            'products' => $this->catalog->byCategory($category),
            'categories' => $this->catalog->categories(),
            'keyword' => '',
            'title' => ucwords(str_replace(['-', '_'], ' ', $category)),
            'activeCategory' => $category,
        ]);
    }

    public function show(int $id): View
    {
        $product = $this->catalog->find($id);

        if ($product === null) {
            abort(404);
        }

        return view('products.show', [
            'product' => $product,
            'categories' => $this->catalog->categories(),
        ]);
    }
}
