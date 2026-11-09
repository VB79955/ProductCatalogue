@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section>
        <h1 class="mb-2 text-2xl font-bold text-slate-900">Featured products</h1>
        <p class="mb-6 text-slate-600">Top {{ count($featured) }} picks by customer rating.</p>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            @foreach ($featured as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>

    <section class="mt-12">
        <h2 class="mb-4 text-xl font-semibold text-slate-900">Browse by category</h2>
        <ul class="flex flex-wrap gap-3">
            @foreach ($categories as $category)
                <li>
                    <a
                        href="{{ route('products.category', $category->slug) }}"
                        class="inline-block rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:border-red-300 hover:text-red-600"
                    >
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </section>
@endsection
