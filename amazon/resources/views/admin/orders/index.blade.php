@extends('admin.layout')

@section('title', 'Orders')

@section('content')
<div class="bg-[#eef2fb] px-4 md:px-8 py-6">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <h1 class="text-3xl font-bold text-slate-900">Orders</h1>
    </div>

    <form method="GET" class="mt-4 grid gap-3 md:grid-cols-4 bg-white border border-slate-200 rounded-xl shadow-sm p-4">
        <select name="status" class="rounded border border-slate-200 px-3 py-2">
            <option value="">Status</option>
            @foreach(['pending','paid','processing','dispatched','delivered','cancelled','refunded'] as $status)
                <option value="{{ $status }}" @selected(request('status')===$status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <select name="payment_status" class="rounded border border-slate-200 px-3 py-2">
            <option value="">Payment</option>
            @foreach(['unpaid','paid'] as $p)
                <option value="{{ $p }}" @selected(request('payment_status')===$p)>{{ ucfirst($p) }}</option>
            @endforeach
        </select>
        <input type="date" name="from" value="{{ request('from') }}" class="rounded border border-slate-200 px-3 py-2">
        <input type="date" name="to" value="{{ request('to') }}" class="rounded border border-slate-200 px-3 py-2">
        <button class="md:col-span-4 px-4 py-2 rounded bg-blue-600 text-white font-semibold">Filter</button>
    </form>

    <div class="mt-6 bg-white border border-slate-200 rounded-xl shadow-sm overflow-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Order #</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Customer</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Total</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Payment</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $order->order_number }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ $order->customer_name }}</td>
                        <td class="px-4 py-3 text-slate-700">KES {{ number_format($order->total,2) }}</td>
                        <td class="px-4 py-3">{{ ucfirst($order->status) }}</td>
                        <td class="px-4 py-3">{{ ucfirst($order->payment_status) }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
</div>
@endsection
