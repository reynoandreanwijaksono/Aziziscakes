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
                                <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">KOTA *</label>
                                <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" required
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]" placeholder="Jepara">
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">PROVINSI *</label>
                                <input type="text" name="shipping_province" value="{{ old('shipping_province') }}" required
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]" placeholder="Jawa Tengah">
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">KODE POS *</label>
                                <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" required
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]" placeholder="59451">
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">NO. TELEPON *</label>
                                <input type="text" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" required
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Courier --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-5">🚚 Pilih Kurir</h3>
                    <div class="grid grid-cols-2 gap-3" x-data="{ courier: 'JNE' }">
                        @foreach([['JNE','Rp 15.000','2-3 hari'],['JNT','Rp 12.000','2-4 hari'],['SiCepat','Rp 13.000','1-2 hari'],['Grab','Rp 20.000','Same day'],['Gojek','Rp 18.000','Same day']] as $c)
                        <label class="flex items-center gap-3 p-3 border-2 rounded-xl cursor-pointer transition-all"
                               :class="courier === '{{ $c[0] }}' ? 'border-[#7a4b2b] bg-[#fef9f5]' : 'border-gray-200'">
                            <input type="radio" name="courier" value="{{ $c[0] }}" x-model="courier" class="accent-[#7a4b2b]" required>
                            <div>
                                <div class="font-medium text-sm text-gray-700">{{ $c[0] }}</div>
                                <div class="text-xs text-gray-400">{{ $c[1] }} · Est. {{ $c[2] }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Payment --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-5">💳 Metode Pembayaran</h3>
                    <div class="space-y-3" x-data="{ method: 'transfer_bank' }">
                        @foreach([['transfer_bank','Transfer Bank','Mandiri, BCA, BRI, BSI'],['ewallet','E-Wallet','GoPay, OVO, DANA, ShopeePay'],['cod','COD (Bayar di Tempat)','Bayar saat barang diterima']] as $m)
                        <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all"
                               :class="method === '{{ $m[0] }}' ? 'border-[#7a4b2b] bg-[#fef9f5]' : 'border-gray-200'">
                            <input type="radio" name="payment_method" value="{{ $m[0] }}" x-model="method" class="accent-[#7a4b2b]" required>
                            <div>
                                <div class="font-medium text-sm text-gray-700">{{ $m[1] }}</div>
                                <div class="text-xs text-gray-400">{{ $m[2] }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

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
