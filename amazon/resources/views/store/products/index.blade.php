@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold text-slate-900 mb-6">Products</h1>

    <form method="GET" class="grid gap-4 md:grid-cols-4 mb-6 bg-white p-4 rounded-lg border border-slate-200 shadow-sm">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..." class="px-3 py-2 rounded border border-slate-200">
        <select name="category" class="px-3 py-2 rounded border border-slate-200">
            <option value="">All categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" @selected(request('category')===$cat->slug)>{{ $cat->name }}</option>
            @endforeach
        </select>
        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min price" class="px-3 py-2 rounded border border-slate-200">
        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max price" class="px-3 py-2 rounded border border-slate-200">
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="featured" value="1" @checked(request('featured'))> Featured
        </label>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="in_stock" value="1" @checked(request('in_stock'))> In stock
        </label>
        @php
            $btnOrangeStyle = 'background:#ff951e;color:#fff;border:none;box-shadow:0 10px 22px rgba(255,149,30,0.28);padding:12px 18px;border-radius:14px;text-decoration:none;';
            $btnBlueOutline = 'border:2px solid #0f3b66;color:#0f3b66;background:#fff;padding:12px 18px;border-radius:14px;text-decoration:none;box-shadow:0 6px 16px rgba(15,59,102,0.12);';
        @endphp
        <button class="md:col-span-2 px-4 py-2 btn-orange" style="{{ $btnOrangeStyle }}">Filter</button>
    </form>

    <div class="grid gap-6 md:grid-cols-3">
        @forelse($products as $product)
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex flex-col">
                @php
                    $firstImage = $product->images->first();
                    $imgUrl = $firstImage?->url;
                    if ($imgUrl && !Str::startsWith($imgUrl, ['http://', 'https://', '//'])) {
                        $imgUrl = asset(ltrim($imgUrl, '/'));
                    }
                @endphp
                @if($imgUrl)
                    <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="h-40 w-full object-contain mb-3">
                @else
                    <div class="h-40 w-full bg-slate-100 text-slate-400 text-sm flex items-center justify-center mb-3 rounded">No image</div>
                @endif
                <h2 class="text-lg font-semibold text-slate-900">{{ $product->name }}</h2>
                @php
                    $desc = $product->meta_description ?? null;
                    if (!$desc) {
                        $desc = Str::limit(strip_tags($product->description), 160);
                    }
                @endphp
                <p class="text-sm text-slate-600 line-clamp-2">{{ $desc }}</p>
                <p class="mt-2 text-xl font-bold text-slate-900">KES {{ number_format($product->sale_price ?? $product->price, 2) }}</p>
                @if($product->sale_price)
                    <p class="text-sm text-emerald-600">On sale (was KES {{ number_format($product->price,2) }})</p>
                @endif
                <p class="text-sm mt-1 {{ $product->inStock() ? 'text-emerald-600' : 'text-rose-600' }}">{{ $product->inStock() ? 'In stock' : 'Out of stock' }}</p>
                        <div class="mt-auto flex gap-2 pt-3">
                            <a href="{{ route('products.show', $product->slug) }}" class="px-3 py-2 btn-orange" style="{{ $btnOrangeStyle }}">View</a>
                            @if($product->inStock())
                                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="flex-1 text-right">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button class="px-3 py-2 btn-orange w-full" style="{{ $btnOrangeStyle }}">Add to cart</button>
                                </form>
                            @endif
                        </div>
            </div>
        @empty
            <p>No products found.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
