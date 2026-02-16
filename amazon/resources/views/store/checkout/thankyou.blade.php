@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12 text-center">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-10">
        <p class="text-5xl mb-4">✅</p>
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Thank you!</h1>
        <p class="text-slate-600">Your order <span class="font-semibold">#{{ $order->order_number }}</span> has been received.</p>
        <p class="text-slate-600 mt-2">We will contact you on {{ $order->customer_phone }} to confirm delivery.</p>
        <a href="{{ route('products.index') }}" class="mt-6 inline-flex px-5 py-3 rounded bg-blue-600 text-white font-semibold">Continue shopping</a>
    </div>
</div>
@endsection
