@extends('layouts.app')

@section('title', 'Produk – Aziziscake')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 md:py-12" x-data="{ filterOpen: false }">
    <div class="text-center mb-8 md:mb-10">
        <div class="text-xs tracking-widest text-[#7a4b2b] uppercase mb-2">— Pilihan Terbaik —</div>
        <h1 class="playfair text-3xl md:text-4xl text-[#4b2e1e]">Produk Kami</h1>
        <p class="text-gray-400 text-sm mt-2">{{ $products->total() }} produk tersedia</p>
    </div>

    {{-- Mobile Filter Toggle --}}
    <div class="lg:hidden flex justify-end mb-4">
        <button @click="filterOpen = true" class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2 rounded-xl text-sm font-medium text-[#4b2e1e] shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            Filter & Urutkan
        </button>
    </div>

    <div class="flex gap-8 relative">
        {{-- Sidebar Filter --}}
        <aside class="w-64 flex-shrink-0 fixed inset-y-0 left-0 z-50 lg:z-0 bg-white lg:bg-transparent shadow-2xl transform transition-transform duration-300 lg:relative lg:translate-x-0 lg:block lg:shadow-none overflow-y-auto lg:overflow-visible h-full lg:h-auto p-6 lg:p-0"
               :class="filterOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            <div class="flex justify-between items-center mb-6 lg:hidden">
                <h2 class="font-bold text-[#4b2e1e] text-lg">Filter</h2>
                <button @click="filterOpen = false" class="p-2 text-gray-400 hover:text-red-500 rounded-full bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form method="GET" class="space-y-5">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-4 text-sm flex items-center gap-2"><i class="fa-solid fa-magnifying-glass text-[#7a4b2b]"></i> Pencarian</h3>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl bg-white text-sm focus:outline-none focus:border-[#7a4b2b]">
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-4 text-sm flex items-center gap-2"><i class="fa-solid fa-money-bill-wave text-[#7a4b2b]"></i> Harga</h3>
                    <div class="space-y-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Harga min"
                               class="w-full px-3 py-2 border border-gray-200 rounded-xl bg-white text-sm focus:outline-none focus:border-[#7a4b2b]">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Harga max"
                               class="w-full px-3 py-2 border border-gray-200 rounded-xl bg-white text-sm focus:outline-none focus:border-[#7a4b2b]">
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-4 text-sm flex items-center gap-2"><i class="fa-solid fa-arrow-down-short-wide text-[#7a4b2b]"></i> Urutkan</h3>
                    <select name="sort" class="w-full px-3 py-2 border border-gray-200 rounded-xl bg-white text-sm focus:outline-none focus:border-[#7a4b2b]">
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

        <div x-show="filterOpen" @click="filterOpen = false" x-transition.opacity class="fixed inset-0 bg-black/50 z-40 lg:hidden" style="display: none;"></div>

        {{-- Product Grid --}}
        <div class="flex-1">
            @if($products->isEmpty())
            <div class="text-center py-20 text-gray-400">
                <div class="text-5xl mb-4">🧁</div>
                <p class="text-lg">Produk tidak ditemukan</p>
                <a href="{{ route('products.index') }}" class="text-[#7a4b2b] text-sm mt-2 inline-block hover:underline">Lihat semua produk</a>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-5">
                @foreach($products as $product)
                <a href="{{ route('products.show', $product) }}" class="group bg-white rounded-2xl p-4 shadow-sm hover:-translate-y-1 hover:shadow-lg transition-all duration-300 border border-gray-50">
                    <div class="relative overflow-hidden rounded-xl mb-3">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                             class="w-full h-48 sm:h-44 object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        @if($product->discount_percent > 0)
                        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">-{{ $product->discount_percent }}%</span>
                        @endif
                        @if($product->is_bestseller)
                        <span class="absolute top-2 right-2 bg-orange-100 text-orange-600 text-xs px-2 py-0.5 rounded-full">🔥</span>
                        @elseif($product->is_new)
                        <span class="absolute top-2 right-2 bg-blue-100 text-blue-600 text-xs px-2 py-0.5 rounded-full">✨</span>
                        @endif
                    </div>
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
