<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Admin – @yield('title', 'Dashboard') | Aziziscake</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
@livewireStyles
<style>
body { font-family: 'Poppins', sans-serif; }
.playfair { font-family: 'Playfair Display', serif; }
</style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false }">

<div class="flex h-screen overflow-hidden">
    {{-- Sidebar Background Overlay --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-black/50 z-40 md:hidden" style="display: none;"></div>

    {{-- Sidebar --}}
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#4b2e1e] text-white flex flex-col flex-shrink-0 transition-transform duration-300 md:relative md:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div class="p-6 border-b border-white/10">
            <div class="playfair text-xl">🎂 Aziziscake</div>
            <div class="text-xs text-white/50 mt-1">Admin Panel</div>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            @php
            $menuItems = [
                ['route' => 'admin.dashboard', 'icon' => '📊', 'label' => 'Dashboard'],
                ['route' => 'admin.products.index', 'icon' => '🧁', 'label' => 'Produk'],
                ['route' => 'admin.brands.index', 'icon' => '🏷️', 'label' => 'Brand'],
                ['route' => 'admin.orders.index', 'icon' => '📦', 'label' => 'Pesanan'],
                ['route' => 'admin.payments.index', 'icon' => '💳', 'label' => 'Pembayaran'],
                ['route' => 'admin.shipments.index', 'icon' => '🚚', 'label' => 'Pengiriman'],
            ];
            @endphp

            @foreach($menuItems as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
                      {{ request()->routeIs($item['route']) ? 'bg-white/20 text-white font-medium' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <span>{{ $item['icon'] }}</span>
                <span>{{ $item['label'] }}</span>
            </a>
            @endforeach
        </nav>

        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-xs font-semibold">
                    {{ substr(auth()->user()->name, 0, 2) }}
                </div>
                <div>
                    <div class="text-xs font-medium">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-white/50">Administrator</div>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('home') }}" class="flex-1 text-center text-xs text-white/60 hover:text-white py-1.5 rounded-lg hover:bg-white/10 transition-colors">🌐 Website</a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button class="w-full text-xs text-red-300 hover:text-red-200 py-1.5 rounded-lg hover:bg-white/10 transition-colors">🚪 Keluar</button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 overflow-y-auto w-full">
        {{-- Top Bar --}}
        <div class="sticky top-0 z-10 bg-white border-b border-gray-200 px-4 md:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div>
                    <h1 class="font-semibold text-gray-800 text-lg md:text-base line-clamp-1">@yield('title', 'Dashboard')</h1>
                    <p class="hidden sm:block text-xs text-gray-500 mt-0.5">@yield('subtitle', 'Selamat datang di panel admin Aziziscake')</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center gap-3 text-sm text-gray-500">
                <span>{{ now()->format('l, d F Y') }}</span>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="m-6 mb-0 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl text-sm flex items-center gap-2">
            ✅ {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="m-6 mb-0 bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-xl text-sm flex items-center gap-2">
            ❌ {{ session('error') }}
        </div>
        @endif

        <div class="p-4 md:p-8">
            @yield('content')
        </div>
    </main>
</div>

@livewireScripts
@stack('scripts')
</body>
</html>
