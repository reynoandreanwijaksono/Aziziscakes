@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->invoice_number)

@section('content')
<div style="background:#f6f1eb; min-height:100vh; padding:40px 60px;">
    <div style="max-width:900px; margin:0 auto;">

        <!-- Back -->
        <a href="{{ route('orders.index') }}" style="display:inline-flex; align-items:center; gap:8px; color:#7a4b2b; text-decoration:none; font-size:14px; margin-bottom:25px;">
            ← Kembali ke Riwayat Pesanan
        </a>

        @if(session('success'))
        <div style="background:#d4edda; border:1px solid #c3e6cb; color:#155724; padding:14px 20px; border-radius:12px; margin-bottom:20px; font-size:14px;">
            ✅ {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div style="background:#f8d7da; border:1px solid #f5c6cb; color:#721c24; padding:14px 20px; border-radius:12px; margin-bottom:20px; font-size:14px;">
            ❌ {{ session('error') }}
        </div>
        @endif

        <div style="display:grid; grid-template-columns:1fr 340px; gap:25px; align-items:start;">

            <!-- LEFT COLUMN -->
            <div>
                <!-- Order Info Card -->
                <div style="background:white; border-radius:20px; padding:25px; margin-bottom:20px; box-shadow:0 5px 20px rgba(0,0,0,0.06);">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
                        <div>
                            <h2 style="font-family:'Playfair Display',serif; font-size:22px; color:#4b2e1e; margin-bottom:4px;">{{ $order->invoice_number }}</h2>
                            <div style="font-size:12px; color:#aaa;">Dipesan: {{ $order->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        @php $sb = $order->getStatusBadgeAttribute(); @endphp
                        <span style="background:{{ $sb['color'] }}20; color:{{ $sb['color'] }}; font-size:12px; padding:6px 16px; border-radius:20px; font-weight:600;">
                            {{ $sb['label'] }}
                        </span>
                    </div>

                    <!-- Items -->
                    <div style="border-top:1px solid #f0e8df; padding-top:16px;">
                        <div style="font-size:11px; letter-spacing:2px; color:#aaa; margin-bottom:14px; text-transform:uppercase;">Produk Dipesan</div>
                        @foreach($order->items as $item)
                        <div style="display:flex; align-items:center; gap:15px; margin-bottom:15px;">
                            <img src="{{ $item->product?->image_url ?? asset('images/no-image.png') }}" alt="{{ $item->product_name }}"
                                 style="width:65px; height:65px; object-fit:cover; border-radius:12px;">
                            <div style="flex:1;">
                                <div style="font-weight:500; color:#4b2e1e;">{{ $item->product_name }}</div>
                                <div style="font-size:12px; color:#888; margin-top:3px;">
                                    Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}
                                </div>
                            </div>
                            <div style="font-weight:600; color:#7a4b2b;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Totals -->
                    <div style="border-top:1px solid #f0e8df; padding-top:16px; margin-top:4px;">
                        <div style="display:flex; justify-content:space-between; font-size:13px; color:#666; margin-bottom:8px;">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:13px; color:#666; margin-bottom:8px;">
                            <span>Ongkos Kirim</span>
                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                        <div style="display:flex; justify-content:space-between; font-size:13px; color:#28a745; margin-bottom:8px;">
                            <span>Diskon</span>
                            <span>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div style="display:flex; justify-content:space-between; font-size:15px; font-weight:700; color:#4b2e1e; margin-top:10px; padding-top:10px; border-top:2px solid #f0e8df;">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Info -->
                <div style="background:white; border-radius:20px; padding:25px; margin-bottom:20px; box-shadow:0 5px 20px rgba(0,0,0,0.06);">
                    <div style="font-size:11px; letter-spacing:2px; color:#aaa; margin-bottom:14px; text-transform:uppercase;">Informasi Pengiriman</div>
                    <div style="font-size:14px; color:#4b2e1e; font-weight:500; margin-bottom:6px;">{{ $order->user->name }}</div>
                    <div style="font-size:13px; color:#666; margin-bottom:4px;">📞 {{ $order->shipping_phone }}</div>
                    <div style="font-size:13px; color:#666;">📍 {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</div>

                    @if($order->notes)
                    <div style="margin-top:14px; padding:12px 16px; background:#fef9f5; border-radius:12px; font-size:13px; color:#666;">
                        📝 <em>{{ $order->notes }}</em>
                    </div>
                    @endif

                    @if($order->shipment)
                    <div style="margin-top:16px; padding:16px; background:#f0fdf4; border-radius:12px; border:1px solid #bbf7d0;">
                        <div style="font-size:13px; font-weight:600; color:#166534; margin-bottom:8px;">🚚 Info Pengiriman</div>
                        <div style="font-size:13px; color:#166534;">Kurir: <strong>{{ $order->shipment->courier }}</strong></div>
                        @if($order->shipment->tracking_number)
                        <div style="font-size:13px; color:#166534;">Resi: <strong>{{ $order->shipment->tracking_number }}</strong></div>
                        @endif
                        @if($order->shipment->estimated_delivery)
                        <div style="font-size:13px; color:#166534;">Estimasi: <strong>{{ $order->shipment->estimated_delivery }}</strong></div>
                        @endif
                        @php $shipSb = $order->shipment->getStatusBadgeAttribute(); @endphp
                        <span style="background:{{ $shipSb['color'] }}20; color:{{ $shipSb['color'] }}; font-size:11px; padding:4px 12px; border-radius:20px; display:inline-block; margin-top:8px;">
                            {{ $shipSb['label'] }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div>
                <!-- Payment Status -->
                <div style="background:white; border-radius:20px; padding:25px; margin-bottom:20px; box-shadow:0 5px 20px rgba(0,0,0,0.06);">
                    <div style="font-size:11px; letter-spacing:2px; color:#aaa; margin-bottom:14px; text-transform:uppercase;">Pembayaran</div>

                    @if($order->payment)
                        @php $pb = $order->payment->getStatusBadgeAttribute(); @endphp
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                            <span style="font-size:13px; color:#666;">Status</span>
                            <span style="background:{{ $pb['color'] }}20; color:{{ $pb['color'] }}; font-size:12px; padding:4px 12px; border-radius:20px; font-weight:500;">
                                {{ $pb['label'] }}
                            </span>
                        </div>
                        <div style="font-size:13px; color:#666; margin-bottom:8px;">
                            Metode: <strong style="color:#4b2e1e;">{{ strtoupper($order->payment->payment_method) }}</strong>
                        </div>
                        <div style="font-size:15px; font-weight:700; color:#4b2e1e; margin-bottom:12px;">
                            Rp {{ number_format($order->payment->amount, 0, ',', '.') }}
                        </div>

                        @if($order->payment->payment_proof)
                        <div style="margin-top:10px;">
                            <div style="font-size:12px; color:#aaa; margin-bottom:6px;">Bukti Pembayaran:</div>
                            <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" alt="Bukti Bayar"
                                 style="width:100%; border-radius:12px; border:1px solid #f0e8df;">
                        </div>
                        @endif

                        {{-- Upload proof if pending --}}
                        @if($order->payment->status === 'pending' && !$order->payment->payment_proof)
                        <div style="margin-top:16px; padding-top:16px; border-top:1px solid #f0e8df;">
                            <div style="font-size:13px; color:#7a4b2b; font-weight:500; margin-bottom:10px;">📤 Upload Bukti Pembayaran</div>

                            @if($order->payment->payment_method === 'transfer')
                            <div style="background:#fef9f5; padding:12px; border-radius:10px; font-size:12px; color:#666; margin-bottom:12px;">
                                <strong style="color:#4b2e1e;">Rekening Tujuan:</strong><br>
                                BCA: <strong>1234567890</strong> a/n Aziziscake<br>
                                Mandiri: <strong>0987654321</strong> a/n Aziziscake
                            </div>
                            @endif

                            <form method="POST" action="{{ route('orders.payment-proof', $order) }}" enctype="multipart/form-data">
                                @csrf
                                <div style="margin-bottom:12px;">
                                    <input type="file" name="payment_proof" accept="image/*" required
                                           style="width:100%; padding:10px; border:1.5px dashed #d0c4b8; border-radius:12px; font-size:13px; background:#faf8f5; cursor:pointer;">
                                    @error('payment_proof')
                                    <span style="color:#dc3545; font-size:12px;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit"
                                        style="width:100%; background:#7a4b2b; color:white; padding:12px; border:none; border-radius:12px; font-family:'Poppins',sans-serif; font-size:14px; cursor:pointer; font-weight:500;">
                                    Upload Bukti ✓
                                </button>
                            </form>
                        </div>
                        @endif

                    @else
                    <div style="text-align:center; color:#aaa; font-size:13px; padding:20px 0;">Belum ada data pembayaran</div>
                    @endif
                </div>

                <!-- Cancel Button -->
                @if(in_array($order->status, ['pending', 'processing']))
                <div style="background:white; border-radius:20px; padding:20px; box-shadow:0 5px 20px rgba(0,0,0,0.06);">
                    <form method="POST" action="{{ route('orders.cancel', $order) }}" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        @csrf
                        <button type="submit"
                                style="width:100%; background:#fff0f0; color:#dc3545; padding:12px; border:1.5px solid #f5c6cb; border-radius:12px; font-family:'Poppins',sans-serif; font-size:14px; cursor:pointer; font-weight:500;">
                            ✕ Batalkan Pesanan
                        </button>
                    </form>
                </div>
                @endif

                <!-- Whatsapp Help -->
                <div style="text-align:center; margin-top:16px;">
                    <a href="https://wa.me/6281392335843?text=Halo, saya mau tanya pesanan {{ $order->invoice_number }}" target="_blank"
                       style="display:inline-flex; align-items:center; gap:8px; background:#25D366; color:white; padding:12px 20px; border-radius:12px; text-decoration:none; font-size:13px; font-weight:500;">
                        💬 Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media(max-width:768px){
    div[style*="grid-template-columns:1fr 340px"] { display:block !important; }
    div[style*="padding:40px 60px"] { padding:20px !important; }
}
</style>
@endsection