@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold text-slate-900 mb-6">Your Cart</h1>

    @if(session('error'))<div class="mb-4 text-rose-700 bg-rose-50 border border-rose-100 rounded px-4 py-3">{{ session('error') }}</div>@endif
    @if(session('success'))<div class="mb-4 text-emerald-700 bg-emerald-50 border border-emerald-100 rounded px-4 py-3">{{ session('success') }}</div>@endif

    @if($cart->items->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <div class="space-y-4">
            @foreach($cart->items as $item)
                <div class="flex items-center justify-between bg-white border border-slate-200 rounded-lg p-4">
                    <div>
                        <p class="font-semibold text-slate-900">{{ $item->product->name }}</p>
                        <p class="text-sm text-slate-600">KES {{ number_format($item->unit_price, 2) }} each</p>
                    </div>
                    <form method="POST" action="{{ route('cart.update', $item->product_id) }}" class="flex items-center gap-2">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="0" class="w-20 rounded border border-slate-200 px-2 py-1">
                        <button class="px-3 py-2 rounded bg-slate-100 text-slate-800">Update</button>
                    </form>
                    <p class="font-semibold text-slate-900">KES {{ number_format($item->subtotal, 2) }}</p>
                </div>
            @endforeach
        </div>
        <div class="mt-6 flex items-center justify-between">
            <form method="POST" action="{{ route('cart.clear') }}">
                @csrf
                <button class="px-4 py-2 rounded border border-slate-200 text-slate-800">Clear cart</button>
            </form>
            <div class="text-right">
                <p class="text-sm text-slate-600">Subtotal</p>
                <p class="text-2xl font-bold text-slate-900">KES {{ number_format($cart->total(), 2) }}</p>
                <a href="{{ route('checkout.show') }}" class="mt-3 inline-flex px-5 py-3 btn-theme font-semibold">Checkout</a>
            </div>
        </div>
    @endif
</div>
@endsection
