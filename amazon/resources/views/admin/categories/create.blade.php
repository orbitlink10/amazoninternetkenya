@extends('admin.layout')

@section('title', 'Add Category')

@section('content')
<div class="bg-[#eef2fb] px-4 md:px-8 py-6">
    <h1 class="text-3xl font-bold text-slate-900">Add Category</h1>
    <form method="POST" action="{{ route('admin.categories.store') }}" class="mt-6 space-y-4 bg-white border border-slate-200 rounded-xl shadow-sm p-6">
        @csrf
        @include('admin.categories.partials.form')
        <button class="px-5 py-3 rounded bg-blue-600 text-white font-semibold">Save</button>
    </form>
</div>
@endsection
