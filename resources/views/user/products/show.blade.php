@extends('layouts.app')

@section('title', $product->name . ' – Aziziscake')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <nav class="text-xs text-gray-400 mb-8 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-[#7a4b2b]">Beranda</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-[#7a4b2b]">Produk</a>
        <span>/</span>
        <span class="text-gray-600">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
        {{-- Images --}}
        <div x-data="{ active: 0 }">
            <div class="rounded-3xl overflow-hidden mb-3 h-[420px]">
                @if($product->images->count() > 0)
                @foreach($product->images as $i => $img)
                <img x-show="active === {{ $i }}" src="{{ $img->url }}" alt="{{ $product->name }}"
                     class="w-full h-full object-cover">
                @endforeach
                @else
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @endif
            </div>
            @if($product->images->count() > 1)
            <div class="flex gap-2">
                @foreach($product->images as $i => $img)
                <button @click="active = {{ $i }}"
                        class="w-16 h-16 rounded-xl overflow-hidden border-2 transition-all"
                        :class="active === {{ $i }} ? 'border-[#7a4b2b]' : 'border-transparent'">
                    <img src="{{ $img->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div>
            <div class="flex items-center gap-2 mb-3">
                @if($product->is_bestseller)
                <span class="text-xs bg-orange-100 text-orange-600 px-3 py-1 rounded-full">🔥 Terlaris</span>
                @endif
                @if($product->is_new)
                <span class="text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full">✨ Baru</span>
                @endif
            </div>

            <h1 class="playfair text-4xl text-[#4b2e1e] mb-3">{{ $product->name }}</h1>

            <div class="flex items-center gap-3 mb-5">
                <div class="flex text-[#e8a33a]">
                    @for($i=1;$i<=5;$i++)
                    <span>{{ $i <= $product->rating ? '★' : '☆' }}</span>
                    @endfor
                </div>
                <span class="text-sm text-gray-500">{{ number_format($product->rating, 1) }} ({{ $product->review_count }} ulasan)</span>
                <span class="text-sm text-gray-300">·</span>
                <span class="text-sm text-gray-500">{{ number_format($product->sold_count) }} terjual</span>
            </div>

            <div class="mb-6">
                @if($product->price_discount || $product->price_promo)
                <div class="text-gray-300 line-through text-sm">Rp {{ number_format($product->price,0,',','.') }}</div>
                @if($product->discount_percent > 0)
                <div class="flex items-center gap-2">
                    <span class="text-3xl font-bold text-[#7a4b2b]">Rp {{ number_format($product->effective_price,0,',','.') }}</span>
                    <span class="bg-red-500 text-white text-sm px-2 py-0.5 rounded-full">-{{ $product->discount_percent }}%</span>
                </div>
                @else
                <span class="text-3xl font-bold text-[#7a4b2b]">Rp {{ number_format($product->effective_price,0,',','.') }}</span>
                @endif
                @else
                <span class="text-3xl font-bold text-[#7a4b2b]">Rp {{ number_format($product->price,0,',','.') }}</span>
                @endif
            </div>

            <p class="text-gray-500 text-sm leading-relaxed mb-6">{{ $product->description }}</p>

            {{-- Brand --}}
            @if($product->brand)
            <div class="flex items-center gap-2 mb-5 text-sm text-gray-500">
                <span>Brand:</span>
                <span class="font-medium text-gray-700">{{ $product->brand->name }}</span>
            </div>
            @endif

            {{-- Stock --}}
            <div class="flex items-center gap-2 mb-6">
                <span class="text-sm text-gray-500">Stok:</span>
                <span class="font-medium text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-500' }}">
                    {{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Habis' }}
                </span>
            </div>

            {{-- Add to Cart --}}
            @if($product->stock > 0)
            @auth
            <form method="POST" action="{{ route('cart.add') }}" class="flex gap-3 items-center">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                    <button type="button" onclick="this.nextElementSibling.value = Math.max(1, parseInt(this.nextElementSibling.value)-1)"
                            class="px-4 py-3 text-gray-500 hover:bg-gray-50 transition-colors">−</button>
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                           class="w-16 text-center border-0 text-sm focus:outline-none py-3">
                    <button type="button" onclick="this.previousElementSibling.value = Math.min({{ $product->stock }}, parseInt(this.previousElementSibling.value)+1)"
                            class="px-4 py-3 text-gray-500 hover:bg-gray-50 transition-colors">+</button>
                </div>
                <button type="submit" class="flex-1 bg-[#7a4b2b] text-white py-3 rounded-xl font-medium hover:bg-[#5a3825] transition-colors text-sm">
                    <i class="fa-solid fa-cart-shopping mr-2"></i> Tambah ke Keranjang
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="block text-center bg-[#7a4b2b] text-white py-3 rounded-xl font-medium hover:bg-[#5a3825] transition-colors text-sm">
                Login untuk Membeli
            </a>
            @endauth
            @else
            <div class="bg-red-50 border border-red-200 text-red-600 px-5 py-3 rounded-xl text-sm text-center">Stok habis</div>
            @endif

            <a href="https://wa.me/6281392335843?text=Halo%20Aziziscake!%20Saya%20tertarik%20dengan%20{{ urlencode($product->name) }}"
               target="_blank"
               class="mt-3 flex items-center justify-center gap-2 border border-gray-200 text-gray-600 py-3 rounded-xl text-sm hover:bg-gray-50 transition-colors">
                <i class="fa-brands fa-whatsapp mr-2"></i> Tanya via WhatsApp
            </a>
        </div>
    </div>

    {{-- Reviews --}}
    @if($product->reviews->count() > 0)
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 mb-8">
        <h2 class="playfair text-2xl text-[#4b2e1e] mb-6">Ulasan Pelanggan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($product->reviews as $review)
            <div class="bg-gray-50 rounded-xl p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-[#f0e6d9] flex items-center justify-center text-xs font-bold text-[#7a4b2b]">
                            {{ substr($review->user->name, 0, 2) }}
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ $review->user->name }}</span>
                    </div>
                    <div class="text-[#e8a33a] text-xs">
                        @for($i=1;$i<=5;$i++) {{ $i <= $review->rating ? '★' : '☆' }} @endfor
                    </div>
                </div>
                <p class="text-gray-500 text-sm">{{ $review->comment }}</p>
                <p class="text-xs text-gray-300 mt-2">{{ $review->created_at->diffForHumans() }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Related Products --}}
    @if($related->count() > 0)
    <div>
        <h2 class="playfair text-2xl text-[#4b2e1e] mb-6">Produk Serupa</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach($related as $p)
            <a href="{{ route('products.show', $p) }}" class="group bg-white rounded-2xl p-4 shadow-sm hover:-translate-y-1 hover:shadow-lg transition-all">
                <div class="overflow-hidden rounded-xl mb-3">
                    <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="w-full h-36 object-cover group-hover:scale-105 transition-transform">
                </div>
                <h3 class="font-medium text-sm text-[#4b2e1e] line-clamp-1">{{ $p->name }}</h3>
                <p class="text-[#7a4b2b] font-bold text-sm mt-1">Rp {{ number_format($p->effective_price,0,',','.') }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
