<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="block text-sm font-semibold text-slate-700">Name</label>
        <input id="product_name" data-product-name name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full rounded border border-slate-200 px-3 py-2" required>
        @error('name')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700">SKU</label>
        <input id="product_sku" data-product-sku name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="w-full rounded border border-slate-200 px-3 py-2">
        @error('sku')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700">Slug</label>
        <input id="product_slug" data-product-slug name="slug" value="{{ old('slug', $product->slug ?? '') }}" class="w-full rounded border border-slate-200 px-3 py-2">
        @error('slug')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700">Category</label>
        <select name="category_id" class="w-full rounded border border-slate-200 px-3 py-2">
            <option value="">-- None --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? '')==$cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        @error('category_id')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-slate-700">Meta description</label>
        <input name="meta_description" value="{{ old('meta_description', $product->meta_description ?? '') }}" class="w-full rounded border border-slate-200 px-3 py-2" maxlength="255">
        @error('meta_description')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700">Price</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" class="w-full rounded border border-slate-200 px-3 py-2" required>
        @error('price')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700">Sale price</label>
        <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price ?? '') }}" class="w-full rounded border border-slate-200 px-3 py-2">
        @error('sale_price')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700">Currency</label>
        <input name="currency" value="{{ old('currency', $product->currency ?? 'KES') }}" class="w-full rounded border border-slate-200 px-3 py-2" required>
        @error('currency')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700">Brand</label>
        <input name="brand" value="{{ old('brand', $product->brand ?? '') }}" class="w-full rounded border border-slate-200 px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700">Stock quantity</label>
        <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" class="w-full rounded border border-slate-200 px-3 py-2" required>
        @error('stock_quantity')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700">Upload images</label>
        <input type="file" name="images_files[]" multiple accept="image/*" class="w-full rounded border border-slate-200 px-3 py-2">
        <p class="text-xs text-slate-500">You can upload multiple JPG/PNG files (max 2MB each).</p>
        @error('images_files.*')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div class="flex items-center gap-3">
        <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false))> Featured</label>
        <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))> Active</label>
    </div>
</div>

<div class="space-y-3">
    <label class="block text-sm font-semibold text-slate-700">Description</label>
    <textarea id="description" name="description" class="w-full rounded border border-slate-200" rows="10">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
</div>

@php
    // convert comma separated images into array before submit
    if(request()->isMethod('post') || request()->isMethod('put')){
        $images = array_filter(array_map('trim', explode(',', request()->input('images_raw'))));
        request()->merge(['images' => $images]);
    }
@endphp

@push('scripts')
    @once
        <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
    @endonce
    <script>
        tinymce.init({
            selector: '#description',
            menubar: true,
            plugins: 'link lists table code',
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link table | code',
            height: 320,
        });

        // Auto-generate slug and SKU from name (only if user hasn't typed them)
        (() => {
            const nameInput = document.querySelector('[data-product-name]');
            const slugInput = document.querySelector('[data-product-slug]');
            const skuInput  = document.querySelector('[data-product-sku]');
            if (!nameInput || !slugInput || !skuInput) return;

            let slugDirty = !!slugInput.value;
            let skuDirty  = !!skuInput.value;

            slugInput.addEventListener('input', () => slugDirty = true);
            skuInput.addEventListener('input', () => skuDirty = true);

            const slugify = (text) =>
                text.toString().toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '')
                    .substring(0, 180);

            nameInput.addEventListener('input', () => {
                const base = slugify(nameInput.value);
                if (!slugDirty) slugInput.value = base;
                if (!skuDirty && base) {
                    const code = base.replace(/-/g, '').toUpperCase();
                    skuInput.value = code.substring(0, 10) || '';
                }
            });
        })();
    </script>
@endpush
