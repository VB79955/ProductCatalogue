<article class="flex flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
    <a href="{{ route('products.show', $product->id) }}" class="block aspect-square overflow-hidden bg-slate-100">
        <img
            src="{{ $product->image }}"
            alt="{{ $product->title }}"
            class="h-full w-full object-contain p-4"
            loading="lazy"
        />
    </a>
    <div class="flex flex-1 flex-col gap-2 p-4">
        <h3 class="line-clamp-2 text-sm font-medium text-slate-800">
            <a href="{{ route('products.show', $product->id) }}" class="hover:text-red-600">
                {{ $product->title }}
            </a>
        </h3>
        <p class="mt-auto text-lg font-semibold text-red-600">${{ number_format($product->price, 2) }}</p>
        @if ($product->rating !== null)
            <p class="text-xs text-slate-500">Rating: {{ number_format($product->rating, 1) }}/5</p>
        @endif
    </div>
</article>
