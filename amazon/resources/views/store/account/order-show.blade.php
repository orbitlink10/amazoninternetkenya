@extends('layouts.app')

@section('title', 'Order '.$order->order_number)

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10 space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Order {{ $order->order_number }}</h1>
            <p class="text-slate-600">Placed on {{ $order->created_at->format('d M Y H:i') }}</p>
        </div>
        <p class="text-sm text-slate-600">Status: <span class="font-semibold">{{ ucfirst($order->status) }}</span></p>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
        <p class="font-semibold text-slate-900 mb-3">Items</p>
        <div class="divide-y divide-slate-100">
            @foreach($order->items as $item)
                <div class="py-3 flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-slate-900">{{ $item->name }}</p>
                        <p class="text-sm text-slate-600">Qty: {{ $item->quantity }}</p>
                    </div>
                    <p class="font-semibold text-slate-900">KES {{ number_format($item->line_total,2) }}</p>
                </div>
            @endforeach
        </div>
        <div class="border-t border-slate-200 mt-4 pt-4 text-right space-y-1 text-sm text-slate-700">
            <p>Subtotal: KES {{ number_format($order->subtotal,2) }}</p>
            <p>Shipping: KES {{ number_format($order->shipping_fee,2) }}</p>
            <p class="text-lg font-bold text-slate-900">Total: KES {{ number_format($order->total,2) }}</p>
        </div>
    </div>
</div>
@endsection
