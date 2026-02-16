<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="block text-sm font-semibold text-slate-700">Name</label>
        <input id="category_name" data-category-name name="name" value="{{ old('name', $category->name ?? '') }}" class="w-full rounded border border-slate-200 px-3 py-2" required>
        @error('name')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700">Slug</label>
        <input id="category_slug" data-category-slug name="slug" value="{{ old('slug', $category->slug ?? '') }}" class="w-full rounded border border-slate-200 px-3 py-2">
        @error('slug')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700">Parent</label>
        <select name="parent_id" class="w-full rounded border border-slate-200 px-3 py-2">
            <option value="">-- None --</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id ?? '')==$parent->id)>{{ $parent->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="md:col-span-2 space-y-3">
    <label class="block text-sm font-semibold text-slate-700">Meta description</label>
    <input name="meta_description" value="{{ old('meta_description', $category->meta_description ?? '') }}" class="w-full rounded border border-slate-200 px-3 py-2" maxlength="255">
    @error('meta_description')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
</div>

<div class="space-y-3">
    <label class="block text-sm font-semibold text-slate-700">Description</label>
    <textarea id="category_description" name="description" class="w-full rounded border border-slate-200" rows="8">{{ old('description', $category->description ?? '') }}</textarea>
    @error('description')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
</div>

@push('scripts')
    @once
        <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
    @endonce
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.tinymce && !tinymce.get('category_description')) {
                tinymce.init({
                    selector: '#category_description',
                    menubar: true,
                    plugins: 'link lists table code',
                    toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link table | code',
                    height: 280,
                });
            }

            const nameInput = document.querySelector('[data-category-name]');
            const slugInput = document.querySelector('[data-category-slug]');
            if (!nameInput || !slugInput) return;

            let slugDirty = !!slugInput.value;
            slugInput.addEventListener('input', () => slugDirty = true);

            const slugify = (text) =>
                text.toString().toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '')
                    .substring(0, 120);

            nameInput.addEventListener('input', () => {
                if (slugDirty) return;
                slugInput.value = slugify(nameInput.value);
            });
        });
    </script>
@endpush
