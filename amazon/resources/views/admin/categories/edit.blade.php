@extends('admin.layout')

@section('title', 'Edit Category')

@section('content')
<div class="bg-[#eef2fb] px-4 md:px-8 py-6">
    <h1 class="text-3xl font-bold text-slate-900">Edit Category</h1>
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="mt-6 space-y-4 bg-white border border-slate-200 rounded-xl shadow-sm p-6">
        @csrf
        @method('PUT')
        @include('admin.categories.partials.form')
        <button class="px-5 py-3 rounded bg-blue-600 text-white font-semibold">Update</button>
    </form>
</div>
@endsection
