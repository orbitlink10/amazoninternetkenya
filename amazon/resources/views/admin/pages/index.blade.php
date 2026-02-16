@extends('admin.layout')

@section('title', 'Pages')

@section('content')
<div class="bg-[#eef2fb] px-4 md:px-8 py-6">
    <div class="flex items-center justify-between gap-3 flex-wrap">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-500">Manage</p>
            <h1 class="text-3xl font-extrabold text-slate-900">Pages</h1>
            <p class="text-slate-600 text-base">Manage site pages and published content.</p>
        </div>
        <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-lg bg-blue-600 text-white font-semibold shadow-lg shadow-blue-200">➕ Add Page</a>
    </div>

    <div class="mt-6 bg-white border border-slate-200 shadow-sm rounded-2xl">
        <div class="flex items-center justify-between px-4 md:px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-2 text-sm">
                <label class="text-slate-600">Bulk actions</label>
                <select class="rounded border border-slate-200 bg-white px-2 py-1 text-sm text-slate-700">
                    <option>Delete</option>
                    <option>Publish</option>
                </select>
                <button class="ml-2 px-3 py-2 rounded bg-blue-600 text-white text-sm font-semibold">Apply</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-slate-800">
                <thead class="bg-slate-900 text-white text-left">
                    <tr>
                        <th class="px-4 py-3"><input type="checkbox" class="h-4 w-4"></th>
                        <th class="px-4 py-3">No.</th>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Alt Text</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($posts as $post)
                        <tr class="bg-white hover:bg-slate-50">
                            <td class="px-4 py-3"><input type="checkbox" class="h-4 w-4"></td>
                            <td class="px-4 py-3 font-semibold text-slate-800">{{ $post['id'] }}</td>
                            <td class="px-4 py-3">
                                <div class="w-20 h-20 rounded border border-slate-200 overflow-hidden bg-slate-100 flex items-center justify-center">
                                @php
                                    $img = $post['image'] ?? null;
                                    if ($img && !str_starts_with($img, 'http')) {
                                        $img = asset('storage/' . ltrim($img, '/'));
                                    }
                                    $img = $img ?: 'https://via.placeholder.com/120x120?text=No+Image';
                                @endphp
                                <img src="{{ $img }}" alt="{{ $post['alt'] ?? $post['title'] }}" class="w-full h-full object-contain">
                            </div>
                        </td>
                        <td class="px-4 py-3 font-semibold">{{ $post['title'] }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $post['alt'] }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ $post['type'] }}</td>
                        <td class="px-4 py-3 space-x-2 whitespace-nowrap">
                                <a href="{{ route('pages.preview', $post['slug']) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-cyan-50 text-cyan-700 border border-cyan-200 text-xs font-semibold">👁️ Preview</a>
                                <a class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-amber-50 text-amber-700 border border-amber-200 text-xs font-semibold">✏️ Update</a>
                                <a class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-rose-50 text-rose-700 border border-rose-200 text-xs font-semibold">🗑️ Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
