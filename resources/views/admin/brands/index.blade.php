@extends('layouts.admin')

@section('title', 'Manajemen Brand')
@section('subtitle', 'Kelola brand produk Aziziscake')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    {{-- Brand List --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full">
            <div class="px-4 md:px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h3 class="font-semibold text-gray-700">Daftar Brand</h3>
                <form method="GET" class="flex gap-2 w-full sm:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari brand..."
                           class="w-full sm:w-auto px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-xl text-sm hover:bg-gray-700 flex-shrink-0">Cari</button>
                </form>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full whitespace-nowrap">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs text-gray-400 font-medium">Brand</th>
                        <th class="text-left px-6 py-3 text-xs text-gray-400 font-medium">Produk</th>
                        <th class="text-left px-6 py-3 text-xs text-gray-400 font-medium">Status</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($brands as $brand)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden">
                                    @if($brand->logo)
                                    <img src="{{ asset('storage/' . $brand->logo) }}" class="w-full h-full object-cover" alt="{{ $brand->name }}">
                                    @else
                                    <span class="text-lg"><i class="fa-solid fa-tag"></i></span>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800 text-sm">{{ $brand->name }}</div>
                                    <div class="text-xs text-gray-400 line-clamp-1">{{ $brand->description }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $brand->products_count }} produk</td>
                        <td class="px-6 py-4">
                            <span class="text-xs px-2.5 py-1 rounded-full {{ $brand->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $brand->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2" x-data="{ editOpen: false }">
                                <button @click="editOpen = true" class="text-xs bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg hover:bg-gray-200">Edit</button>
                                <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" onsubmit="return confirm('Hapus brand ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs bg-red-100 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-200">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400 text-sm">Belum ada brand</td></tr>
                    @endforelse
                </tbody>
                </table>
            </div>
            @if($brands->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">{{ $brands->links() }}</div>
            @endif
        </div>
    </div>

    {{-- Add Brand Form --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 sticky top-24">
            <h3 class="font-semibold text-gray-700 mb-5">Tambah Brand Baru</h3>
            <form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">NAMA BRAND *</label>
                    <input type="text" name="name" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]"
                           placeholder="Nama brand">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">DESKRIPSI</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b] resize-none"
                              placeholder="Deskripsi brand"></textarea>
                </div>
                <div class="mb-4">
                    <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">LOGO</label>
                    <input type="file" name="logo" accept="image/*"
                           class="w-full text-sm text-gray-500 border border-dashed border-gray-200 px-3 py-2 rounded-xl">
                </div>
                <div class="mb-5 flex items-center justify-between">
                    <label class="text-sm text-gray-600">Status Aktif</label>
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" checked class="accent-[#7a4b2b]">
                </div>
                <button type="submit" class="w-full bg-[#7a4b2b] text-white py-3 rounded-xl font-medium hover:bg-[#5a3825] transition-colors text-sm">
                    + Tambah Brand
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
