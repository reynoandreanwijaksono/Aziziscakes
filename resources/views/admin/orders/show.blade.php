@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('subtitle', $order->invoice_number)

@section('content')

<div class="grid grid-cols-3 gap-5">
    {{-- Left: Order Items --}}
    <div class="col-span-2 space-y-5">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-700 mb-4">Item Pesanan</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4 py-3 border-b border-gray-50 last:border-0">
                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                        <img src="{{ $item->product->image_url ?? asset('images/no-image.png') }}" class="w-full h-full object-cover" alt="">
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-700 text-sm">{{ $item->product_name }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">Rp {{ number_format($item->price,0,',','.') }} × {{ $item->quantity }}</div>
                    </div>
                    <div class="font-semibold text-[#7a4b2b] text-sm">Rp {{ number_format($item->subtotal,0,',','.') }}</div>
                </div>
                @endforeach
            </div>
            <div class="mt-4 space-y-2 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal,0,',','.') }}</span>
                </div>
                @if($order->discount_amount > 0)
                <div class="flex justify-between text-sm text-green-600">
                    <span>Diskon</span>
                    <span>- Rp {{ number_format($order->discount_amount,0,',','.') }}</span>
                </div>
                @endif
                <div class="flex justify-between font-bold text-[#7a4b2b] border-t border-gray-100 pt-2">
                    <span>TOTAL</span>
                    <span>Rp {{ number_format($order->subtotal - $order->discount_amount,0,',','.') }}</span>
                </div>
            </div>
        </div>

        {{-- Shipping --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-700 mb-4">Alamat Pengiriman</h3>
            <div class="text-sm text-gray-600 space-y-1">
                <p class="font-medium text-gray-800">{{ $order->user->name }}</p>
                <p>{{ $order->shipping_phone }}</p>
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p>
            </div>
            @if($order->notes)
            <div class="mt-3 p-3 bg-yellow-50 rounded-xl text-sm text-yellow-800">
                <i class="fa-solid fa-note-sticky mr-2"></i> {{ $order->notes }}
            </div>
            @endif
        </div>

        {{-- Right: Order Status --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-700 mb-4">Update Status Pesanan</h3>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <select name="status" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm">
                            @foreach(['pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','completed'=>'Selesai','cancelled'=>'Dibatalkan'] as $v=>$l)
                            <option value="{{ $v }}" {{ $order->status === $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-[#7a4b2b] text-white py-2.5 rounded-xl text-sm hover:bg-[#5a3825]">Update Status</button>
                </form>
            </div>

            @if($order->payment)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-700 mb-4">Pembayaran</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Metode</span>
                        <span class="font-medium capitalize">{{ str_replace('_', ' ', $order->payment->method) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Status</span>
                        @php $pb = $order->payment->status_badge; @endphp
                        <span class="text-xs px-2 py-0.5 rounded-full
                        @if($pb['color']==='green') bg-green-100 text-green-700
                        @elseif($pb['color']==='yellow') bg-yellow-100 text-yellow-700
                        @else bg-red-100 text-red-700 @endif">{{ $pb['label'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Jumlah</span>
                        <span class="font-semibold text-[#7a4b2b]">Rp {{ number_format($order->payment->amount,0,',','.') }}</span>
                    </div>
                </div>
                @if($order->payment->proof_image)
                <div class="mt-4">
                    <p class="text-xs text-gray-400 mb-2">Bukti Pembayaran:</p>
                    <img src="{{ asset('storage/' . $order->payment->proof_image) }}" class="w-full rounded-xl" alt="Bukti bayar">
                </div>
                @endif
                <form method="POST" action="{{ route('admin.payments.status', $order->payment) }}" class="mt-4">
                    @csrf @method('PUT')
                    <select name="status" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm mb-2">
                        @foreach(['pending'=>'Menunggu','paid'=>'Lunas','failed'=>'Gagal','refunded'=>'Dikembalikan'] as $v=>$l)
                        <option value="{{ $v }}" {{ $order->payment->status === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-xl text-sm hover:bg-green-700">Update Pembayaran</button>
                </form>
            </div>
            @endif

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-700 mb-3">Info Customer</h3>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-[#f0e6d9] flex items-center justify-center font-semibold text-[#7a4b2b] text-sm">
                        {{ substr($order->user->name, 0, 2) }}
                    </div>
                    <div>
                        <div class="font-medium text-sm text-gray-800">{{ $order->user->name }}</div>
                        <div class="text-xs text-gray-400">{{ $order->user->email }}</div>
                    </div>
                </div>
                <p class="text-xs text-gray-400">Total pesanan: {{ $order->user->orders->count() }}</p>
            </div>

            <div class="space-y-3">
                <a href="{{ route('admin.orders.index') }}" class="block text-center text-sm text-gray-500 hover:text-gray-700">← Kembali ke daftar</a>
                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Hapus pesanan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full bg-red-100 text-red-600 py-2.5 rounded-xl text-sm hover:bg-red-200">Hapus Pesanan</button>
                </form>
            </div>
        </div>
    </div>

    @endsection