@extends('layouts.admin')

@section('title', 'Manajemen Pengiriman')

@section('content')
<div style="padding:30px;">

    <div style="margin-bottom:25px;">
        <h1 style="font-family:'Playfair Display',serif; font-size:26px; color:#4b2e1e;">Manajemen Pengiriman</h1>
        <p style="color:#888; font-size:14px;">Kelola dan update status pengiriman pesanan</p>
    </div>

    @if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:14px 20px; border-radius:12px; margin-bottom:20px; font-size:14px;">✅ {{ session('success') }}</div>
    @endif

    <!-- Filter -->
    <form method="GET" style="background:white; border-radius:16px; padding:20px; margin-bottom:20px; box-shadow:0 2px 10px rgba(0,0,0,0.05); display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end;">
        <div style="flex:2; min-width:180px;">
            <label style="display:block; font-size:11px; color:#aaa; letter-spacing:1px; margin-bottom:6px;">CARI</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Invoice / resi / kurir..."
                   style="width:100%; padding:10px 14px; border:1.5px solid #e8e0d8; border-radius:10px; font-size:13px; background:#faf8f5; outline:none;">
        </div>
        <div style="flex:1; min-width:140px;">
            <label style="display:block; font-size:11px; color:#aaa; letter-spacing:1px; margin-bottom:6px;">STATUS</label>
            <select name="status" style="width:100%; padding:10px 14px; border:1.5px solid #e8e0d8; border-radius:10px; font-size:13px; background:#faf8f5; outline:none;">
                <option value="">Semua</option>
                <option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option>
                <option value="processing" {{ request('status')==='processing'?'selected':'' }}>Diproses</option>
                <option value="shipped" {{ request('status')==='shipped'?'selected':'' }}>Dikirim</option>
                <option value="delivered" {{ request('status')==='delivered'?'selected':'' }}>Terkirim</option>
            </select>
        </div>
        <button type="submit" style="background:#7a4b2b; color:white; padding:10px 22px; border:none; border-radius:10px; font-family:'Poppins',sans-serif; font-size:13px; cursor:pointer;">
            🔍 Filter
        </button>
        <a href="{{ route('admin.shipments.index') }}" style="background:#f6f1eb; color:#7a4b2b; padding:10px 18px; border-radius:10px; text-decoration:none; font-size:13px;">Reset</a>
    </form>

    <!-- Table -->
    <div style="background:white; border-radius:16px; box-shadow:0 2px 10px rgba(0,0,0,0.05); overflow:hidden;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#faf8f5; border-bottom:2px solid #f0e8df;">
                    <th style="text-align:left; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Invoice</th>
                    <th style="text-align:left; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Penerima</th>
                    <th style="text-align:left; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Kurir</th>
                    <th style="text-align:left; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Resi</th>
                    <th style="text-align:left; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Estimasi</th>
                    <th style="text-align:center; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Status</th>
                    <th style="text-align:center; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shipments as $shipment)
                <tr style="border-bottom:1px solid #f6f1eb;" onmouseover="this.style.background='#fdf9f6'" onmouseout="this.style.background='white'">
                    <td style="padding:14px 18px;">
                        <a href="{{ route('admin.orders.show', $shipment->order) }}" style="color:#7a4b2b; text-decoration:none; font-size:13px; font-weight:500;">
                            {{ $shipment->order->invoice_number ?? '-' }}
                        </a>
                    </td>
                    <td style="padding:14px 18px;">
                        <div style="font-size:13px; color:#4b2e1e; font-weight:500;">{{ $shipment->order->shipping_name ?? '-' }}</div>
                        <div style="font-size:11px; color:#aaa; max-width:180px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            📍 {{ $shipment->order->shipping_city ?? '' }}, {{ $shipment->order->shipping_province ?? '' }}
                        </div>
                    </td>
                    <td style="padding:14px 18px; font-size:13px; color:#555;">
                        🚚 {{ $shipment->courier }}
                    </td>
                    <td style="padding:14px 18px; font-size:13px; font-family:monospace; color:#4b2e1e;">
                        {{ $shipment->tracking_number ?: '—' }}
                    </td>
                    <td style="padding:14px 18px; font-size:12px; color:#666;">
                        {{ $shipment->estimated_delivery ?: '—' }}
                    </td>
                    <td style="padding:14px 18px; text-align:center;">
                        @php
                            $colors = ['pending'=>'#f59e0b','processing'=>'#3b82f6','shipped'=>'#8b5cf6','delivered'=>'#10b981'];
                            $labels = ['pending'=>'Pending','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Terkirim'];
                            $c = $colors[$shipment->status] ?? '#888';
                            $l = $labels[$shipment->status] ?? $shipment->status;
                        @endphp
                        <span style="background:{{ $c }}20; color:{{ $c }}; font-size:11px; padding:4px 12px; border-radius:20px; font-weight:500;">{{ $l }}</span>
                    </td>
                    <td style="padding:14px 18px; text-align:center;">
                        <button onclick="openModal({{ $shipment->id }}, '{{ $shipment->courier }}', '{{ $shipment->tracking_number }}', '{{ $shipment->estimated_delivery }}', '{{ $shipment->status }}')"
                                style="background:#7a4b2b; color:white; padding:7px 16px; border:none; border-radius:8px; font-size:12px; cursor:pointer; font-family:'Poppins',sans-serif;">
                            ✏️ Update
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:50px; color:#aaa; font-size:14px;">Tidak ada data pengiriman</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($shipments->hasPages())
        <div style="padding:16px 18px; border-top:1px solid #f0e8df;">
            {{ $shipments->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Update Modal -->
<div id="updateModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:20px; padding:30px; width:100%; max-width:460px; margin:20px;">
        <h3 style="font-family:'Playfair Display',serif; color:#4b2e1e; margin-bottom:20px;">Update Pengiriman</h3>

        <form id="updateForm" method="POST">
            @csrf @method('PATCH')

            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:11px; color:#aaa; letter-spacing:1px; margin-bottom:6px;">KURIR</label>
                <select name="courier" id="modal_courier" style="width:100%; padding:11px 14px; border:1.5px solid #e8e0d8; border-radius:10px; font-size:13px; background:#faf8f5; outline:none;">
                    <option value="JNE">JNE</option>
                    <option value="J&T Express">J&T Express</option>
                    <option value="SiCepat">SiCepat</option>
                    <option value="Grab Express">Grab Express</option>
                    <option value="Gojek">Gojek</option>
                    <option value="Pos Indonesia">Pos Indonesia</option>
                </select>
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:11px; color:#aaa; letter-spacing:1px; margin-bottom:6px;">NOMOR RESI</label>
                <input type="text" name="tracking_number" id="modal_tracking" placeholder="Masukkan nomor resi"
                       style="width:100%; padding:11px 14px; border:1.5px solid #e8e0d8; border-radius:10px; font-size:13px; background:#faf8f5; outline:none;">
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:11px; color:#aaa; letter-spacing:1px; margin-bottom:6px;">ESTIMASI PENGIRIMAN</label>
                <input type="text" name="estimated_delivery" id="modal_estimated" placeholder="Contoh: 2-3 hari kerja"
                       style="width:100%; padding:11px 14px; border:1.5px solid #e8e0d8; border-radius:10px; font-size:13px; background:#faf8f5; outline:none;">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:11px; color:#aaa; letter-spacing:1px; margin-bottom:6px;">STATUS PENGIRIMAN</label>
                <select name="status" id="modal_status" style="width:100%; padding:11px 14px; border:1.5px solid #e8e0d8; border-radius:10px; font-size:13px; background:#faf8f5; outline:none;">
                    <option value="pending">Pending</option>
                    <option value="processing">Diproses</option>
                    <option value="shipped">Dikirim</option>
                    <option value="delivered">Terkirim</option>
                </select>
            </div>

            <div style="display:flex; gap:10px;">
                <button type="button" onclick="closeModal()"
                        style="flex:1; background:#f6f1eb; color:#7a4b2b; padding:12px; border:none; border-radius:12px; font-family:'Poppins',sans-serif; font-size:14px; cursor:pointer;">
                    Batal
                </button>
                <button type="submit"
                        style="flex:2; background:#7a4b2b; color:white; padding:12px; border:none; border-radius:12px; font-family:'Poppins',sans-serif; font-size:14px; cursor:pointer; font-weight:500;">
                    Simpan Perubahan ✓
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id, courier, tracking, estimated, status) {
    document.getElementById('updateForm').action = `/admin/shipments/${id}`;
    document.getElementById('modal_courier').value = courier;
    document.getElementById('modal_tracking').value = tracking;
    document.getElementById('modal_estimated').value = estimated;
    document.getElementById('modal_status').value = status;
    document.getElementById('updateModal').style.display = 'flex';
}
function closeModal() {
    document.getElementById('updateModal').style.display = 'none';
}
document.getElementById('updateModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endsection
