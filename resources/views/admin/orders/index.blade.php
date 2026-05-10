@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')
@section('subtitle', 'Kelola semua pesanan masuk')

@section('content')

<div class="flex gap-3 mb-6 flex-wrap">
    <form method="GET" class="flex gap-3 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Invoice / Nama customer..."
               class="px-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b] w-72">
        <select name="status" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
            <option value="">Semua Status</option>
            @foreach(['pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','completed'=>'Selesai','cancelled'=>'Dibatalkan'] as $val=>$label)
            <option value="{{ $val }}" {{ request('status')===$val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-xl text-sm">Filter</button>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-4 text-xs text-gray-400 font-medium">Invoice</th>
                <th class="text-left px-6 py-4 text-xs text-gray-400 font-medium">Customer</th>
                <th class="text-left px-6 py-4 text-xs text-gray-400 font-medium">Items</th>
                <th class="text-left px-6 py-4 text-xs text-gray-400 font-medium">Total</th>
                <th class="text-left px-6 py-4 text-xs text-gray-400 font-medium">Pembayaran</th>
                <th class="text-left px-6 py-4 text-xs text-gray-400 font-medium">Status</th>
                <th class="text-left px-6 py-4 text-xs text-gray-400 font-medium">Tanggal</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 text-xs font-mono text-gray-600">{{ $order->invoice_number }}</td>
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-700">{{ $order->user->name ?? '-' }}</div>
                    <div class="text-xs text-gray-400">{{ $order->user->email ?? '-' }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $order->items->count() }} item</td>
                <td class="px-6 py-4 text-sm font-semibold text-[#7a4b2b]">Rp {{ number_format($order->total,0,',','.') }}</td>
                <td class="px-6 py-4">
                    @if($order->payment)
                    @php $pb = $order->payment->status_badge; @endphp
                    <span class="text-xs px-2 py-0.5 rounded-full
                        @if($pb['color']==='green') bg-green-100 text-green-700
                        @elseif($pb['color']==='yellow') bg-yellow-100 text-yellow-700
                        @else bg-red-100 text-red-700 @endif">
                        {{ $pb['label'] }}
                    </span>
                    @else
                    <span class="text-xs text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @php $badge = $order->status_badge; @endphp
                    <span class="text-xs px-2.5 py-1 rounded-full
                        @if($badge['color']==='yellow') bg-yellow-100 text-yellow-700
                        @elseif($badge['color']==='blue') bg-blue-100 text-blue-700
                        @elseif($badge['color']==='indigo') bg-indigo-100 text-indigo-700
                        @elseif($badge['color']==='green') bg-green-100 text-green-700
                        @else bg-red-100 text-red-700 @endif">
                        {{ $badge['label'] }}
                    </span>
                </td>
                <td class="px-6 py-4 text-xs text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-2 items-center">
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="text-xs bg-[#fef3ec] text-[#7a4b2b] px-3 py-1.5 rounded-lg hover:bg-[#7a4b2b] hover:text-white transition-colors">
                            Detail
                        </a>
                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Hapus pesanan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs bg-red-100 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-200 transition-colors">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="px-6 py-12 text-center text-gray-400 text-sm">Belum ada pesanan</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($orders->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">{{ $orders->links() }}</div>
    @endif
</div>

@endsection
