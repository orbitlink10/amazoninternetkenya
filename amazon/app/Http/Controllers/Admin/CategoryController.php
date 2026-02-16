<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAuditLog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::all();
        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Category::create($data);
        AdminAuditLog::create(['admin_id' => auth()->id(), 'action' => 'category.create', 'details' => $data['name']]);
        return redirect()->route('admin.categories')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        $parents = Category::where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validateData($request, $category->id);
        $category->update($data);
        AdminAuditLog::create(['admin_id' => auth()->id(), 'action' => 'category.update', 'details' => $category->id]);
        return redirect()->route('admin.categories')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        AdminAuditLog::create(['admin_id' => auth()->id(), 'action' => 'category.delete', 'details' => $category->id]);
        return back()->with('success', 'Category deleted.');
    }

    private function validateData(Request $request, ?int $id = null): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'slug' => 'nullable|string|max:120|unique:categories,slug,' . $id,
            'parent_id' => 'nullable|exists:categories,id',
            'meta_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

        return $data;
    }
}
