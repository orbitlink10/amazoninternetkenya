@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold text-slate-900 mb-6">My Orders</h1>
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Order #</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Date</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Total</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $order->order_number }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-slate-600">KES {{ number_format($order->total,2) }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ ucfirst($order->status) }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('account.orders.show', $order) }}" class="text-blue-600">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-4 py-3" colspan="5">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
</div>
@endsection
