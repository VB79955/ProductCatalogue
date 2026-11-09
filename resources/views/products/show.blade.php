@extends('layouts.app')

@section('title', $product->title)

@section('content')
    <div class="grid gap-8 md:grid-cols-2">
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white p-6">
            <img
                src="{{ $product->image }}"
                alt="{{ $product->title }}"
                class="mx-auto h-auto max-h-96 w-full object-contain"
            />
        </div>
        <div>
            <p class="text-sm font-medium uppercase tracking-wide text-red-600">{{ $product->category }}</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $product->title }}</h1>
            <p class="mt-4 text-3xl font-semibold text-slate-800">${{ number_format($product->price, 2) }}</p>
            @if ($product->rating !== null)
                <p class="mt-2 text-sm text-slate-500">Rating: {{ number_format($product->rating, 1) }} / 5</p>
            @endif
            <p class="mt-6 leading-relaxed text-slate-600">{{ $product->description }}</p>
            <a
                href="{{ route('products.category', $product->category) }}"
                class="mt-8 inline-block rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-900"
            >
                More in {{ ucwords($product->category) }}
            </a>
        </div>
    </div>

    <section class="mt-12 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-slate-900">Enquire about this product</h2>
        <p class="mt-1 text-sm text-slate-600">Send us your details and we will get back to you.</p>

        <form action="{{ route('enquiries.store', $product->id) }}" method="post" class="mt-6 grid gap-4 md:grid-cols-2">
            @csrf

            <div class="md:col-span-1">
                <label for="name" class="block text-sm font-medium text-slate-700">Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    required
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('name') border-red-500 @enderror"
                />
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-1">
                <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('email') border-red-500 @enderror"
                />
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-1">
                <label for="phone" class="block text-sm font-medium text-slate-700">Phone</label>
                <input
                    type="tel"
                    name="phone"
                    id="phone"
                    value="{{ old('phone') }}"
                    required
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('phone') border-red-500 @enderror"
                />
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="message" class="block text-sm font-medium text-slate-700">Message</label>
                <textarea
                    name="message"
                    id="message"
                    rows="4"
                    required
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('message') border-red-500 @enderror"
                >{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <button type="submit" class="rounded-lg bg-red-600 px-6 py-2 text-sm font-medium text-white hover:bg-red-700">
                    Submit enquiry
                </button>
            </div>
        </form>
    </section>
@endsection
