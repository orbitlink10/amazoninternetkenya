@extends('admin.layout')

@section('title', 'Edit Page')

@section('content')
<div class="bg-[#eef2fb] px-4 md:px-8 py-6">
    <div class="flex items-center justify-between gap-3 flex-wrap mb-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-500">Manage</p>
            <h1 class="text-3xl font-extrabold text-slate-900">Edit Page</h1>
            <p class="text-slate-600 text-base">Update published content and preview it on the site.</p>
        </div>
        <a href="{{ route('admin.pages') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 bg-white text-slate-800 font-semibold">Back</a>
    </div>

    <form action="{{ route('admin.pages.update', $page['id']) }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700" for="meta_title">Meta Title</label>
                <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $page['meta_title'] ?? '') }}" class="w-full rounded-lg border border-slate-200 px-4 py-3 focus:ring focus:ring-blue-100 focus:border-blue-400" required maxlength="160">
                @error('meta_title')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700" for="meta_description">Meta Description</label>
                <input type="text" id="meta_description" name="meta_description" value="{{ old('meta_description', $page['meta_description'] ?? '') }}" class="w-full rounded-lg border border-slate-200 px-4 py-3 focus:ring focus:ring-blue-100 focus:border-blue-400" maxlength="255">
                @error('meta_description')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700" for="title">Page Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $page['title'] ?? '') }}" class="w-full rounded-lg border border-slate-200 px-4 py-3 focus:ring focus:ring-blue-100 focus:border-blue-400" required maxlength="180">
                @error('title')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700" for="alt">Image Alt Text</label>
                <input type="text" id="alt" name="alt" value="{{ old('alt', $page['alt'] ?? '') }}" class="w-full rounded-lg border border-slate-200 px-4 py-3 focus:ring focus:ring-blue-100 focus:border-blue-400" maxlength="160">
                @error('alt')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700" for="type">Type</label>
                <select id="type" name="type" class="w-full rounded-lg border border-slate-200 px-4 py-3 focus:ring focus:ring-blue-100 focus:border-blue-400" required>
                    @php($selectedType = old('type', $page['type'] ?? 'Post'))
                    <option value="Post" {{ $selectedType === 'Post' ? 'selected' : '' }}>Post</option>
                    <option value="Page" {{ $selectedType === 'Page' ? 'selected' : '' }}>Page</option>
                </select>
                @error('type')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700" for="image">Hero Image</label>
                <input type="file" id="image" name="image" accept="image/*" class="w-full rounded-lg border border-slate-200 px-4 py-3 bg-white focus:ring focus:ring-blue-100 focus:border-blue-400">
                <p class="text-xs text-slate-500">Leave empty to keep the current image.</p>
                @error('image')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-700" for="description">Page Description</label>
            <textarea id="description" name="description" rows="12" class="w-full rounded-lg border border-slate-200 px-4 py-3 focus:ring focus:ring-blue-100 focus:border-blue-400">{{ old('description', $page['description'] ?? '') }}</textarea>
            @error('description')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-5 py-3 rounded-lg bg-blue-600 text-white font-semibold shadow-md">Update</button>
            <a href="{{ route('admin.pages') }}" class="px-5 py-3 rounded-lg border border-slate-200 text-slate-800 font-semibold bg-white">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    @once
        <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
    @endonce
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.tinymce) {
                tinymce.init({
                    selector: '#description',
                    menubar: true,
                    plugins: 'link lists table code image media',
                    toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link table | code',
                    height: 420,
                });
            }
        });
    </script>
@endpush
