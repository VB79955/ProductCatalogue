@extends('layouts.app')

@section('title', $title ?? 'Products')

@section('content')
    <h1 class="mb-6 text-2xl font-bold text-slate-900">{{ $title ?? 'Products' }}</h1>

    @if (count($products) === 0)
        <p class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-600">
            No products found. Try another keyword or category.
        </p>
    @else
        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    @endif
@endsection
