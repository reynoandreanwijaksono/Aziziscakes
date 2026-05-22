@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->invoice_number)

@section('content')
<div class="main-container" style="background:#f6f1eb; min-height:100vh; padding:40px 60px;">
    <div style="max-width:900px; margin:0 auto;">

        <!-- Back -->
        <a href="{{ route('orders.index') }}" style="display:inline-flex; align-items:center; gap:8px; color:#7a4b2b; text-decoration:none; font-size:14px; margin-bottom:25px;">
            ← Kembali ke Riwayat Pesanan
        </a>

        @if(session('success'))
        <div style="background:#d4edda; border:1px solid #c3e6cb; color:#155724; padding:14px 20px; border-radius:12px; margin-bottom:20px; font-size:14px;">
            <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div style="background:#f8d7da; border:1px solid #f5c6cb; color:#721c24; padding:14px 20px; border-radius:12px; margin-bottom:20px; font-size:14px;">
            <i class="fa-solid fa-circle-xmark mr-2"></i> {{ session('error') }}
        </div>
        @endif

        <div class="grid-container" style="display:grid; grid-template-columns:1fr 1fr; gap:25px; align-items:stretch;">

            <!-- LEFT COLUMN -->
            <div style="height: 100%;">
                <!-- Order Info Card -->
                <div style="background:white; border-radius:20px; padding:25px; margin-bottom:0; box-shadow:0 5px 20px rgba(0,0,0,0.06); height: 100%;">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
                        <div>
                            <h2 style="font-family:'Playfair Display',serif; font-size:22px; color:#4b2e1e; margin-bottom:4px;">{{ $order->invoice_number }}</h2>
                            <div style="font-size:12px; color:#aaa;">Dipesan: {{ $order->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        @php $sb = $order->status_badge; @endphp
                        <span style="background:{{ $sb['color'] . '20' }}; color:{{ $sb['color'] }}; font-size:12px; padding:6px 16px; border-radius:20px; font-weight:600;">
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
                        @if($order->discount_amount > 0)
                        <div style="display:flex; justify-content:space-between; font-size:13px; color:#28a745; margin-bottom:8px;">
                            <span>Diskon</span>
                            <span>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div style="display:flex; justify-content:space-between; font-size:15px; font-weight:700; color:#4b2e1e; margin-top:10px; padding-top:10px; border-top:2px solid #f0e8df;">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->subtotal - $order->discount_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN -->
            <div style="height: 100%;">
                <!-- Shipping Info -->
                <div style="background:white; border-radius:20px; padding:25px; margin-bottom:0; box-shadow:0 5px 20px rgba(0,0,0,0.06); height: 100%;">
                    <div style="font-size:11px; letter-spacing:2px; color:#aaa; margin-bottom:14px; text-transform:uppercase;">Informasi Pengiriman</div>
                    <div style="font-size:14px; color:#4b2e1e; font-weight:500; margin-bottom:6px;">{{ $order->user->name }}</div>
                    <div style="font-size:13px; color:#666; margin-bottom:4px;"><i class="fa-solid fa-phone mr-1"></i> {{ $order->shipping_phone }}</div>
                    <div style="font-size:13px; color:#666;"><i class="fa-solid fa-location-dot mr-1"></i> {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</div>

                    @if($order->payment && $order->payment->method === 'cod')
                    <div style="margin-top:10px; font-size:13px; color:#166534; font-weight:600;"><i class="fa-solid fa-money-bill-wave mr-1"></i> Metode Pembayaran: COD - Bayar di tempat</div>
                    @endif

                    @if($order->notes)
                    <div style="margin-top:14px; padding:12px 16px; background:#fef9f5; border-radius:12px; font-size:13px; color:#666;">
                        <i class="fa-solid fa-note-sticky mr-1"></i> <em>{{ $order->notes }}</em>
                    </div>
                    @endif

                    @if($order->shipment)
                    <div style="margin-top:16px; padding:16px; background:#f0fdf4; border-radius:12px; border:1px solid #bbf7d0;">
                        <div style="font-size:13px; font-weight:600; color:#166534; margin-bottom:8px;"><i class="fa-solid fa-truck mr-1"></i> Info Pengiriman</div>
                        <div style="font-size:13px; color:#166534;">Kurir: <strong>{{ $order->shipment->courier }}</strong></div>
                        @if($order->shipment->tracking_number)
                        <div style="font-size:13px; color:#166534;">Resi: <strong>{{ $order->shipment->tracking_number }}</strong></div>
                        @endif
                        @if($order->shipment->estimated_delivery)
                        <div style="font-size:13px; color:#166534;">Estimasi: <strong>{{ $order->shipment->estimated_delivery }}</strong></div>
                        @endif
                        @php $shipSb = $order->shipment->status_badge; @endphp
                        <span style="background:{{ $shipSb['color'] . '20' }}; color:{{ $shipSb['color'] }}; font-size:11px; padding:4px 12px; border-radius:20px; display:inline-block; margin-top:8px;">
                            {{ $shipSb['label'] }}
                        </span>
                    </div>
                    @endif
                </div>

            </div>
        </div>

        <div style="text-align:center; margin-top:30px; display:flex; flex-direction:column; align-items:center; gap:16px;">
            <!-- Cancel Button -->
            @if(in_array($order->status, ['pending', 'processing']))
            <form method="POST" action="{{ route('orders.cancel', $order) }}" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                @csrf
                <button type="submit"
                    style="background:#fff0f0; color:#dc3545; padding:12px 30px; border:1.5px solid #f5c6cb; border-radius:12px; font-family:'Poppins',sans-serif; font-size:14px; cursor:pointer; font-weight:500; min-width:250px;">
                    <i class="fa-solid fa-xmark mr-1"></i> Batalkan Pesanan
                </button>
            </form>
            @endif

            <!-- Whatsapp Help -->
            <a href="https://wa.me/6281392335843?text=Halo, saya mau tanya pesanan {{ $order->invoice_number }}" target="_blank"
                style="display:inline-flex; align-items:center; justify-content:center; gap:8px; background:#25D366; color:white; padding:12px 30px; border-radius:12px; text-decoration:none; font-size:14px; font-weight:500; min-width:250px;">
                <i class="fa-brands fa-whatsapp mr-1"></i> Hubungi via WhatsApp
            </a>
        </div>
    </div>
</div>

<style>
    @@media (max-width: 768px) {
        .grid-container {
            display: block !important;
        }

        .main-container {
            padding: 20px !important;
        }
    }
</style>
@endsection