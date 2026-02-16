@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-[#eef2fb] px-4 md:px-8 py-6">
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-100 text-green-700 px-4 py-3 text-sm shadow-sm">{{ session('success') }}</div>
    @endif
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <span class="inline-flex px-4 py-1.5 rounded-full bg-slate-200 text-xs font-semibold text-slate-700 uppercase tracking-wide">Admin overview</span>
            <h1 class="mt-3 text-4xl font-extrabold text-slate-900">Dashboard</h1>
            <p class="text-slate-600 text-lg">View and manage all customer orders</p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <a href="#" class="px-5 py-3 rounded-full bg-blue-600 text-white font-semibold shadow-lg shadow-blue-200 flex items-center gap-2">➕ New Invoice</a>
            <a href="{{ route('admin.users') }}" class="px-5 py-3 rounded-full border border-slate-300 text-slate-800 font-semibold bg-white flex items-center gap-2">👥 Manage Users</a>
            <a href="{{ route('admin.products.create') }}" class="px-5 py-3 rounded-full border border-slate-300 text-slate-800 font-semibold bg-white flex items-center gap-2">⚙️ Manage Products</a>
        </div>
    </div>

    <div class="mt-8 grid gap-4 xl:grid-cols-4 md:grid-cols-2">
        @php
            $summary = [
                ['label' => 'Orders', 'value' => 5, 'cta' => 'View orders', 'color' => 'bg-blue-50', 'text' => 'text-blue-900', 'pill' => 'bg-blue-100', 'icon' => '🛍️', 'href' => '#'],
                ['label' => 'Invoices', 'value' => 1, 'cta' => 'View invoices', 'color' => 'bg-green-50', 'text' => 'text-emerald-900', 'pill' => 'bg-emerald-100', 'icon' => '📄', 'href' => '#'],
                ['label' => 'Users', 'value' => 6, 'cta' => 'View users', 'color' => 'bg-amber-50', 'text' => 'text-amber-900', 'pill' => 'bg-amber-100', 'icon' => '👥', 'href' => route('admin.users')],
                ['label' => 'Products', 'value' => 3, 'cta' => 'View products', 'color' => 'bg-cyan-50', 'text' => 'text-cyan-900', 'pill' => 'bg-cyan-100', 'icon' => '🛒', 'href' => route('admin.products')],
            ];
        @endphp
        @foreach($summary as $card)
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-5 overflow-hidden relative">
                <div class="absolute right-0 top-0 h-24 w-24 {{ $card['pill'] }} rounded-full translate-x-6 -translate-y-6"></div>
                <div class="relative flex items-center gap-3">
                    <span class="h-11 w-11 rounded-xl {{ $card['pill'] }} flex items-center justify-center text-lg">{{ $card['icon'] }}</span>
                    <p class="tracking-[0.2em] text-xs font-semibold text-slate-600 uppercase">{{ $card['label'] }}</p>
                </div>
                <p class="relative mt-4 text-4xl font-bold text-slate-900">{{ $card['value'] }}</p>
                <a href="{{ $card['href'] }}" class="relative mt-2 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700">{{ $card['cta'] }} →</a>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid gap-4 lg:grid-cols-4 md:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-5">
            <p class="text-xs font-semibold tracking-[0.25em] text-slate-500 uppercase">Total Revenue</p>
            <p class="mt-4 text-4xl font-bold text-slate-900">KSh 0.00</p>
            <p class="text-sm text-slate-500 mt-1">Paid orders</p>
        </div>
        <div class="rounded-2xl border border-blue-200 bg-white shadow-sm p-5">
            <p class="text-xs font-semibold tracking-[0.25em] text-slate-500 uppercase">Recent Orders</p>
            <p class="mt-4 text-3xl font-bold text-slate-900">0</p>
            <p class="text-sm text-slate-500 mt-1">Last 7 days</p>
        </div>
        <div class="rounded-2xl border border-emerald-200 bg-white shadow-sm p-5">
            <p class="text-xs font-semibold tracking-[0.25em] text-slate-500 uppercase">New Users</p>
            <p class="mt-4 text-3xl font-bold text-slate-900">1</p>
            <p class="text-sm text-slate-500 mt-1">Last 30 days</p>
        </div>
        <div class="rounded-2xl border border-amber-200 bg-white shadow-sm p-5">
            <p class="text-xs font-semibold tracking-[0.25em] text-slate-500 uppercase">Active Users</p>
            <p class="mt-4 text-3xl font-bold text-slate-900">0</p>
            <p class="text-sm text-slate-500 mt-1">Last 24 hours</p>
        </div>
    </div>

    <div class="mt-6 grid gap-4 xl:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <p class="text-lg font-semibold text-slate-900">Recent Activities</p>
                <p class="text-sm text-slate-500">Latest updates</p>
            </div>
            <div class="px-6 py-8 text-slate-500 text-sm">No recent activity yet.</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <p class="text-lg font-semibold text-slate-900">Quick Actions</p>
                <p class="text-sm text-slate-500">Shortcuts</p>
            </div>
            <div class="divide-y divide-slate-100">
                <div class="flex items-center gap-4 px-6 py-5">
                    <span class="h-11 w-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl">＋</span>
                    <div>
                        <p class="font-semibold text-slate-900">Add New Invoice</p>
                        <p class="text-sm text-slate-600">Generate and send payment requests</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 px-6 py-5">
                    <span class="h-11 w-11 rounded-xl bg-cyan-50 text-cyan-700 flex items-center justify-center text-xl">👥</span>
                    <div>
                        <p class="font-semibold text-slate-900">Manage Users</p>
                        <p class="text-sm text-slate-600">Review customers and permissions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
