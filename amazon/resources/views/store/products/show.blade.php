@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 space-y-10">
    {{-- Breadcrumb --}}
    <div class="text-sm text-slate-500 flex items-center gap-2">
        <a href="{{ url('/') }}" class="hover:text-blue-600">Home</a>
        <span>/</span>
        @if($product->category)
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-blue-600">{{ $product->category->name }}</a>
            <span>/</span>
        @endif
        <span class="text-slate-700 font-semibold">{{ $product->name }}</span>
    </div>

    <div class="grid gap-10 lg:grid-cols-2">
        {{-- Gallery --}}
        <div class="space-y-4">
            <div class="aspect-[4/3] rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden flex items-center justify-center">
                @if($product->images->count())
                    <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                @else
                    <div class="text-slate-400 text-sm">No image</div>
                @endif
            </div>
            @if($product->images->count() > 1)
                <div class="flex gap-3 overflow-x-auto pb-2">
                    @foreach($product->images as $img)
                        <img src="{{ $img->url }}" class="h-16 w-20 object-cover rounded-lg border border-slate-200" alt="thumb">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Purchase panel --}}
        <div class="space-y-4">
            <h1 class="text-3xl font-bold text-slate-900 leading-tight">{{ $product->name }}</h1>
            @php
                $price = $product->price;
                $sale = $product->sale_price;
                $final = $sale ?? $price;
                $discount = $sale ? round((($price - $sale) / $price) * 100, 2) : null;
            @endphp
            <div class="flex items-center gap-3">
                <p class="text-3xl font-extrabold text-slate-900">KES {{ number_format($final, 2) }}</p>
                @if($sale)
                    <p class="text-lg line-through text-slate-400">KES {{ number_format($price, 2) }}</p>
                    <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">{{ $discount }}% Off</span>
                @endif
            </div>
            <p class="{{ $product->inStock() ? 'text-emerald-600' : 'text-rose-600' }} font-semibold">
                {{ $product->inStock() ? 'In stock' : 'Out of stock' }}
            </p>
            <div class="text-slate-600 leading-relaxed space-y-3">
                {!! Str::limit(strip_tags($product->description), 360, '...') !!}
            </div>

            <form method="POST" action="{{ route('cart.add', $product->id) }}" class="space-y-3">
                @csrf
                <label class="block text-sm font-semibold text-slate-700" for="quantity">Quantity</label>
                        @php
                            $btnOrangeStyle = 'background:#ff951e;color:#fff;border:none;box-shadow:0 10px 22px rgba(255,149,30,0.28);padding:12px 18px;border-radius:14px;text-decoration:none;';
                        @endphp
                        <div class="flex items-center gap-3">
                            <input type="number" id="quantity" name="quantity" value="1" min="1" class="w-24 rounded border border-slate-200 px-3 py-2">
                            <button class="btn-orange px-5 py-3 disabled:opacity-60" style="{{ $btnOrangeStyle }}" {{ $product->inStock() ? '' : 'disabled' }}>
                                {{ $product->inStock() ? 'Add to cart' : 'Out of stock' }}
                            </button>
                        </div>
                    </form>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
        <div class="border-b border-slate-200 pb-3 mb-4">
            <span class="text-sm font-semibold text-slate-900">Description</span>
        </div>
        <div class="rich-copy">
            {!! $product->description !!}
        </div>
    </div>

    @if($related->count())
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-slate-900">Related products</h2>
            <div class="grid gap-4 md:grid-cols-3">
                @foreach($related as $rel)
                    <a href="{{ route('products.show', $rel->slug) }}" class="block rounded-xl border border-slate-200 bg-white p-4 hover:border-blue-200 transition">
                        <p class="font-semibold text-slate-900">{{ $rel->name }}</p>
                        <p class="text-sm text-slate-600">KES {{ number_format($rel->sale_price ?? $rel->price, 2) }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
