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
            <div class="playfair text-xl"><i class="fas fa-cake-candles mr-2"></i>Aziziscake</div>
            <div class="text-xs text-white/50 mt-1">Admin Panel</div>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            @php
            $menuItems = [
                ['route' => 'admin.dashboard', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v4H3V3zm0 7h7v11H3V10zm10 0h7v7h-7v-7z"/></svg>', 'label' => 'Dashboard'],
                ['route' => 'admin.settings.website.index', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-9v18m9-9H3"/></svg>', 'label' => 'Website Content'],
                ['route' => 'admin.products.index', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 16V8a2 2 0 00-1-1.732l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.732l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>', 'label' => 'Produk'],
                ['route' => 'admin.brands.index', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7a3 3 0 104 4l7 7a2 2 0 01-2.828 2.828L8.172 13.828A3 3 0 017 7z"/></svg>', 'label' => 'Brand'],
                ['route' => 'admin.orders.index', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-7-8h8m5 2V7a2 2 0 00-2-2h-3.5l-.71-.71A1 1 0 0011.5 4h-3a1 1 0 00-.707.293L7.085 5H4a2 2 0 00-2 2v11a2 2 0 002 2h16a2 2 0 002-2V10a2 2 0 00-2-2z"/></svg>', 'label' => 'Pesanan'],
            ];
            @endphp

            @foreach($menuItems as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
                      {{ request()->routeIs($item['route']) ? 'bg-white/20 text-white font-medium' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <span class="flex-none">{!! $item['icon'] !!}</span>
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
                <a href="{{ route('home') }}" class="flex-1 text-center text-xs text-white/60 hover:text-white py-1.5 rounded-lg hover:bg-white/10 transition-colors"><i class="fas fa-globe mr-1"></i>Website</a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button class="w-full text-xs text-red-300 hover:text-red-200 py-1.5 rounded-lg hover:bg-white/10 transition-colors"><i class="fas fa-sign-out-alt mr-1"></i>Keluar</button>
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
            <i class="fas fa-check-circle"></i>{{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="m-6 mb-0 bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-xl text-sm flex items-center gap-2">
            <i class="fas fa-times-circle"></i>{{ session('error') }}
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
