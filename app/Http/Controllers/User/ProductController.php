<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Product, Category, Brand};
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['primaryImage', 'category', 'brand'])
            ->where('is_active', true)
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->category, fn($q) => $q->whereHas('category', fn($c) => $c->where('slug', $request->category)))
            ->when($request->brand, fn($q) => $q->whereHas('brand', fn($b) => $b->where('slug', $request->brand)))
            ->when($request->min_price, fn($q) => $q->where('price', '>=', $request->min_price))
            ->when($request->max_price, fn($q) => $q->where('price', '<=', $request->max_price))
            ->when($request->sort === 'price_asc', fn($q) => $q->orderBy('price'))
            ->when($request->sort === 'price_desc', fn($q) => $q->orderByDesc('price'))
            ->when($request->sort === 'rating', fn($q) => $q->orderByDesc('rating'))
            ->when($request->sort === 'terlaris', fn($q) => $q->orderByDesc('sold_count'))
            ->when(!$request->sort, fn($q) => $q->latest());

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();

        return view('user.products.index', compact('products', 'categories', 'brands'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);
        $product->load(['images', 'category', 'brand', 'reviews.user']);

        $related = Product::with(['primaryImage'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)->get();

        return view('user.products.show', compact('product', 'related'));
    }
}
