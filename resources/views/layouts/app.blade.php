<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Product Catalog') — {{ config('app.name', 'Product Catalogue') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white shadow-sm">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center gap-4 px-4 py-4">
            <a href="{{ route('home') }}" class="text-lg font-semibold text-slate-800 hover:text-red-600">
                {{ config('app.name', 'Product Catalogue') }}
            </a>

            <form action="{{ route('products.index') }}" method="get" class="ml-auto flex min-w-[200px] flex-1 gap-2 sm:max-w-md">
                <input
                    type="search"
                    name="q"
                    value="{{ request('q', $keyword ?? '') }}"
                    placeholder="Search products…"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500"
                />
                <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                    Search
                </button>
            </form>
        </div>

        @isset($categories)
            <nav class="border-t border-slate-100 bg-slate-50">
                <div class="mx-auto flex max-w-6xl flex-wrap gap-2 px-4 py-2">
                    <a
                        href="{{ route('products.index') }}"
                        class="rounded-full px-3 py-1 text-sm {{ empty($activeCategory ?? null) && !request('q') ? 'bg-red-600 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-100' }}"
                    >
                        All
                    </a>
                    @foreach ($categories as $category)
                        <a
                            href="{{ route('products.category', $category->slug) }}"
                            class="rounded-full px-3 py-1 text-sm {{ ($activeCategory ?? null) === $category->slug ? 'bg-red-600 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-100' }}"
                        >
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </nav>
        @endisset
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8">
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white py-6 text-center text-sm text-slate-500">
        Data from <a href="https://fakestoreapi.com" class="text-red-600 hover:underline" target="_blank" rel="noopener">Fake Store API</a>
    </footer>
</body>
</html>
