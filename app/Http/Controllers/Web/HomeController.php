<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ProductCatalogService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly ProductCatalogService $catalog,
    ) {}

    public function index(): View
    {
        return view('home', [
            'featured' => $this->catalog->featured(),
            'categories' => $this->catalog->categories(),
        ]);
    }
}
