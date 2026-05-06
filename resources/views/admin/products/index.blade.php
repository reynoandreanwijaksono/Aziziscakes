@extends('layouts.admin')

@section('title', 'Manajemen Produk')
@section('subtitle', 'Kelola semua produk Aziziscake')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                   class="px-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b] w-64">
            <select name="category" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-xl text-sm hover:bg-gray-700">Filter</button>
        </form>
    </div>
    <a href="{{ route('admin.products.create') }}"
       class="bg-[#7a4b2b] text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-[#5a3825] transition-colors flex items-center gap-2">
        + Tambah Produk
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-4 text-xs text-gray-400 font-medium">Produk</th>
                    <th class="text-left px-6 py-4 text-xs text-gray-400 font-medium">Kategori</th>
                    <th class="text-left px-6 py-4 text-xs text-gray-400 font-medium">Harga</th>
                    <th class="text-left px-6 py-4 text-xs text-gray-400 font-medium">Stok</th>
                    <th class="text-left px-6 py-4 text-xs text-gray-400 font-medium">Status</th>
                    <th class="text-left px-6 py-4 text-xs text-gray-400 font-medium">Label</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                <img src="{{ $product->image_url }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                            </div>
                            <div>
                                <div class="font-medium text-gray-800 text-sm">{{ $product->name }}</div>
                                <div class="text-xs text-gray-400">{{ $product->brand->name ?? 'No Brand' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category->name ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-[#7a4b2b]">Rp {{ number_format($product->price,0,',','.') }}</div>
                        @if($product->discount_percent > 0)
                        <div class="text-xs text-red-500">-{{ $product->discount_percent }}% diskon</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm {{ $product->stock <= 5 ? 'text-red-500 font-semibold' : 'text-gray-600' }}">{{ $product->stock }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2.5 py-1 rounded-full {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-1 flex-wrap">
                            @if($product->is_bestseller) <span class="text-xs bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full">Terlaris</span> @endif
                            @if($product->is_new) <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">Baru</span> @endif
                            @if($product->is_featured) <span class="text-xs bg-purple-100 text-purple-600 px-2 py-0.5 rounded-full">Featured</span> @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="text-xs bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg hover:bg-gray-200 transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs bg-red-100 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-200 transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400 text-sm">Tidak ada produk ditemukan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection
