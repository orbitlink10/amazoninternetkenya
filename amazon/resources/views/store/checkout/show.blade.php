@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold text-slate-900 mb-6">Checkout</h1>
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('checkout.place') }}" class="space-y-6">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Full name</label>
                    <input name="name" value="{{ old('name') }}" class="w-full rounded border border-slate-200 px-3 py-2" required>
                    @error('name')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Phone</label>
                    <input name="phone" value="{{ old('phone') }}" class="w-full rounded border border-slate-200 px-3 py-2" required>
                    @error('phone')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded border border-slate-200 px-3 py-2" required>
                    @error('email')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700">County</label>
                    <input name="county" value="{{ old('county') }}" class="w-full rounded border border-slate-200 px-3 py-2" required>
                    @error('county')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Town</label>
                    <input name="town" value="{{ old('town') }}" class="w-full rounded border border-slate-200 px-3 py-2" required>
                    @error('town')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Street / Estate</label>
                    <input name="street" value="{{ old('street') }}" class="w-full rounded border border-slate-200 px-3 py-2" required>
                    @error('street')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700">Notes (optional)</label>
                <textarea name="notes" rows="3" class="w-full rounded border border-slate-200 px-3 py-2">{{ old('notes') }}</textarea>
                @error('notes')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Payment method</label>
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="radio" name="payment_method" value="cod" checked> Cash on Delivery
                </label>
            </div>
            <div class="border-t border-slate-200 pt-4 flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600">Subtotal: KES {{ number_format($cart->total(),2) }}</p>
                    <p class="text-sm text-slate-600">Shipping: KES {{ number_format($shippingFee,2) }}</p>
                    <p class="text-lg font-bold text-slate-900">Total: KES {{ number_format($total,2) }}</p>
                </div>
                <button class="px-5 py-3 rounded bg-blue-600 text-white font-semibold">Place Order</button>
            </div>
        </form>
    </div>
</div>
@endsection
