@extends('layouts.admin')

@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk')
@section('subtitle', isset($product) ? "Edit: {$product->name}" : 'Tambah produk baru')

@section('content')

<div class="max-w-4xl">
    <form method="POST"
          action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if(isset($product)) @method('PUT') @endif

        <div class="grid grid-cols-3 gap-5">
            {{-- Main Info --}}
            <div class="col-span-2 space-y-5">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-5">Informasi Produk</h3>

                    <div class="mb-4">
                        <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">NAMA PRODUK *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b] @error('name') border-red-400 @enderror">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">DESKRIPSI</label>
                        <textarea name="description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b] resize-y">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">KATEGORI *</label>
                            <select name="category_id" required class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                                <option value="">Pilih kategori</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">BRAND</label>
                            <select name="brand_id" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                                <option value="">Tanpa Brand</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Pricing --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-5">Harga & Stok</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">HARGA NORMAL *</label>
                            <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" required min="0"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">HARGA DISKON</label>
                            <input type="number" name="price_discount" value="{{ old('price_discount', $product->price_discount ?? '') }}" min="0"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">HARGA PROMO</label>
                            <input type="number" name="price_promo" value="{{ old('price_promo', $product->price_promo ?? '') }}" min="0"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">% DISKON</label>
                            <input type="number" name="discount_percent" value="{{ old('discount_percent', $product->discount_percent ?? 0) }}" min="0" max="100"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">STOK *</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required min="0"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b]">
                        </div>
                    </div>
                </div>

                {{-- Images --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-5">Gambar Produk</h3>

                    @isset($product)
                    @if($product->images->count() > 0)
                    <div class="flex gap-3 mb-4 flex-wrap">
                        @foreach($product->images as $img)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $img->image) }}" class="w-20 h-20 object-cover rounded-xl" alt="Product">
                            @if($img->is_primary) <span class="absolute -top-1 -right-1 bg-[#7a4b2b] text-white text-xs px-1.5 rounded-full">★</span> @endif
                            <form method="POST" action="{{ route('admin.products.images.destroy', $img) }}" class="mt-1">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full text-xs text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @endisset

                    <input type="file" name="images[]" multiple accept="image/*"
                           class="w-full px-4 py-3 border-2 border-dashed border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:border-[#7a4b2b] cursor-pointer">
                    <p class="text-xs text-gray-400 mt-2">Upload multiple gambar. Gambar pertama akan jadi gambar utama. Max 2MB per file.</p>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-5">Pengaturan</h3>
                    <div class="space-y-4">
                        @foreach([['is_active','Aktif / Ditampilkan'],['is_featured','Produk Featured'],['is_bestseller','Label Terlaris'],['is_new','Label Baru']] as $toggle)
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-sm text-gray-600">{{ $toggle[1] }}</span>
                            <input type="hidden" name="{{ $toggle[0] }}" value="0">
                            <input type="checkbox" name="{{ $toggle[0] }}" value="1"
                                   {{ old($toggle[0], $product->{$toggle[0]} ?? ($toggle[0] === 'is_active' || $toggle[0] === 'is_new' ? true : false)) ? 'checked' : '' }}
                                   class="w-4 h-4 accent-[#7a4b2b]">
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full bg-[#7a4b2b] text-white py-3 rounded-xl font-medium hover:bg-[#5a3825] transition-colors">
                        {{ isset($product) ? 'Simpan Perubahan' : 'Tambah Produk' }}
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                       class="w-full text-center border border-gray-200 text-gray-600 py-3 rounded-xl text-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
