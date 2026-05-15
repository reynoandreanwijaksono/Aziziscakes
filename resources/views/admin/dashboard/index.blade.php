@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    @foreach([
        ['<i class="fa-solid fa-box"></i>','Total Produk', number_format($stats['total_products']), 'text-blue-600','bg-blue-50', route('admin.products.index')],
        ['<i class="fa-solid fa-bag-shopping"></i>','Total Pesanan', number_format($stats['total_orders']), 'text-purple-600','bg-purple-50', route('admin.orders.index')],
        ['<i class="fa-solid fa-users"></i>','Total User', number_format($stats['total_users']), 'text-green-600','bg-green-50', '#'],
        ['<i class="fa-solid fa-file-lines"></i>','Website Content', 'Edit konten website', 'text-teal-600','bg-teal-50', route('admin.settings.website.index')],
        ['<i class="fa-solid fa-money-bill-wave"></i>','Total Revenue', 'Rp ' . number_format($stats['total_revenue'],0,',','.'), 'text-[#7a4b2b]','bg-[#fef3ec]', route('admin.payments.index')],
    ] as $card)
    <a href="{{ $card[5] }}" class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="text-2xl">{!! $card[0] !!}</div>
            <div class="w-10 h-10 {{ $card[4] }} rounded-xl flex items-center justify-center text-lg">{!! $card[0] !!}</div>
        </div>
        <div class="text-2xl font-bold text-gray-800">{{ $card[2] }}</div>
        <div class="text-sm text-gray-400 mt-1">{{ $card[1] }}</div>
    </a>
    @endforeach
</div>

{{-- Second Row Stats --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-semibold text-gray-700 mb-1"><i class="fa-solid fa-hourglass-half"></i> Pesanan Pending</h3>
        <div class="text-3xl font-bold text-orange-500">{{ $stats['pending_orders'] }}</div>
        <p class="text-xs text-gray-400 mt-1">Menunggu konfirmasi pembayaran</p>
        <a href="{{ route('admin.orders.index') }}?status=pending" class="text-xs text-[#7a4b2b] mt-3 inline-block hover:underline">Lihat semua →</a>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-semibold text-gray-700 mb-1"><i class="fa-solid fa-calendar-days"></i> Revenue Bulan Ini</h3>
        <div class="text-3xl font-bold text-green-600">Rp {{ number_format($stats['monthly_revenue'],0,',','.') }}</div>
        <p class="text-xs text-gray-400 mt-1">{{ now()->format('F Y') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    {{-- Recent Orders --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-700"><i class="fa-solid fa-box"></i> Pesanan Terbaru</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-[#7a4b2b] hover:underline">Lihat semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs text-gray-400 font-medium">Invoice</th>
                        <th class="text-left px-6 py-3 text-xs text-gray-400 font-medium">Customer</th>
                        <th class="text-left px-6 py-3 text-xs text-gray-400 font-medium">Total</th>
                        <th class="text-left px-6 py-3 text-xs text-gray-400 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-xs font-mono text-gray-600">{{ $order->invoice_number }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $order->user->name ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm font-medium text-[#7a4b2b]">Rp {{ number_format($order->total,0,',','.') }}</td>
                        <td class="px-6 py-3">
                            @php $badge = $order->status_badge; @endphp
                            <span class="text-xs px-2.5 py-1 rounded-full
                                @if($badge['color']==='yellow') bg-yellow-100 text-yellow-700
                                @elseif($badge['color']==='blue') bg-blue-100 text-blue-700
                                @elseif($badge['color']==='green') bg-green-100 text-green-700
                                @elseif($badge['color']==='red') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ $badge['label'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-700"><i class="fa-solid fa-fire"></i> Produk Terlaris</h3>
        </div>
        <div class="p-4 space-y-3">
            @forelse($topProducts as $i => $product)
            <div class="flex items-center gap-3">
                <div class="w-6 h-6 rounded-full {{ $i === 0 ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center text-xs font-bold flex-shrink-0">
                    {{ $i + 1 }}
                </div>
                <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100">
                    <img src="{{ $product->image_url }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-gray-700 line-clamp-1">{{ $product->name }}</div>
                    <div class="text-xs text-gray-400">{{ number_format($product->sold_count) }} terjual</div>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">Belum ada data</p>
            @endforelse
        </div>
    </div>
</div>

@endsection