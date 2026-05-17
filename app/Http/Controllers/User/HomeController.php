<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Product, Category, Brand, SiteSetting};

class HomeController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::allValues();

        $featuredProducts = Product::with(['primaryImage', 'category'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(4)->get();

        $bestsellerProducts = Product::with(['primaryImage', 'category'])
            ->where('is_active', true)
            ->orderByDesc('sold_count')
            ->take(4)->get();

        $newProducts = Product::with(['primaryImage', 'category'])
            ->where('is_active', true)
            ->where('is_new', true)
            ->latest()
            ->take(4)->get();

        $categories = Category::where('is_active', true)->withCount('products')->get();

        return view('user.home.index', compact('featuredProducts', 'bestsellerProducts', 'newProducts', 'categories', 'settings'));
    }
}
