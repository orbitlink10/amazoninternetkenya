@extends('admin.layout')

@section('title', 'Categories')

@section('content')
<div class="bg-[#eef2fb] px-4 md:px-8 py-6">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <h1 class="text-3xl font-bold text-slate-900">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="px-5 py-3 rounded-full bg-blue-600 text-white font-semibold shadow-lg shadow-blue-200">➕ Add Category</a>
    </div>
    @if(session('success'))<div class="mt-4 bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>@endif
    <div class="mt-6 bg-white border border-slate-200 rounded-xl shadow-sm overflow-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Name</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Slug</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Parent</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $cat->name }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $cat->slug }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $cat->parent?->name }}</td>
                        <td class="px-4 py-3 flex gap-3">
                            <a href="{{ route('products.index', ['category' => $cat->slug]) }}" target="_blank" class="text-slate-700 hover:text-blue-600">Preview</a>
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Delete category?')">
                                @csrf @method('DELETE')
                                <button class="text-rose-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $categories->links() }}</div>
</div>
@endsection
