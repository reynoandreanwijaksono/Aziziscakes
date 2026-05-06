<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Product, Category, Brand};

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['primaryImage', 'category'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(4)->get();

        $bestsellerProducts = Product::with(['primaryImage', 'category'])
            ->where('is_active', true)
            ->where('is_bestseller', true)
            ->orderByDesc('sold_count')
            ->take(8)->get();

        $newProducts = Product::with(['primaryImage', 'category'])
            ->where('is_active', true)
            ->where('is_new', true)
            ->latest()
            ->take(4)->get();

        $categories = Category::where('is_active', true)->withCount('products')->get();

        return view('user.home.index', compact('featuredProducts', 'bestsellerProducts', 'newProducts', 'categories'));
    }
}
