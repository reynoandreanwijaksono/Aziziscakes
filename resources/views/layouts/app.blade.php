<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Aziziscake – Toko Kue Premium Jepara')</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
@livewireStyles
<style>
:root {
    --brown-dark: #4b2e1e;
    --brown-main: #7a4b2b;
    --brown-light: #f6f1eb;
    --brown-50: #fef9f5;
    --brown-100: #fef3ec;
}
body { font-family: 'Poppins', sans-serif; background: var(--brown-light); }
.playfair { font-family: 'Playfair Display', serif; }
</style>
@stack('styles')
</head>
<body>

{{-- Announcement Banner --}}
<div class="bg-[#7a4b2b] text-white text-center py-2.5 text-xs tracking-wider">
    🎉 Gratis ongkir untuk pembelian min. Rp 150.000
    <span class="bg-white/20 px-2.5 py-0.5 rounded-xl mx-2">Gunakan kode: AZIZI10</span>
    setiap hari sampai pukul 19.00
</div>

{{-- Navbar --}}
<nav x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 backdrop-blur-md bg-white/90 border-b border-[#5a3825]/10 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
        <a href="{{ route('home') }}" class="playfair text-xl md:text-2xl text-[#5a3825] font-bold z-50">🎂 AZIZISCAKE</a>

        {{-- Desktop Menu --}}
        <div class="hidden md:flex items-center gap-6 text-sm text-gray-600">
            <a href="{{ route('products.index') }}" class="hover:text-[#7a4b2b] transition-colors">Menu</a>
            <a href="{{ route('home') }}#galeri" class="hover:text-[#7a4b2b] transition-colors">Galeri</a>
            <a href="{{ route('home') }}#tentang" class="hover:text-[#7a4b2b] transition-colors">Tentang</a>
            <a href="{{ route('home') }}#testimoni" class="hover:text-[#7a4b2b] transition-colors">Ulasan</a>
        </div>

        <div class="hidden md:flex items-center gap-3">
            {{-- Cart --}}
            @auth
            <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-[#7a4b2b]">
                🛒
                @php $cartCount = auth()->user()->cart()->count(); @endphp
                @if($cartCount > 0)
                <span class="absolute -top-1 -right-1 bg-[#7a4b2b] text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center font-bold">{{ $cartCount }}</span>
                @endif
            </a>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 text-sm text-gray-700 hover:text-[#7a4b2b]">
                    <div class="w-8 h-8 rounded-full bg-[#f0e6d9] flex items-center justify-center text-[#7a4b2b] font-semibold text-xs">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <span class="hidden lg:block">{{ auth()->user()->name }}</span>
                </button>
                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                    <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#fef3ec]">📦 Pesanan Saya</a>
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#fef3ec]">⚙️ Admin Panel</a>
                    @endif
                    <hr class="my-1 border-gray-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">🚪 Keluar</button>
                    </form>
                </div>
            </div>
            @else
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-[#7a4b2b]">Masuk</a>
            <a href="{{ route('register') }}" class="bg-[#7a4b2b] text-white px-5 py-2 rounded-full text-sm hover:bg-[#5a3825] transition-colors">Daftar</a>
            @endauth
        </div>

        {{-- Mobile Hamburger Button --}}
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-[#4b2e1e] focus:outline-none z-50 relative">
            <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    {{-- Mobile Menu Overlay --}}
    <div x-show="mobileMenuOpen" x-transition x-cloak class="fixed inset-0 bg-white z-40 md:hidden pt-20 px-6 flex flex-col h-screen overflow-y-auto pb-24">
        <div class="flex flex-col gap-4 text-lg text-center mt-8">
            <a href="{{ route('home') }}" class="py-3 border-b border-gray-50 text-gray-800" @click="mobileMenuOpen = false">Beranda</a>
            <a href="{{ route('products.index') }}" class="py-3 border-b border-gray-50 text-gray-800" @click="mobileMenuOpen = false">Menu Produk</a>
            <a href="{{ route('home') }}#galeri" class="py-3 border-b border-gray-50 text-gray-800" @click="mobileMenuOpen = false">Galeri</a>
            <a href="{{ route('home') }}#tentang" class="py-3 border-b border-gray-50 text-gray-800" @click="mobileMenuOpen = false">Tentang Kami</a>
            <a href="{{ route('home') }}#testimoni" class="py-3 border-b border-gray-50 text-gray-800" @click="mobileMenuOpen = false">Ulasan</a>
        </div>
        
        <div class="mt-8 flex flex-col gap-4">
            @auth
            <a href="{{ route('orders.index') }}" class="w-full py-3 bg-[#fef9f5] text-[#7a4b2b] rounded-xl font-medium text-center" @click="mobileMenuOpen = false">📦 Pesanan Saya</a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="w-full py-3 bg-gray-100 text-gray-800 rounded-xl font-medium text-center" @click="mobileMenuOpen = false">⚙️ Admin Panel</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="w-full mt-4">
                @csrf
                <button class="w-full py-3 border border-red-200 text-red-600 rounded-xl font-medium">🚪 Keluar</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="w-full py-3 border border-[#7a4b2b] text-[#7a4b2b] rounded-xl font-medium text-center" @click="mobileMenuOpen = false">Masuk</a>
            <a href="{{ route('register') }}" class="w-full py-3 bg-[#7a4b2b] text-white rounded-xl font-medium text-center" @click="mobileMenuOpen = false">Daftar Akun Baru</a>
            @endauth
        </div>
    </div>
</nav>

{{-- Flash Messages --}}
@if(session('success'))
<div class="fixed top-20 right-5 z-50 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg text-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
    ✅ {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="fixed top-20 right-5 z-50 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg text-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
    ❌ {{ session('error') }}
</div>
@endif

{{-- Main Content --}}
@yield('content')

{{-- Footer --}}
<footer class="bg-[#4b2e1e] text-white pt-16 pb-24 md:pb-8">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10 mb-10">
            <div class="sm:col-span-2 md:col-span-1">
                <h3 class="playfair text-xl mb-4 text-[#f6f1eb]">🎂 Aziziscake</h3>
                <p class="text-white/70 text-sm leading-relaxed">Menghadirkan kelezatan kue dan roti premium dengan resep keluarga dari Jepara, Jawa Tengah.</p>
                <div class="flex gap-3 mt-5">
                    <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#7a4b2b] transition-colors text-base">📸</a>
                    <a href="https://wa.me/6285387717112" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#7a4b2b] transition-colors text-base">💬</a>
                    <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#7a4b2b] transition-colors text-base">🎵</a>
                </div>
            </div>
            <div>
                <h3 class="playfair text-lg mb-4 text-[#f6f1eb]">Menu</h3>
                <div class="flex flex-col gap-2 text-sm text-white/70">
                    <a href="{{ route('products.index') }}?category=roti-artisan" class="hover:text-white transition-colors">Artisan Bread</a>
                    <a href="{{ route('products.index') }}?category=pastry-croissant" class="hover:text-white transition-colors">Sweet Pastry</a>
                    <a href="{{ route('products.index') }}?category=custom-cake" class="hover:text-white transition-colors">Custom Cake</a>
                    <a href="{{ route('products.index') }}?category=cinnamon-roll" class="hover:text-white transition-colors">Cinnamon Roll</a>
                    <a href="{{ route('products.index') }}?category=hampers-gift" class="hover:text-white transition-colors">Hampers</a>
                </div>
            </div>
            <div>
                <h3 class="playfair text-lg mb-4 text-[#f6f1eb]">Informasi</h3>
                <div class="flex flex-col gap-2 text-sm text-white/70">
                    <a href="{{ route('home') }}#tentang" class="hover:text-white transition-colors">Tentang Kami</a>
                    <a href="{{ route('home') }}#faq" class="hover:text-white transition-colors">FAQ</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                </div>
            </div>
            <div>
                <h3 class="playfair text-lg mb-4 text-[#f6f1eb]">Jam Buka</h3>
                <p class="text-white/70 text-sm">Senin – Minggu</p>
                <p class="text-white font-semibold text-sm mt-1">06.00 – 19.00</p>
                <p class="text-[#e8a33a] text-sm mt-3">★ Promo spesial setiap akhir pekan!</p>
                <div class="mt-4 text-sm text-white/70">
                    <p>📍 Bucu, Kec. Kembang, Jepara</p>
                    <p class="mt-1">📞 +62 853-8771-7112</p>
                </div>
            </div>
        </div>
        <div class="border-t border-white/15 pt-6 flex flex-col md:flex-row justify-between items-center gap-3 text-xs text-white/50 text-center md:text-left">
            <span>© {{ date('Y') }} Aziziscake. All rights reserved.</span>
            <span>Dibuat dengan ❤️ di Jepara, Jawa Tengah</span>
        </div>
    </div>
</footer>

{{-- Mobile Bottom Navigation --}}
<div class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 flex justify-around items-center py-2 px-4 z-40 pb-[max(env(safe-area-inset-bottom),0.5rem)] shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
    <a href="{{ route('home') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('home') ? 'text-[#7a4b2b]' : 'text-gray-400 hover:text-[#7a4b2b]' }}">
        <span class="text-xl leading-none mb-1">🏠</span>
        <span class="text-[10px] font-medium">Beranda</span>
    </a>
    <a href="{{ route('products.index') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('products.*') ? 'text-[#7a4b2b]' : 'text-gray-400 hover:text-[#7a4b2b]' }}">
        <span class="text-xl leading-none mb-1">🧁</span>
        <span class="text-[10px] font-medium">Menu</span>
    </a>
    @auth
    <a href="{{ route('cart.index') }}" class="flex flex-col items-center p-2 relative {{ request()->routeIs('cart.*') ? 'text-[#7a4b2b]' : 'text-gray-400 hover:text-[#7a4b2b]' }}">
        <span class="text-xl leading-none mb-1">🛒</span>
        <span class="text-[10px] font-medium">Keranjang</span>
        @php $cartCount = auth()->user()->cart()->count(); @endphp
        @if($cartCount > 0)
        <span class="absolute top-1 right-2 bg-[#7a4b2b] text-white text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold border border-white">{{ $cartCount }}</span>
        @endif
    </a>
    <a href="{{ route('orders.index') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('orders.*') ? 'text-[#7a4b2b]' : 'text-gray-400 hover:text-[#7a4b2b]' }}">
        <span class="text-xl leading-none mb-1">📦</span>
        <span class="text-[10px] font-medium">Pesanan</span>
    </a>
    @else
    <a href="{{ route('login') }}" class="flex flex-col items-center p-2 text-gray-400 hover:text-[#7a4b2b]">
        <span class="text-xl leading-none mb-1">👤</span>
        <span class="text-[10px] font-medium">Masuk</span>
    </a>
    @endauth
</div>

{{-- WhatsApp Float --}}
<a href="https://wa.me/6285387717112?text=Halo%20Aziziscake!%20Saya%20mau%20pesan%20kue" target="_blank"
   class="fixed bottom-20 md:bottom-6 right-4 md:right-6 w-12 h-12 md:w-14 md:h-14 bg-[#25D366] text-white text-xl md:text-2xl rounded-full flex items-center justify-center shadow-xl z-30 animate-pulse hover:scale-110 transition-transform">
    💬
</a>

{{-- Scroll to Top --}}
<button onclick="window.scrollTo({top:0,behavior:'smooth'})"
        class="fixed bottom-36 md:bottom-24 right-4 md:right-7 w-10 h-10 md:w-11 md:h-11 bg-[#5a3825] text-white rounded-full items-center justify-center shadow-lg z-30 hover:bg-[#7a4b2b] transition-colors hidden" id="scrollTop">
    ↑
</button>

<script>
window.addEventListener('scroll', () => {
    document.getElementById('scrollTop').classList.toggle('hidden', window.scrollY < 400);
    document.getElementById('scrollTop').classList.toggle('flex', window.scrollY >= 400);
});
</script>

@livewireScripts
@stack('scripts')
</body>
</html>
