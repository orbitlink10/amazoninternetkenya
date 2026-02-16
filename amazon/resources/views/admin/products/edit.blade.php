@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')
<div class="bg-[#eef2fb] px-4 md:px-8 py-6">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <h1 class="text-3xl font-bold text-slate-900">Edit Product</h1>
    </div>
<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="mt-6 space-y-4 bg-white border border-slate-200 rounded-xl shadow-sm p-6">
        @csrf
        @method('PUT')
        @include('admin.products.partials.form')
        <button class="px-5 py-3 rounded bg-blue-600 text-white font-semibold">Update</button>
    </form>
</div>
@endsection
