@extends('layouts.app')
@section('title', 'Checkout – Aziziscake')
@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <h1 class="playfair text-3xl text-[#4b2e1e] mb-8">📦 Checkout</h1>
    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-2 space-y-5">
                {{-- Shipping Address --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-5">🏠 Alamat Pengiriman</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">ALAMAT LENGKAP *</label>
                            <textarea name="shipping_address" required rows="2" value="{{ old('shipping_address', auth()->user()->address) }}"
                                      class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b] resize-none">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">DESA *</label>
                                <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" required
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]" placeholder="Desa Bucu">
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">KECAMATAN *</label>
                                <input type="text" name="shipping_province" value="{{ old('shipping_province') }}" required
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]" placeholder="Kec. Kembang">
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">RT/RW *</label>
                                <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" required
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]" placeholder="RT 01 / RW 02">
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">NO. TELEPON *</label>
                                <input type="text" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" required
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Hidden Default Courier --}}
                <input type="hidden" name="courier" value="manual">

                {{-- Hidden Default Payment Method --}}
                <input type="hidden" name="payment_method" value="whatsapp_manual">

                {{-- Notes --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-3">📝 Catatan (opsional)</h3>
                    <textarea name="notes" rows="3" placeholder="Contoh: titip di depan pintu, tanpa kacang..."
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b] resize-none"></textarea>
                </div>
            </div>

            {{-- Order Summary --}}
            <div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 sticky top-24">
                    <h3 class="font-semibold text-gray-700 mb-5">Ringkasan Pesanan</h3>
                    <div class="space-y-3 mb-5">
                        @foreach($cartItems as $item)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover" alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-700 line-clamp-1">{{ $item->product->name }}</p>
                                <p class="text-xs text-gray-400">× {{ $item->quantity }}</p>
                            </div>
                            <p class="text-xs font-semibold text-[#7a4b2b]">Rp {{ number_format($item->subtotal,0,',','.') }}</p>
                        </div>
                        @endforeach
                    </div>
                    <div class="space-y-2 text-sm border-t border-gray-100 pt-4">
                        <div class="flex justify-between text-gray-500">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal,0,',','.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>Ongkos kirim</span>
                            <span>Sesuai kurir</span>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 mt-3 pt-3 flex justify-between font-bold text-[#7a4b2b]">
                        <span>Est. Total</span>
                        <span>Rp {{ number_format($subtotal,0,',','.') }}+</span>
                    </div>
                    <button type="submit" class="w-full mt-5 bg-[#7a4b2b] text-white py-3.5 rounded-xl font-semibold hover:bg-[#5a3825] transition-colors">
                        Buat Pesanan 🚀
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
