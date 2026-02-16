@extends('admin.layout')

@section('title', 'Admin Login')
@php($hideSidebar = true)

@section('content')
<div class="flex flex-1 items-center justify-center py-16 px-6">
    <div class="w-full max-w-md bg-white border border-slate-200 shadow-xl rounded-2xl p-8">
        <h1 class="text-2xl font-bold text-slate-900">Admin Login</h1>
        <p class="mt-1 text-sm text-slate-600">Use the provided demo credentials.</p>

        @if(session('error'))
            <div class="mt-4 rounded-lg bg-red-50 text-red-700 px-4 py-3 text-sm">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="mt-4 rounded-lg bg-green-50 text-green-700 px-4 py-3 text-sm">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-semibold text-slate-800">Email</label>
                <input type="email" name="email" value="{{ old('email', 'admin@demo.com') }}" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" required>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-800">Password</label>
                <input type="password" name="password" value="12345678" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" required>
            </div>
            <button type="submit" class="w-full rounded-lg bg-blue-600 text-white py-3 font-semibold shadow-md hover:bg-blue-700">Sign in</button>
        </form>
    </div>
</div>
@endsection
