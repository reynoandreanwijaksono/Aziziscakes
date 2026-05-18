{{-- cart/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Keranjang Belanja – Aziziscake')
@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <h1 class="playfair text-3xl text-[#4b2e1e] mb-8"><i class="fa-solid fa-cart-shopping mr-2 text-[#7a4b2b]"></i> Keranjang Belanja</h1>
    @if($cartItems->isEmpty())
    <div class="text-center py-20 bg-white rounded-2xl shadow-sm">
        <div class="text-6xl mb-4 text-gray-300"><i class="fa-solid fa-cart-shopping"></i></div>
        <p class="text-gray-400 text-lg mb-4">Keranjang belanja kosong</p>
        <a href="{{ route('products.index') }}" class="bg-[#7a4b2b] text-white px-6 py-3 rounded-full text-sm hover:bg-[#5a3825]">Belanja Sekarang</a>
    </div>
    @else
    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-3">
            @foreach($cartItems as $item)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0">
                    <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover" alt="">
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-[#4b2e1e] text-sm">{{ $item->product->name }}</h3>
                    <p class="text-[#7a4b2b] text-sm font-bold mt-1">Rp {{ number_format($item->product->effective_price,0,',','.') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                        @csrf @method('PUT')
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                               onchange="this.form.submit()"
                               class="w-12 text-center text-sm border-0 py-2 focus:outline-none">
                    </form>
                    <form method="POST" action="{{ route('cart.destroy', $item) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 text-lg p-1 transition-colors"><i class="fa-solid fa-trash-can"></i></button>
                    </form>
                </div>
                <div class="text-right">
                    <p class="font-bold text-[#7a4b2b] text-sm">Rp {{ number_format($item->subtotal,0,',','.') }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 h-fit">
            <h3 class="font-semibold text-gray-700 mb-5">Ringkasan</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between text-gray-500">
                    <span>Subtotal ({{ $cartItems->count() }} item)</span>
                    <span>Rp {{ number_format($total,0,',','.') }}</span>
                </div>
                <div class="flex justify-between text-gray-500">
                    <span>Ongkos kirim</span>
                    <span class="text-green-600">Dihitung saat checkout</span>
                </div>
            </div>
            <div class="border-t border-gray-100 mt-4 pt-4 flex justify-between font-bold text-[#7a4b2b]">
                <span>Total</span>
                <span>Rp {{ number_format($total,0,',','.') }}</span>
            </div>
            <a href="{{ route('checkout.index') }}" class="block mt-5 bg-[#7a4b2b] text-white py-3 rounded-xl text-center font-medium hover:bg-[#5a3825] transition-colors text-sm">
                Lanjut Checkout →
            </a>
            <a href="{{ route('products.index') }}" class="block mt-2 text-center text-sm text-gray-400 hover:text-gray-600">← Lanjut Belanja</a>
        </div>
    </div>
    @endif
</div>
@endsection
