<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\AdminAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $product = Product::create($data);

        $allUrls = $this->collectImageUrls($request, $product);
        $this->syncImages($product, $allUrls);
        AdminAuditLog::create(['admin_id' => auth()->id(), 'action' => 'product.create', 'details' => $product->id]);

        return redirect()->route('admin.products')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request, $product->id);
        $product->update($data);
        $allUrls = $this->collectImageUrls($request, $product);
        $this->syncImages($product, $allUrls);
        AdminAuditLog::create(['admin_id' => auth()->id(), 'action' => 'product.update', 'details' => $product->id]);

        return redirect()->route('admin.products')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        AdminAuditLog::create(['admin_id' => auth()->id(), 'action' => 'product.delete', 'details' => $product->id]);
        return back()->with('success', 'Product deleted.');
    }

    private function validateData(Request $request, ?int $id = null): array
    {
        // Always derive slug from the name before validation so uniqueness is checked on the final value
        $request->merge([
            'slug' => Str::slug($request->input('name', '')),
        ]);

        $data = $request->validate([
            'name' => 'required|string|max:180',
            'slug' => ['required','string','max:180', Rule::unique('products','slug')->ignore($id)],
            'sku' => ['nullable','string','max:80', Rule::unique('products','sku')->ignore($id)],
            'description' => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'currency' => 'required|string|size:3',
            'category_id' => 'nullable|exists:categories,id',
            'brand' => 'nullable|string|max:120',
            'stock_quantity' => 'required|integer|min:0',
            'is_featured' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'images_files' => 'nullable|array',
            'images_files.*' => 'image|max:2048',
        ], [], [
            'slug' => 'slug',
        ]);

        // Force slug from product name (already merged)
        $data['slug'] = Str::slug($data['name']);
        // Auto-generate SKU if none provided
        $data['sku'] = $data['sku'] ?? strtoupper(Str::slug($data['name'], '-'));

        return $data;
    }

    private function syncImages(Product $product, array $urls): void
    {
        $product->images()->delete();
        foreach ($urls as $index => $url) {
            ProductImage::create([
                'product_id' => $product->id,
                'url' => $url,
                'sort_order' => $index,
            ]);
        }
    }

    private function mergeImagesArray(Request $request): void
    {
        if ($request->filled('images_raw') && !$request->has('images')) {
            $images = array_filter(array_map('trim', explode(',', $request->input('images_raw'))));
            $request->merge(['images' => $images]);
        }
    }

    private function collectImageUrls(Request $request, Product $product): array
    {
        $urls = [];

        if ($request->hasFile('images_files')) {
            foreach ($request->file('images_files') as $file) {
                $path = $file->store('products', 'public');
                $urls[] = Storage::url($path);
            }
        } else {
            // If no new uploads, keep existing images
            $urls = $product->images()->pluck('url')->toArray();
        }

        // Ensure stable ordering and unique values
        $urls = array_values(array_filter(array_unique($urls)));
        return $urls;
    }
}
