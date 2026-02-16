@extends('admin.layout')

@section('title', 'Users')

@section('content')
<div class="bg-[#eef2fb] px-4 md:px-8 py-6">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <span class="inline-flex px-4 py-1.5 rounded-full bg-slate-200 text-xs font-semibold text-slate-700 uppercase tracking-wide">Admin panel</span>
            <h1 class="mt-3 text-4xl font-extrabold text-slate-900">Users</h1>
            <p class="text-slate-600 text-lg">Manage administrators and customer accounts.</p>
        </div>
        <a href="#" class="px-5 py-3 rounded-full bg-blue-600 text-white font-semibold shadow-lg shadow-blue-200 flex items-center gap-2">➕ Add User</a>
    </div>

    <div class="mt-6 rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <p class="text-lg font-semibold text-slate-900">User list</p>
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Coming soon</span>
        </div>
        <div class="px-6 py-10 text-sm text-slate-600">
            This section is ready for wiring to your data source. Add your user retrieval logic here.
        </div>
    </div>
</div>
@endsection
