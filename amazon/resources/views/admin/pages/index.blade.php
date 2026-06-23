@extends('admin.layout')

@section('title', 'Pages')

@section('content')
<div class="bg-[#eef2fb] px-4 md:px-8 py-6">
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-100 text-green-700 px-4 py-3 text-sm shadow-sm">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-4 rounded-lg bg-rose-50 border border-rose-100 text-rose-700 px-4 py-3 text-sm shadow-sm">{{ $errors->first() }}</div>
    @endif

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
                <form id="bulk-pages-form" method="POST" action="{{ route('admin.pages.bulk') }}">
                    @csrf
                </form>
                <label for="bulk_action" class="text-slate-600">Bulk actions</label>
                <select id="bulk_action" name="bulk_action" form="bulk-pages-form" class="rounded border border-slate-200 bg-white px-2 py-1 text-sm text-slate-700">
                    <option value="delete">Delete</option>
                </select>
                <button type="submit" form="bulk-pages-form" class="ml-2 px-3 py-2 rounded bg-blue-600 text-white text-sm font-semibold" onclick="return confirm('Apply this action to selected pages?')">Apply</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-slate-800">
                <thead class="bg-slate-900 text-white text-left">
                    <tr>
                        <th class="px-4 py-3"><input type="checkbox" id="select-all-pages" class="h-4 w-4"></th>
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
                            <td class="px-4 py-3"><input type="checkbox" name="selected_ids[]" value="{{ $post['id'] }}" form="bulk-pages-form" class="page-checkbox h-4 w-4"></td>
                            <td class="px-4 py-3 font-semibold text-slate-800">{{ $post['id'] }}</td>
                            <td class="px-4 py-3">
                                <div class="w-20 h-20 rounded border border-slate-200 overflow-hidden bg-slate-100 flex items-center justify-center">
                                @php
                                    $img = $post['image'] ?? null;
                                    if ($img && str_starts_with($img, '/storage/')) {
                                        $img = asset(ltrim($img, '/'));
                                    } elseif ($img && str_starts_with($img, 'storage/')) {
                                        $img = asset($img);
                                    } elseif ($img && !str_starts_with($img, 'http')) {
                                        $img = asset('storage/' . ltrim($img, '/'));
                                    }
                                    $img = $img ?: 'https://via.placeholder.com/120x120?text=No+Image';
                                @endphp
                                <img src="{{ $img }}" alt="{{ $post['alt'] ?? $post['title'] }}" class="w-full h-full object-contain" onerror="this.onerror=null;this.src='https://via.placeholder.com/120x120?text=No+Image';">
                            </div>
                        </td>
                        <td class="px-4 py-3 font-semibold">{{ $post['title'] }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $post['alt'] }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ $post['type'] }}</td>
                        <td class="px-4 py-3 space-x-2 whitespace-nowrap">
                                <a href="{{ route('pages.preview', $post['slug']) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-cyan-50 text-cyan-700 border border-cyan-200 text-xs font-semibold">👁️ Preview</a>
                                <a href="{{ route('admin.pages.edit', $post['id']) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-amber-50 text-amber-700 border border-amber-200 text-xs font-semibold">✏️ Update</a>
                                <form method="POST" action="{{ route('admin.pages.destroy', $post['id']) }}" class="inline" onsubmit="return confirm('Delete this page?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-rose-50 text-rose-700 border border-rose-200 text-xs font-semibold">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectAll = document.getElementById('select-all-pages');
            const checkboxes = document.querySelectorAll('.page-checkbox');

            selectAll?.addEventListener('change', () => {
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = selectAll.checked;
                });
            });
        });
    </script>
@endpush
