<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Product, Category, Brand, ProductImage, PriceHistory};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'primaryImage'])
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->when($request->status !== null, fn($q) => $q->where('is_active', $request->status));

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'brand_id'         => 'nullable|exists:brands,id',
            'description'      => 'nullable|string',
            'price'            => 'required|integer|min:0',
            'price_discount'   => 'nullable|integer|min:0',
            'price_promo'      => 'nullable|integer|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'stock'            => 'required|integer|min:0',
            'is_active'        => 'boolean',
            'is_featured'      => 'boolean',
            'is_bestseller'    => 'boolean',
            'is_new'           => 'boolean',
            'images'           => 'nullable|array',
            'images.*'         => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image'      => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        $product->load(['images', 'priceHistories.changedBy']);
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'brand_id'         => 'nullable|exists:brands,id',
            'description'      => 'nullable|string',
            'price'            => 'required|integer|min:0',
            'price_discount'   => 'nullable|integer|min:0',
            'price_promo'      => 'nullable|integer|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'stock'            => 'required|integer|min:0',
            'is_active'        => 'boolean',
            'is_featured'      => 'boolean',
            'is_bestseller'    => 'boolean',
            'is_new'           => 'boolean',
            'images'           => 'nullable|array',
            'images.*'         => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Track price change
        if ($product->price !== (int)$validated['price']) {
            PriceHistory::create([
                'product_id' => $product->id,
                'old_price'  => $product->price,
                'new_price'  => $validated['price'],
                'reason'     => $request->price_change_reason ?? 'Admin update',
            ]);
        }

        $product->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image'      => $path,
                    'is_primary' => false,
                    'sort_order' => $product->images()->count() + $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->orderItems()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus produk yang memiliki pesanan!');
        }

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
        }
        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }

    public function destroyImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image);
        $image->delete();
        return back()->with('success', 'Gambar berhasil dihapus!');
    }
}
