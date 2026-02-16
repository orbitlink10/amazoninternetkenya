@extends('admin.layout')

@section('title', 'Create Product')

@section('content')
<div class="bg-[#eef2fb] px-4 md:px-8 py-6">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <span class="inline-flex px-4 py-1.5 rounded-full bg-slate-200 text-xs font-semibold text-slate-700 uppercase tracking-wide">Catalog</span>
            <h1 class="mt-3 text-4xl font-extrabold text-slate-900">Add Product</h1>
            <p class="text-slate-600 text-lg">Capture product details and pricing.</p>
        </div>
        <a href="{{ route('admin.products') }}" class="px-5 py-3 rounded-full border border-slate-300 text-slate-800 font-semibold bg-white flex items-center gap-2">← Back to list</a>
    </div>

    <div class="mt-6 rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <p class="text-lg font-semibold text-slate-900">Product details</p>
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Placeholder form</span>
        </div>
        <div class="px-6 py-10 text-sm text-slate-600 space-y-4">
            <p>Add your form fields here for name, description, price, images, and categories.</p>
            <a href="#" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow-sm">💾 Save Product</a>
        </div>
    </div>
</div>
@endsection
