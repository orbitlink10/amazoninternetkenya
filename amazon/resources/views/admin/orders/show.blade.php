@extends('admin.layout')

@section('title', 'Order '.$order->order_number)

@section('content')
<div class="bg-[#eef2fb] px-4 md:px-8 py-6 space-y-4">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Order {{ $order->order_number }}</h1>
            <p class="text-slate-600">Customer: {{ $order->customer_name }} ({{ $order->customer_phone }})</p>
        </div>
        <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="flex items-center gap-2">
            @csrf
            <select name="status" class="rounded border border-slate-200 px-3 py-2">
                @foreach(['pending','paid','processing','dispatched','delivered','cancelled','refunded'] as $status)
                    <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2 rounded bg-blue-600 text-white font-semibold">Update</button>
        </form>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
        <p class="font-semibold text-slate-900 mb-3">Items</p>
        <div class="divide-y divide-slate-100">
            @foreach($order->items as $item)
                <div class="py-3 flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-slate-900">{{ $item->name }}</p>
                        <p class="text-sm text-slate-600">SKU: {{ $item->sku }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-600">Qty: {{ $item->quantity }}</p>
                        <p class="font-semibold text-slate-900">KES {{ number_format($item->line_total,2) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="border-t border-slate-200 mt-4 pt-4 text-right space-y-1 text-sm text-slate-700">
            <p>Subtotal: KES {{ number_format($order->subtotal,2) }}</p>
            <p>Shipping: KES {{ number_format($order->shipping_fee,2) }}</p>
            <p class="text-lg font-bold text-slate-900">Total: KES {{ number_format($order->total,2) }}</p>
            <p>Status: {{ ucfirst($order->status) }} | Payment: {{ ucfirst($order->payment_status) }}</p>
        </div>
    </div>
</div>
@endsection
