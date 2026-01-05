<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $query = Category::query()->orderBy('name');

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                   ->orWhere('slug', 'like', "%{$q}%")
                   ->orWhere('icon', 'like', "%{$q}%");
            });
        }

        $categories = $query->paginate(10)->withQueryString();

        return view('admin.categories.index', compact('categories', 'q'));
    }

    public function create()
    {
        return view('admin.categories.form', [
            'category' => new Category(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'icon' => ['nullable','string','max:50'], // emoji / short string
            'slug' => ['nullable','string','max:255'],
        ]);

        $slug = $this->makeSlug($data['slug'] ?? null, $data['name']);

        Category::create([
            'name' => $data['name'],
            'slug' => $slug,
            'icon' => $data['icon'] ?? null,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dibuat.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', [
            'category' => $category,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'icon' => ['nullable','string','max:50'],
            'slug' => ['nullable','string','max:255'],
        ]);

        $slug = $this->makeSlug($data['slug'] ?? null, $data['name'], $category->id);

        $category->update([
            'name' => $data['name'],
            'slug' => $slug,
            'icon' => $data['icon'] ?? null,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy(Category $category)
    {
        // opsi aman: blok delete kalau kategori dipakai campaign
        if (method_exists($category, 'campaigns') && $category->campaigns()->exists()) {
            return back()->withErrors(['delete' => 'Kategori ini sedang dipakai campaign, tidak bisa dihapus.']);
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    private function makeSlug(?string $manualSlug, string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($manualSlug ?: $name);
        $slug = $base ?: Str::random(8);

        $i = 2;
        while (
            Category::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
