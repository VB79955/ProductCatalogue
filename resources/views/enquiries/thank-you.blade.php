@extends('layouts.app')

@section('title', 'Thank you')

@section('content')
    <div class="mx-auto max-w-lg rounded-xl border border-slate-200 bg-white p-8 text-center shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900">Thank you for your enquiry</h1>
        <p class="mt-4 text-slate-600">
            We have received your message and will respond to <strong>{{ $enquiry->email }}</strong> soon.
        </p>
        <p class="mt-4 text-sm text-slate-500">
            Your reference number is
            <span class="font-mono font-medium text-slate-800">{{ $enquiry->reference }}</span>
        </p>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a
                href="{{ route('products.show', $enquiry->product_id) }}"
                class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
            >
                Back to product
            </a>
            <a
                href="{{ route('home') }}"
                class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                Home
            </a>
        </div>
    </div>
@endsection
