@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div style="padding:30px;">

    <div style="margin-bottom:25px;">
        <h1 style="font-family:'Playfair Display',serif; font-size:26px; color:#4b2e1e;">Manajemen User</h1>
        <p style="color:#888; font-size:14px;">Kelola akun pengguna terdaftar</p>
    </div>

    @if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:14px 20px; border-radius:12px; margin-bottom:20px; font-size:14px;"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
    @endif

    <!-- Filter -->
    <form method="GET" style="background:white; border-radius:16px; padding:20px; margin-bottom:20px; box-shadow:0 2px 10px rgba(0,0,0,0.05); display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end;">
        <div style="flex:3; min-width:200px;">
            <label style="display:block; font-size:11px; color:#aaa; letter-spacing:1px; margin-bottom:6px;">CARI USER</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama / email / telepon..."
                   style="width:100%; padding:10px 14px; border:1.5px solid #e8e0d8; border-radius:10px; font-size:13px; background:#faf8f5; outline:none;">
        </div>
        <div style="flex:1; min-width:130px;">
            <label style="display:block; font-size:11px; color:#aaa; letter-spacing:1px; margin-bottom:6px;">ROLE</label>
            <select name="role" style="width:100%; padding:10px 14px; border:1.5px solid #e8e0d8; border-radius:10px; font-size:13px; background:#faf8f5; outline:none;">
                <option value="">Semua</option>
                <option value="admin" {{ request('role')==='admin'?'selected':'' }}>Admin</option>
                <option value="user" {{ request('role')==='user'?'selected':'' }}>User</option>
            </select>
        </div>
        <div style="flex:1; min-width:130px;">
            <label style="display:block; font-size:11px; color:#aaa; letter-spacing:1px; margin-bottom:6px;">STATUS</label>
            <select name="status" style="width:100%; padding:10px 14px; border:1.5px solid #e8e0d8; border-radius:10px; font-size:13px; background:#faf8f5; outline:none;">
                <option value="">Semua</option>
                <option value="1" {{ request('status')==='1'?'selected':'' }}>Aktif</option>
                <option value="0" {{ request('status')==='0'?'selected':'' }}>Nonaktif</option>
            </select>
        </div>
        <button type="submit" style="background:#7a4b2b; color:white; padding:10px 22px; border:none; border-radius:10px; font-family:'Poppins',sans-serif; font-size:13px; cursor:pointer;">
            <i class="fa-solid fa-magnifying-glass mr-2"></i> Filter
        </button>
        <a href="{{ route('admin.users.index') }}" style="background:#f6f1eb; color:#7a4b2b; padding:10px 18px; border-radius:10px; text-decoration:none; font-size:13px;">Reset</a>
    </form>

    <!-- Stats Row -->
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:15px; margin-bottom:20px;">
        <div style="background:white; border-radius:14px; padding:18px 20px; box-shadow:0 2px 10px rgba(0,0,0,0.05); text-align:center;">
            <div style="font-size:28px; font-family:'Playfair Display',serif; color:#7a4b2b;">{{ $totalUsers }}</div>
            <div style="font-size:12px; color:#aaa; letter-spacing:1px;">TOTAL USER</div>
        </div>
        <div style="background:white; border-radius:14px; padding:18px 20px; box-shadow:0 2px 10px rgba(0,0,0,0.05); text-align:center;">
            <div style="font-size:28px; font-family:'Playfair Display',serif; color:#10b981;">{{ $activeUsers }}</div>
            <div style="font-size:12px; color:#aaa; letter-spacing:1px;">USER AKTIF</div>
        </div>
        <div style="background:white; border-radius:14px; padding:18px 20px; box-shadow:0 2px 10px rgba(0,0,0,0.05); text-align:center;">
            <div style="font-size:28px; font-family:'Playfair Display',serif; color:#f59e0b;">{{ $newUsers }}</div>
            <div style="font-size:12px; color:#aaa; letter-spacing:1px;">BARU (30 HARI)</div>
        </div>
    </div>

    <!-- Table -->
    <div style="background:white; border-radius:16px; box-shadow:0 2px 10px rgba(0,0,0,0.05); overflow:hidden;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#faf8f5; border-bottom:2px solid #f0e8df;">
                    <th style="text-align:left; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">User</th>
                    <th style="text-align:left; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Telepon</th>
                    <th style="text-align:center; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Role</th>
                    <th style="text-align:center; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Pesanan</th>
                    <th style="text-align:center; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Status</th>
                    <th style="text-align:left; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Terdaftar</th>
                    <th style="text-align:center; padding:14px 18px; font-size:11px; letter-spacing:1px; color:#aaa; text-transform:uppercase;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr style="border-bottom:1px solid #f6f1eb;" onmouseover="this.style.background='#fdf9f6'" onmouseout="this.style.background='white'">
                    <td style="padding:14px 18px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:38px; height:38px; border-radius:50%; background:#f0e6d9; display:flex; align-items:center; justify-content:center; font-weight:600; color:#7a4b2b; font-size:14px; flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size:13px; font-weight:500; color:#4b2e1e;">{{ $user->name }}</div>
                                <div style="font-size:11px; color:#aaa;">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding:14px 18px; font-size:13px; color:#555;">
                        {{ $user->phone ?? '—' }}
                    </td>
                    <td style="padding:14px 18px; text-align:center;">
                        @if($user->role === 'admin')
                        <span style="background:#7a4b2b20; color:#7a4b2b; font-size:11px; padding:4px 12px; border-radius:20px; font-weight:500;"><i class="fa-solid fa-crown mr-1"></i> Admin</span>
                        @else
                        <span style="background:#3b82f620; color:#3b82f6; font-size:11px; padding:4px 12px; border-radius:20px; font-weight:500;"><i class="fa-solid fa-user mr-1"></i> User</span>
                        @endif
                    </td>
                    <td style="padding:14px 18px; text-align:center; font-size:13px; color:#4b2e1e; font-weight:500;">
                        {{ $user->orders->count() }}
                    </td>
                    <td style="padding:14px 18px; text-align:center;">
                        @if($user->is_active)
                        <span style="background:#10b98120; color:#10b981; font-size:11px; padding:4px 12px; border-radius:20px; font-weight:500;"><i class="fa-solid fa-check mr-1"></i> Aktif</span>
                        @else
                        <span style="background:#ef444420; color:#ef4444; font-size:11px; padding:4px 12px; border-radius:20px; font-weight:500;"><i class="fa-solid fa-xmark mr-1"></i> Nonaktif</span>
                        @endif
                    </td>
                    <td style="padding:14px 18px; font-size:12px; color:#aaa;">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td style="padding:14px 18px; text-align:center;">
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    style="background:{{ $user->is_active ? '#fff0f0' : '#f0fdf4' }}; color:{{ $user->is_active ? '#ef4444' : '#10b981' }}; padding:7px 14px; border:none; border-radius:8px; font-size:12px; cursor:pointer; font-family:'Poppins',sans-serif;">
                                @if($user->is_active)
                                    <i class="fa-solid fa-xmark mr-2"></i> Nonaktifkan
                                @else
                                    <i class="fa-solid fa-check mr-2"></i> Aktifkan
                                @endif
                            </button>
                        </form>
                        @else
                        <span style="color:#ccc; font-size:12px;">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:50px; color:#aaa; font-size:14px;">Tidak ada data user</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($users->hasPages())
        <div style="padding:16px 18px; border-top:1px solid #f0e8df;">
            {{ $users->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
