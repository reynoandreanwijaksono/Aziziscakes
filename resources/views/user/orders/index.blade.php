@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div style="background:#f6f1eb; min-height:100vh; padding:40px 60px;">
    <div style="max-width:900px; margin:0 auto;">

        <!-- Header -->
        <div style="margin-bottom:30px;">
            <div style="font-size:11px; letter-spacing:3px; color:#7a4b2b; text-transform:uppercase; margin-bottom:6px;">— Akun Saya —</div>
            <h1 style="font-family:'Playfair Display',serif; font-size:32px; color:#4b2e1e;">Riwayat Pesanan</h1>
            <p style="color:#888; font-size:14px; margin-top:6px;">Pantau semua pesanan Anda di sini</p>
        </div>

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

        @forelse($orders as $order)
        <div style="background:white; border-radius:20px; padding:25px; margin-bottom:20px; box-shadow:0 5px 20px rgba(0,0,0,0.06); border:1px solid #f0e8df;">
            <!-- Order Header -->
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
                <div>
                    <div style="font-size:11px; color:#aaa; letter-spacing:1px; margin-bottom:4px;">NOMOR PESANAN</div>
                    <div style="font-weight:600; color:#4b2e1e; font-size:15px;">{{ $order->invoice_number }}</div>
                    <div style="font-size:12px; color:#aaa; margin-top:3px;">{{ $order->created_at->format('d M Y, H:i') }}</div>
                </div>
                <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                    {{-- Payment Status --}}
                    @if($order->payment)
                        @php $pb = $order->payment->getStatusBadgeAttribute(); @endphp
                        <span style="background:{{ $pb['color'] }}20; color:{{ $pb['color'] }}; font-size:11px; padding:5px 14px; border-radius:20px; font-weight:500;">
                            <i class="fa-solid fa-credit-card mr-1"></i> {{ $pb['label'] }}
                        </span>
                    @endif
                    {{-- Order Status --}}
                    @php $sb = $order->getStatusBadgeAttribute(); @endphp
                    <span style="background:{{ $sb['color'] }}20; color:{{ $sb['color'] }}; font-size:11px; padding:5px 14px; border-radius:20px; font-weight:500;">
                        {{ $sb['label'] }}
                    </span>
                </div>
            </div>

            <!-- Order Items -->
            <div style="border-top:1px solid #f0e8df; padding-top:16px; margin-bottom:16px;">
                @foreach($order->items as $item)
                <div style="display:flex; align-items:center; gap:15px; margin-bottom:12px;">
                    <img src="{{ $item->product?->image_url ?? asset('images/no-image.png') }}"
                         alt="{{ $item->product_name }}"
                         style="width:60px; height:60px; object-fit:cover; border-radius:12px;">
                    <div style="flex:1;">
                        <div style="font-weight:500; color:#4b2e1e; font-size:14px;">{{ $item->product_name }}</div>
                        <div style="font-size:12px; color:#888;">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                    </div>
                    <div style="font-weight:600; color:#7a4b2b; font-size:14px;">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Order Footer -->
            <div style="border-top:1px solid #f0e8df; padding-top:16px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                <div>
                    @if($order->shipment)
                    <div style="font-size:12px; color:#666;">
                        <i class="fa-solid fa-truck mr-1"></i> {{ $order->shipment->courier }} 
                        @if($order->shipment->tracking_number)
                            · Resi: <strong>{{ $order->shipment->tracking_number }}</strong>
                        @endif
                    </div>
                    @endif
                    <div style="font-size:13px; color:#888; margin-top:4px;">
                        Subtotal: <strong style="color:#4b2e1e; font-size:15px;">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong>
                    </div>
                    <div style="font-size:11px; color:#b77f28; margin-top:4px;">*Belum termasuk ongkos kirim</div>
                </div>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <a href="{{ route('orders.show', $order) }}"
                       style="background:#f6f1eb; color:#7a4b2b; padding:10px 20px; border-radius:12px; text-decoration:none; font-size:13px; font-weight:500; transition:0.3s;">
                        <i class="fa-solid fa-file-lines mr-1"></i> Detail
                    </a>
                    @if($order->status === 'pending' && (!$order->payment || $order->payment->status === 'pending'))
                    @endif
                    @if(in_array($order->status, ['pending', 'processing']))
                    <form method="POST" action="{{ route('orders.cancel', $order) }}" onsubmit="return confirm('Batalkan pesanan ini?')">
                        @csrf
                        <button type="submit"
                                style="background:#fff0f0; color:#dc3545; padding:10px 20px; border-radius:12px; border:1px solid #f5c6cb; font-size:13px; cursor:pointer; font-family:'Poppins',sans-serif;">
                            <i class="fa-solid fa-xmark mr-1"></i> Batalkan
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div style="background:white; border-radius:20px; padding:60px; text-align:center; box-shadow:0 5px 20px rgba(0,0,0,0.06);">
            <div style="font-size:60px; margin-bottom:20px;"><i class="fa-solid fa-cart-shopping"></i></div>
            <h3 style="font-family:'Playfair Display',serif; color:#4b2e1e; margin-bottom:10px;">Belum Ada Pesanan</h3>
            <p style="color:#888; font-size:14px; margin-bottom:25px;">Yuk mulai belanja produk segar dari Aziziscake!</p>
            <a href="{{ route('products.index') }}"
               style="background:#7a4b2b; color:white; padding:12px 28px; border-radius:25px; text-decoration:none; font-size:14px;">
                <i class="fa-solid fa-cake-candles mr-1"></i> Lihat Menu
            </a>
        </div>
        @endforelse

        {{ $orders->links() }}
    </div>
</div>
@endsection