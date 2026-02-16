@extends('admin.layout')

@section('title', 'Products')

@section('content')
<div class="bg-[#eef2fb] px-4 md:px-8 py-6">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Products</h1>
            <p class="text-slate-600">Manage catalog, pricing, and stock.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="px-5 py-3 rounded-full bg-blue-600 text-white font-semibold shadow-lg shadow-blue-200">➕ Add Product</a>
    </div>

    @if(session('success'))<div class="mt-4 bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>@endif

    <div class="mt-6 bg-white border border-slate-200 rounded-xl shadow-sm overflow-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Name</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">SKU</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Price</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Stock</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $product->sku }}</td>
                        <td class="px-4 py-3 text-slate-600">KES {{ number_format($product->sale_price ?? $product->price, 2) }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $product->stock_quantity }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td class="px-4 py-3 flex gap-3">
                            <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="text-slate-700 hover:text-blue-600">Preview</a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete product?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
