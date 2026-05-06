@extends('layouts.app')

@section('title', 'Produk – Aziziscake')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="text-center mb-10">
        <div class="text-xs tracking-widest text-[#7a4b2b] uppercase mb-2">— Pilihan Terbaik —</div>
        <h1 class="playfair text-4xl text-[#4b2e1e]">Produk Kami</h1>
        <p class="text-gray-400 text-sm mt-2">{{ $products->total() }} produk tersedia</p>
    </div>

    <div class="flex gap-8">
        {{-- Sidebar Filter --}}
        <aside class="w-64 flex-shrink-0 hidden lg:block">
            <form method="GET" class="space-y-5">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-4 text-sm">🔍 Pencarian</h3>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-4 text-sm">📂 Kategori</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} class="accent-[#7a4b2b]">
                            <span class="text-sm text-gray-600">Semua</span>
                        </label>
                        @foreach($categories as $cat)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'checked' : '' }} class="accent-[#7a4b2b]">
                            <span class="text-sm text-gray-600">{{ $cat->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-4 text-sm">💰 Harga</h3>
                    <div class="space-y-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Harga min"
                               class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Harga max"
                               class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-4 text-sm">🔃 Urutkan</h3>
                    <select name="sort" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                        <option value="">Terbaru</option>
                        <option value="terlaris" {{ request('sort')==='terlaris' ? 'selected' : '' }}>Terlaris</option>
                        <option value="price_asc" {{ request('sort')==='price_asc' ? 'selected' : '' }}>Harga: Rendah–Tinggi</option>
                        <option value="price_desc" {{ request('sort')==='price_desc' ? 'selected' : '' }}>Harga: Tinggi–Rendah</option>
                        <option value="rating" {{ request('sort')==='rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-[#7a4b2b] text-white py-3 rounded-xl text-sm font-medium hover:bg-[#5a3825]">Terapkan Filter</button>
                <a href="{{ route('products.index') }}" class="block text-center text-sm text-gray-400 hover:text-gray-600">Reset Filter</a>
            </form>
        </aside>

        {{-- Product Grid --}}
        <div class="flex-1">
            @if($products->isEmpty())
            <div class="text-center py-20 text-gray-400">
                <div class="text-5xl mb-4">🧁</div>
                <p class="text-lg">Produk tidak ditemukan</p>
                <a href="{{ route('products.index') }}" class="text-[#7a4b2b] text-sm mt-2 inline-block hover:underline">Lihat semua produk</a>
            </div>
            @else
            <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                @foreach($products as $product)
                <a href="{{ route('products.show', $product) }}" class="group bg-white rounded-2xl p-4 shadow-sm hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                    <div class="relative overflow-hidden rounded-xl mb-3">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                             class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                        @if($product->discount_percent > 0)
                        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">-{{ $product->discount_percent }}%</span>
                        @endif
                        @if($product->is_bestseller)
                        <span class="absolute top-2 right-2 bg-orange-100 text-orange-600 text-xs px-2 py-0.5 rounded-full">🔥</span>
                        @elseif($product->is_new)
                        <span class="absolute top-2 right-2 bg-blue-100 text-blue-600 text-xs px-2 py-0.5 rounded-full">✨</span>
                        @endif
                    </div>
                    <div class="text-xs text-[#7a4b2b] mb-1">{{ $product->category->name ?? '-' }}</div>
                    <h3 class="font-semibold text-[#4b2e1e] text-sm mb-1 line-clamp-1">{{ $product->name }}</h3>
                    <p class="text-gray-400 text-xs mb-3 line-clamp-2">{{ $product->description }}</p>
                    <div class="flex items-center justify-between">
                        <div>
                            @if($product->price_discount)
                            <div class="text-gray-300 text-xs line-through">Rp {{ number_format($product->price,0,',','.') }}</div>
                            @endif
                            <div class="text-[#7a4b2b] font-bold text-sm">Rp {{ number_format($product->effective_price,0,',','.') }}</div>
                        </div>
                        <div class="w-8 h-8 bg-[#7a4b2b] text-white rounded-full flex items-center justify-center text-sm group-hover:bg-[#5a3825] transition-colors">+</div>
                    </div>
                    <div class="flex items-center gap-1 mt-2">
                        <span class="text-[#e8a33a] text-xs">★</span>
                        <span class="text-xs text-gray-500">{{ number_format($product->rating, 1) }}</span>
                        <span class="text-xs text-gray-300">({{ $product->review_count }})</span>
                        <span class="text-xs text-gray-300 mx-1">·</span>
                        <span class="text-xs text-gray-400">{{ number_format($product->sold_count) }} terjual</span>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $products->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
