@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div style="padding:30px;">

    <!-- Header -->
    <div style="margin-bottom:25px;">
        <h1 style="font-family:'Playfair Display',serif; font-size:26px; color:#4b2e1e;">Manajemen Pembayaran</h1>
        <p style="color:#888; font-size:14px;">Konfirmasi dan kelola status pembayaran pelanggan</p>
    </div>

    @if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:14px 20px; border-radius:12px; margin-bottom:20px; font-size:14px;"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <!-- Filter Bar -->
    <form method="GET" style="background:white; border-radius:16px; padding:20px; margin-bottom:20px; box-shadow:0 2px 10px rgba(0,0,0,0.05); display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end;">
        <div style="flex:2; min-width:180px;">
            <label style="display:block; font-size:11px; color:#aaa; letter-spacing:1px; margin-bottom:6px;">CARI</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Invoice / nama pelanggan..."
                   style="width:100%; padding:10px 14px; border:1.5px solid #e8e0d8; border-radius:10px; font-size:13px; background:#faf8f5; outline:none;">
        </div>
        <div style="flex:1; min-width:140px;">
            <label style="display:block; font-size:11px; color:#aaa; letter-spacing:1px; margin-bottom:6px;">STATUS</label>
            <select name="status" style="width:100%; padding:10px 14px; border:1.5px solid #e8e0d8; border-radius:10px; font-size:13px; background:#faf8f5; outline:none;">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option>
                <option value="paid" {{ request('status')==='paid'?'selected':'' }}>Paid</option>
                <option value="failed" {{ request('status')==='failed'?'selected':'' }}>Failed</option>
                <option value="refunded" {{ request('status')==='refunded'?'selected':'' }}>Refunded</option>
            </select>
        </div>
        <div style="flex:1; min-width:140px;">
            <label style="display:block; font-size:11px; color:#aaa; letter-spacing:1px; margin-bottom:6px;">METODE</label>
            <select name="method" style="width:100%; padding:10px 14px; border:1.5px solid #e8e0d8; border-radius:10px; font-size:13px; background:#faf8f5; outline:none;">
                <option value="">Semua Metode</option>
                <option value="transfer" {{ request('method')==='transfer'?'selected':'' }}>Transfer Bank</option>
                <option value="ewallet" {{ request('method')==='ewallet'?'selected':'' }}>E-Wallet</option>
                <option value="cod" {{ request('method')==='cod'?'selected':'' }}>COD</option>
            </select>
        </div>
        <button type="submit" style="background:#7a4b2b; color:white; padding:10px 22px; border:none; border-radius:10px; font-family:'Poppins',sans-serif; font-size:13px; cursor:pointer; font-weight:500;">
            <i class="fas fa-magnifying-glass"></i> Filter
        </button>
        <a href="{{ route('admin.payments.index') }}" style="background:#f6f1eb; color:#7a4b2b; padding:10px 18px; border-radius:10px; text-decoration:none; font-size:13px;">Reset</a>
    </form>

    <!-- Table -->
    <div style="background:white; border-radius:16px; box-shadow:0 2px 10px rgba(0,0,0,0.05); overflow:hidden;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#faf8f5; border-bottom:2px solid #f0e8df;">
                    <th style="text-align:left; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Invoice</th>
                    <th style="text-align:left; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Pelanggan</th>
                    <th style="text-align:left; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Metode</th>
                    <th style="text-align:right; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Jumlah</th>
                    <th style="text-align:center; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Bukti</th>
                    <th style="text-align:center; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Status</th>
                    <th style="text-align:left; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Tanggal</th>
                    <th style="text-align:center; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr style="border-bottom:1px solid #f6f1eb; transition:background 0.2s;" onmouseover="this.style.background='#fdf9f6'" onmouseout="this.style.background='white'">
                    <td style="padding:14px 18px;">
                        <a href="{{ route('admin.orders.show', $payment->order) }}" style="color:#7a4b2b; text-decoration:none; font-size:13px; font-weight:500;">
                            {{ $payment->order->invoice_number ?? '-' }}
                        </a>
                    </td>
                    <td style="padding:14px 18px;">
                        <div style="font-size:13px; color:#4b2e1e; font-weight:500;">{{ $payment->order->user->name ?? '-' }}</div>
                        <div style="font-size:11px; color:#aaa;">{{ $payment->order->user->email ?? '' }}</div>
                    </td>
                    <td style="padding:14px 18px;">
                        @php
                            $methods = ['transfer' => ['label'=>'Transfer Bank','icon'=>'fa-bank'], 'ewallet' => ['label'=>'E-Wallet','icon'=>'fa-mobile-alt'], 'cod' => ['label'=>'COD','icon'=>'fa-money-bill-alt']];
                            $m = $methods[$payment->payment_method] ?? ['label'=>$payment->payment_method,'icon'=>'fa-credit-card'];
                        @endphp
                        <span style="font-size:13px; color:#555;"><i class="fas {{ $m['icon'] }} mr-2"></i>{{ $m['label'] }}</span>
                    </td>
                    <td style="padding:14px 18px; text-align:right; font-weight:600; color:#4b2e1e; font-size:13px;">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </td>
                    <td style="padding:14px 18px; text-align:center;">
                        @if($payment->payment_proof)
                        <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank"
                           style="display:inline-block; background:#fef3ec; color:#7a4b2b; padding:5px 12px; border-radius:8px; text-decoration:none; font-size:12px;">
                            <i class="fas fa-file-alt mr-1"></i> Lihat
                        </a>
                        @else
                        <span style="color:#ccc; font-size:12px;">—</span>
                        @endif
                    </td>
                    <td style="padding:14px 18px; text-align:center;">
                        @php
                            $colors = ['pending'=>'#f59e0b','paid'=>'#10b981','failed'=>'#ef4444','refunded'=>'#6366f1'];
                            $labels = ['pending'=>'Pending','paid'=>'Paid','failed'=>'Failed','refunded'=>'Refunded'];
                            $c = $colors[$payment->status] ?? '#888';
                            $l = $labels[$payment->status] ?? $payment->status;
                        @endphp
                        <span style="background:{{ $c }}20; color:{{ $c }}; font-size:11px; padding:4px 12px; border-radius:20px; font-weight:500;">{{ $l }}</span>
                    </td>
                    <td style="padding:14px 18px; font-size:12px; color:#aaa;">
                        {{ $payment->created_at->format('d M Y') }}<br>{{ $payment->created_at->format('H:i') }}
                    </td>
                    <td style="padding:14px 18px; text-align:center;">
                        @if($payment->status === 'pending')
                        <div style="display:flex; gap:6px; justify-content:center;">
                            <form method="POST" action="{{ route('admin.payments.update-status', $payment) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="paid">
                                <button type="submit" onclick="return confirm('Konfirmasi pembayaran ini?')"
                                        style="background:#10b981; color:white; padding:7px 14px; border:none; border-radius:8px; font-size:12px; cursor:pointer; font-family:'Poppins',sans-serif;">
                                    ✓ Konfirmasi
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.payments.update-status', $payment) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="failed">
                                <button type="submit" onclick="return confirm('Tolak pembayaran ini?')"
                                        style="background:#ef4444; color:white; padding:7px 14px; border:none; border-radius:8px; font-size:12px; cursor:pointer; font-family:'Poppins',sans-serif;">
                                    ✕ Tolak
                                </button>
                            </form>
                        </div>
                        @elseif($payment->status === 'paid')
                        <form method="POST" action="{{ route('admin.payments.update-status', $payment) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="refunded">
                            <button type="submit" onclick="return confirm('Proses refund?')"
                                    style="background:#6366f1; color:white; padding:7px 14px; border:none; border-radius:8px; font-size:12px; cursor:pointer; font-family:'Poppins',sans-serif;">
                                ↩ Refund
                            </button>
                        </form>
                        @else
                        <span style="color:#ccc; font-size:12px;">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:50px; color:#aaa; font-size:14px;">
                        Tidak ada data pembayaran
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($payments->hasPages())
        <div style="padding:16px 18px; border-top:1px solid #f0e8df;">
            {{ $payments->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
