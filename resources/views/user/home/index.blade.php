@extends('layouts.app')

@section('title', 'Aziziscake – Toko Kue Premium Jepara')

@section('content')
@php
    $get = fn($key, $default = '') => $settings[$key] ?? $default;
@endphp

{{-- HERO --}}
<section class="relative min-h-[70vh] md:min-h-[90vh] bg-cover bg-center flex items-center justify-center overflow-hidden"
         style="background-image: url('{{ $get('hero_background_image', 'https://images.unsplash.com/photo-1608198093002-ad4e005484ec') }}')">
    <div class="absolute inset-0 bg-[#fff5eb]/85 backdrop-blur-sm"></div>

    {{-- Floating Images --}}
    <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400"
         class="absolute left-20 bottom-20 w-48 rounded-2xl shadow-2xl hidden lg:block animate-bounce" alt="Roti" style="animation-duration:4s" loading="lazy">
    <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=350"
         class="absolute right-24 top-28 w-44 rounded-2xl shadow-2xl hidden lg:block animate-bounce" alt="Kue" style="animation-duration:5s;animation-delay:0.5s" loading="lazy">

    <div class="relative bg-white/92 p-8 md:p-12 rounded-3xl text-center max-w-lg mx-5 shadow-2xl z-10 w-full">
        {{-- Floating Badge 1 --}}
        <div class="absolute -top-6 -right-4 md:-right-8 bg-white px-4 py-2.5 rounded-2xl shadow-xl flex items-center gap-3 animate-pulse" style="animation-duration: 3s">
            <div class="bg-yellow-100 text-yellow-600 p-1.5 rounded-full text-lg leading-none"><i class="fa-solid fa-star"></i></div>
            <div class="text-left">
                <div class="font-bold text-[#4b2e1e] text-sm leading-tight">4.9/5.0</div>
                <div class="text-[10px] text-gray-500">Ulasan Terbaik</div>
            </div>
        </div>

        {{-- Floating Badge 2 --}}
        <div class="absolute -bottom-5 -left-4 md:-left-8 bg-white px-4 py-2.5 rounded-2xl shadow-xl flex items-center gap-3">
            <div class="bg-green-100 text-green-600 p-1.5 rounded-full text-lg leading-none"><i class="fa-solid fa-circle-check"></i></div>
            <div class="text-left">
                <div class="font-bold text-[#4b2e1e] text-sm leading-tight">100% Halal</div>
                <div class="text-[10px] text-gray-500">Bahan Premium</div>
            </div>
        </div>

        <span class="text-xs md:text-sm tracking-widest text-[#7a4b2b] font-medium">{{ $get('hero_label', '✦ Resep Rahasia Sejak 1990 ✦') }}</span>
        <h1 class="playfair text-4xl md:text-5xl text-[#4b2e1e] mt-4 mb-4 leading-tight">{!! nl2br(e(str_replace(['<br>', '<br/>', '<br />'], "\n", $get('hero_title', "Freshly Baked,\nJust for You!")))) !!}</h1>
        <p class="text-gray-500 text-xs md:text-sm mb-8 leading-relaxed px-2">{{ $get('hero_subtitle', 'Roti dan kue premium dibuat setiap hari dengan bahan-bahan pilihan terbaik tanpa pengawet.') }}</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center items-center">
            <a href="{{ $get('hero_primary_cta_link', route('products.index')) }}" class="w-full sm:w-auto bg-[#7a4b2b] text-white px-8 py-3 rounded-full hover:bg-[#5a3825] hover:-translate-y-0.5 transition-all text-sm font-medium">
                {{ $get('hero_primary_cta_text', 'Pesan Sekarang') }}
            </a>
            <a href="{{ $get('hero_secondary_cta_link', route('products.index')) }}" class="w-full sm:w-auto border-2 border-[#7a4b2b] text-[#7a4b2b] px-8 py-3 rounded-full hover:bg-[#7a4b2b] hover:text-white transition-all text-sm font-medium">
                {{ $get('hero_secondary_cta_text', 'Lihat Menu') }}
            </a>
        </div>
    </div>
</section>

{{-- STATS --}}
<div class="bg-white py-14 border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        @foreach([['3500+', 'PELANGGAN SETIA'], ['34', 'TAHUN BERPENGALAMAN'], ['50+', 'VARIAN PRODUK'], ['98%', 'KEPUASAN PELANGGAN']] as $stat)
        <div>
            <div class="playfair text-4xl text-[#7a4b2b] font-bold">{{ $stat[0] }}</div>
            <div class="text-xs text-gray-400 tracking-widest mt-2">{{ $stat[1] }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- PROMO BANNER --}}
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="bg-gradient-to-br from-[#7a4b2b] to-[#5a3825] rounded-3xl p-10 flex items-center justify-between gap-8 flex-wrap">
        <div>
            <h2 class="playfair text-3xl text-white mb-2">{{ $get('promo_title', 'Promo Spesial Akhir Pekan!') }}</h2>
            <p class="text-white/80 text-sm leading-relaxed max-w-md">{!! nl2br(e(str_replace(['<br>', '<br/>', '<br />'], "\n", $get('promo_description', "Nikmati diskon eksklusif untuk setiap pembelian Custom Cake.\nTerbatas hanya untuk 20 pesanan pertama setiap Sabtu & Minggu.")))) !!}</p>
            <a href="{{ $get('promo_cta_link', route('products.index')) }}"
               class="inline-block mt-5 bg-white text-[#7a4b2b] px-7 py-3 rounded-full font-medium text-sm hover:-translate-y-1 hover:shadow-xl transition-all">
                {{ $get('promo_cta_text', 'Pesan Sekarang →') }}
            </a>
        </div>
        <div class="bg-white/15 border-2 border-dashed border-white/50 rounded-2xl px-10 py-6 text-center text-white">
            <div class="playfair text-6xl leading-none">{{ $get('promo_discount_label', '20%') }}</div>
            <div class="font-medium mt-1">OFF</div>
            <div class="text-xs opacity-80 mt-1">{{ $get('promo_discount_detail', 'Custom Cake & Hampers') }}</div>
        </div>
    </div>
</div>

{{-- FEATURED PRODUCTS --}}
<section class="max-w-7xl mx-auto px-6 pb-16" id="produk">
    <div class="text-center mb-10">
        <div class="text-xs tracking-widest text-[#7a4b2b] uppercase mb-2">— Menu Unggulan —</div>
        <h2 class="playfair text-4xl text-[#4b2e1e]">Produk Kami</h2>
        <p class="text-gray-400 text-sm mt-2">Dibuat segar setiap pagi, dinikmati setiap hari</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($featuredProducts as $product)
        <a href="{{ route('products.show', $product) }}" class="group bg-white rounded-2xl p-4 shadow-sm hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
            <div class="relative overflow-hidden rounded-xl mb-3">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                     class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                @if($product->is_bestseller)
                <span class="absolute top-2 left-2 bg-[#fef3ec] text-[#7a4b2b] text-xs px-2.5 py-0.5 rounded-full"><i class="fa-solid fa-fire mr-1"></i> Terlaris</span>
                @elseif($product->is_new)
                <span class="absolute top-2 left-2 bg-blue-50 text-blue-600 text-xs px-2.5 py-0.5 rounded-full"><i class="fa-solid fa-star mr-1"></i> Baru</span>
                @endif
                @if($product->discount_percent > 0)
                <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">-{{ $product->discount_percent }}%</span>
                @endif
            </div>
            <div class="text-xs text-[#7a4b2b] mb-1">{{ $product->category->name ?? '-' }}</div>
            <h3 class="font-semibold text-[#4b2e1e] text-sm mb-1 line-clamp-1">{{ $product->name }}</h3>
            <p class="text-gray-400 text-xs mb-3 line-clamp-2">{{ $product->description }}</p>
            <div class="flex items-center justify-between">
                <div>
                    @if($product->price_discount)
                    <span class="text-gray-400 text-xs line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <div class="text-[#7a4b2b] font-semibold text-sm">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</div>
                    @else
                    <div class="text-[#7a4b2b] font-semibold text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    @endif
                </div>
                <button class="bg-[#7a4b2b] text-white text-xs px-4 py-2 rounded-full hover:bg-[#5a3825] transition-colors">
                    Pesan
                </button>
            </div>
            <div class="mt-2 text-xs text-[#e8a33a]">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i> <span class="text-gray-400">({{ $product->review_count }})</span>
            </div>
        </a>
        @endforeach
    </div>

    <div class="text-center mt-10">
        <a href="{{ route('products.index') }}" class="inline-block border-2 border-[#7a4b2b] text-[#7a4b2b] px-8 py-3 rounded-full hover:bg-[#7a4b2b] hover:text-white transition-all text-sm font-medium">
            Lihat Semua Produk →
        </a>
    </div>
</section>

{{-- GALLERY --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 pb-20" id="galeri">
    <div class="text-center mb-10">
        <div class="text-xs tracking-widest text-[#7a4b2b] uppercase mb-2">— Momen Manis —</div>
        <h2 class="playfair text-3xl md:text-4xl text-[#4b2e1e]">Galeri Kami</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4 h-auto md:h-[500px]">
        <div class="col-span-2 md:col-span-1 md:row-span-2 relative rounded-2xl overflow-hidden group cursor-pointer h-[200px] md:h-auto">
            <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=600" alt="Dapur" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
            <div class="absolute inset-0 bg-[#4b2e1e]/55 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-sm tracking-widest">Dapur Kami</div>
        </div>
        @foreach([['https://images.unsplash.com/photo-1509440159596-0249088772ff?w=500','Artisan Bread'],['https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500','Custom Cake'],['https://images.unsplash.com/photo-1551024601-bec78aea704b?w=500','Sweet Pastry'],['https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=500','Cinnamon Roll']] as $img)
        <div class="relative rounded-2xl overflow-hidden group cursor-pointer h-[150px] md:h-auto">
            <img src="{{ $img[0] }}" alt="{{ $img[1] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
            <div class="absolute inset-0 bg-[#4b2e1e]/55 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-sm tracking-widest">{{ $img[1] }}</div>
        </div>
        @endforeach
    </div>
</section>

{{-- ABOUT --}}
<section class="bg-white py-20 px-6" id="tentang">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-16">
        <div class="md:w-2/5">
            <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=700" alt="Bakery"
                 class="w-full h-[450px] object-cover rounded-2xl shadow-xl">
        </div>
        <div class="md:w-3/5">
            <div class="text-xs tracking-widest text-[#7a4b2b] uppercase mb-3">{{ $get('about_label', '— Kisah Kami —') }}</div>
            <h2 class="playfair text-4xl text-[#4b2e1e] mb-5">{{ $get('about_title', 'Tentang Aziziscake') }}</h2>
            <p class="text-gray-500 text-sm leading-relaxed mb-4">{{ $get('about_paragraph_1', 'Sejak lama, Aziziscake telah menghadirkan kelezatan kue dan roti berkualitas di jantung Jepara, Jawa Tengah — menggunakan resep keluarga yang penuh cinta dan diwariskan dengan bangga.') }}</p>
            <p class="text-gray-500 text-sm leading-relaxed mb-8">{{ $get('about_paragraph_2', 'Setiap produk kami dibuat fresh setiap hari menggunakan bahan premium pilihan tanpa pengawet sama sekali. Karena kami percaya, makanan terbaik adalah makanan yang jujur.') }}</p>
            <div class="grid grid-cols-2 gap-5">
                @foreach([1,2,3,4] as $index)
                @php
                    $icons = ['<i class="fa-solid fa-wheat-awn"></i>', '<i class="fa-solid fa-leaf"></i>', '<i class="fa-regular fa-clock"></i>', '<i class="fa-solid fa-truck"></i>'];
                    $titles = ['Bahan Premium', '100% Alami', 'Selalu Segar', 'Pengiriman Cepat'];
                    $icon = $get("about_feature_{$index}_icon", $icons[$index - 1]);
                    $title = $get("about_feature_{$index}_title", $titles[$index - 1]);
                    $text = $get("about_feature_{$index}_text", ['Tepung & bahan pilihan premium','100% alami, sehat & segar','Dipanggang setiap pagi pukul 5','Pengiriman dalam 2 jam'][$index - 1]);
                @endphp
                <div class="flex gap-3 items-start">
                    <span class="text-2xl text-[#7a4b2b] w-8 text-center">{!! $icon !!}</span>
                    <div>
                        <h4 class="font-semibold text-[#4b2e1e] text-sm">{{ $title }}</h4>
                        <p class="text-gray-400 text-xs mt-0.5">{{ $text }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- BESTSELLER PRODUCTS --}}
@if($bestsellerProducts->count() > 0)
<section class="max-w-7xl mx-auto px-6 py-16">
    <div class="text-center mb-10">
        <div class="text-xs tracking-widest text-[#7a4b2b] uppercase mb-2">— Paling Favorit —</div>
        <h2 class="playfair text-4xl text-[#4b2e1e]">Produk Terlaris</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($bestsellerProducts as $product)
        <a href="{{ route('products.show', $product) }}" class="group bg-white rounded-2xl p-4 shadow-sm hover:-translate-y-1 hover:shadow-lg transition-all">
            <div class="overflow-hidden rounded-xl mb-3">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-36 object-cover group-hover:scale-105 transition-transform duration-300">
            </div>
            <h3 class="font-medium text-[#4b2e1e] text-sm line-clamp-1">{{ $product->name }}</h3>
            <div class="flex items-center justify-between mt-2">
                <span class="text-[#7a4b2b] font-semibold text-sm">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</span>
                <span class="text-xs text-gray-400">{{ number_format($product->sold_count) }} terjual</span>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- TESTIMONIALS --}}
<section class="bg-[#f6f1eb] py-20 px-6" id="testimoni">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-10">
            <div class="text-xs tracking-widest text-[#7a4b2b] uppercase mb-2">— Kata Mereka —</div>
            <h2 class="playfair text-4xl text-[#4b2e1e]">Ulasan Pelanggan</h2>
            <p class="text-gray-400 text-sm mt-2">Kepercayaan Anda adalah semangat kami setiap hari</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @for($i = 1; $i <= 3; $i++)
            <div class="bg-white rounded-2xl p-7 shadow-sm relative">
                <div class="text-8xl playfair text-[#f0e6d9] absolute -top-3 left-4 leading-none">"</div>
                <div class="text-[#e8a33a] text-sm mb-3">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed mb-5">{{ $get("testimonial_{$i}_text", ['Kuenya benar-benar luar biasa! Teksturnya lembut, rasanya pas di lidah, dan aromanya menggoda banget. Sudah langganan lama dan nggak pernah kecewa sama Aziziscake!','Custom cake untuk ulang tahun anak saya benar-benar membuat semua tamu terkejut! Desainnya persis seperti yang diminta, dan rasanya lebih enak dari tampilannya.','Cinnamon roll-nya meleleh di mulut! Harganya pun sangat terjangkau untuk kualitas sebagus ini. Pengirimannya juga cepat dan roti sampai masih hangat.'][$i - 1]) }}</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#f0e6d9] flex items-center justify-center font-semibold text-[#7a4b2b] text-sm">{{ $get("testimonial_{$i}_initial", ['SR','BW','AD'][$i - 1]) }}</div>
                    <div>
                        <div class="font-semibold text-[#4b2e1e] text-sm">{{ $get("testimonial_{$i}_name", ['Sari Rahayu','Budi Widodo','Ayu Dianty'][$i - 1]) }}</div>
                        <div class="text-gray-400 text-xs">{{ $get("testimonial_{$i}_role", ['Pelanggan Setia · Jepara','Pelanggan Baru · Kudus','Pelanggan Setia · Jepara'][$i - 1]) }}</div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="py-20 px-6" id="faq">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-10">
            <div class="text-xs tracking-widest text-[#7a4b2b] uppercase mb-2">— Ada Pertanyaan? —</div>
            <h2 class="playfair text-4xl text-[#4b2e1e]">FAQ</h2>
            <p class="text-gray-400 text-sm mt-2">Pertanyaan yang sering ditanyakan pelanggan kami</p>
        </div>

        <div class="space-y-3" x-data="{ open: null }">
            @for($i = 1; $i <= 5; $i++)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm">
                <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                        class="w-full px-6 py-5 flex justify-between items-center text-left font-medium text-[#4b2e1e] text-sm hover:bg-[#fef9f5] transition-colors">
                    <span class="pr-4">{{ $get("faq_{$i}_question", ['Apakah produk bisa dipesan dalam jumlah banyak (bulk order)?','Berapa lama ketahanan produk setelah dibeli?','Apakah tersedia opsi vegan atau bebas gluten?','Bagaimana cara memesan custom cake?','Apakah ada layanan pengiriman ke luar kota?'][$i - 1]) }}</span>
                    <span class="text-[#7a4b2b] text-xl transition-transform flex-shrink-0" :class="open === {{ $i }} ? 'rotate-45' : ''">+</span>
                </button>
                <div x-show="open === {{ $i }}" x-transition.opacity.duration.300ms class="px-6 pb-5 text-gray-500 text-sm leading-relaxed">
                    {{ $get("faq_{$i}_answer", ['Ya, kami menerima bulk order untuk berbagai keperluan seperti acara, arisan, atau corporate gift. Hubungi kami minimal 3 hari sebelum tanggal pengiriman untuk pemesanan lebih dari 50 pcs.','Roti dan pastry kami bertahan 2–3 hari pada suhu ruang, dan hingga 7 hari jika disimpan dalam kulkas. Custom cake lebih baik dikonsumsi dalam 2 hari.','Saat ini kami memiliki pilihan vegan untuk beberapa produk pastry dan kue. Untuk opsi bebas gluten, tersedia berdasarkan permintaan khusus dengan lead time 2 hari.','Pemesanan custom cake bisa melalui WhatsApp atau langsung di website. Sertakan detail desain, ukuran, rasa, dan tanggal dibutuhkan. Kami memerlukan minimal 5 hari kerja.','Saat ini layanan pengiriman kami mencakup area Jepara, Kudus, Pati, dan sekitarnya.'][$i - 1]) }}</div>
            </div>
            @endfor
        </div>
    </div>
</section>

{{-- ORDER FORM / CONTACT --}}
<section class="bg-white py-20 px-6" id="pesan">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-16 items-start">
        <div class="md:w-2/5">
            <div class="text-xs tracking-widest text-[#7a4b2b] uppercase mb-3">— Hubungi Kami —</div>
            <h2 class="playfair text-4xl text-[#4b2e1e] mb-4">Pesan Sekarang</h2>
            <p class="text-gray-500 text-sm leading-relaxed mb-6">{{ $get('contact_description', 'Isi form di samping atau hubungi kami langsung melalui WhatsApp. Kami siap membantu dari pukul 06.00 – 19.00 setiap hari.') }}</p>
            <ul class="space-y-3 text-sm text-gray-600">
                <li class="flex items-center gap-3"><span class="text-lg w-6 text-center text-[#7a4b2b]"><i class="fa-solid fa-location-dot"></i></span> {{ $get('contact_address', 'Bucu, Kec. Kembang, Kabupaten Jepara, Jawa Tengah 59454') }}</li>
                <li class="flex items-center gap-3"><span class="text-lg w-6 text-center text-[#7a4b2b]"><i class="fa-solid fa-phone"></i></span> {{ $get('contact_phone', '+62 813-9233-5843') }}</li>
                <li class="flex items-center gap-3"><span class="text-lg w-6 text-center text-[#7a4b2b]"><i class="fa-solid fa-envelope"></i></span> {{ $get('contact_email', 'hello@aziziscake.id') }}</li>
                <li class="flex items-center gap-3"><span class="text-lg w-6 text-center text-[#7a4b2b]"><i class="fa-regular fa-clock"></i></span> {{ $get('contact_hours', 'Buka setiap hari 06.00 – 19.00') }}</li>
                <li class="flex items-center gap-3"><span class="text-lg w-6 text-center text-[#7a4b2b]"><i class="fa-solid fa-truck"></i></span> {{ $get('contact_note', 'Gratis ongkir min. Rp 150.000') }}</li>
            </ul>
        </div>
        <div class="md:w-3/5">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">NAMA LENGKAP</label>
                    <input type="text" id="order_name" placeholder="Contoh: Budi Santoso"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b] bg-[#faf8f5]">
                </div>
                <div>
                    <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">NO. WHATSAPP</label>
                    <input type="tel" id="order_phone" placeholder="08xx xxxx xxxx"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b] bg-[#faf8f5]">
                </div>
            </div>
            <div class="mb-4">
                <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">PRODUK YANG DIPESAN</label>
                <select id="order_product" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b] bg-[#faf8f5]">
                    <option value="">Pilih produk...</option>
                    @foreach($featuredProducts as $p)
                    <option>{{ $p->name }} – Rp {{ number_format($p->effective_price, 0, ',', '.') }}</option>
                    @endforeach
                    <option>Lainnya / Konsultasi</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">JUMLAH</label>
                    <input type="number" id="order_qty" placeholder="1" min="1"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b] bg-[#faf8f5]">
                </div>
                <div>
                    <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">TANGGAL DIBUTUHKAN</label>
                    <input type="date" id="order_date"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b] bg-[#faf8f5]">
                </div>
            </div>
            <div class="mb-5">
                <label class="text-xs text-gray-400 tracking-wider mb-1.5 block">CATATAN / PERMINTAAN KHUSUS</label>
                <textarea id="order_notes" placeholder="Misalnya: tanpa gluten, desain kue, alamat pengiriman..."
                          class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#7a4b2b] bg-[#faf8f5] min-h-[100px] resize-y"></textarea>
            </div>
            <button onclick="handleOrder()" class="w-full bg-[#7a4b2b] text-white py-4 rounded-full font-medium hover:bg-[#5a3825] hover:-translate-y-0.5 hover:shadow-lg transition-all">
                Kirim Pesanan via WhatsApp <i class="fa-brands fa-whatsapp ml-2"></i>
            </button>
        </div>
    </div>
</section>

{{-- LOCATION --}}
<section class="bg-white py-16 px-6 border-t border-gray-100" id="lokasi">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-10">
            <div class="text-xs tracking-widest text-[#7a4b2b] uppercase mb-2">— Temukan Kami —</div>
            <h2 class="playfair text-4xl text-[#4b2e1e]">Lokasi Aziziscake</h2>
            <p class="text-gray-400 text-sm mt-2">Kunjungi kami langsung atau klik untuk navigasi via Google Maps</p>
        </div>
        <div class="flex justify-center">
            <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-lg max-w-md w-full hover:-translate-y-1 hover:shadow-xl transition-all">
                <div class="relative h-48 overflow-hidden">
                    <img src="https://lh3.googleusercontent.com/places/ANXAkqEwdCFzII7zLl3xyetzHn1sFTEwxHtuejIvIQhW-e60FRIWbU6JabkNqDEoP_Y2bh5lMto5o_QFeCkwcEscsaUUHx0wlbAJpAk=s4800-w800-h600"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" alt="Azizi Cake">
                    <div class="absolute top-3 right-3 bg-white/92 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium text-[#4b2e1e]"><i class="fa-solid fa-star text-yellow-500 mr-1"></i> 4.0 · Aziziscake</div>
                </div>
                <div class="p-5">
                    <h3 class="font-semibold text-[#4b2e1e]">Azizi Cake Bakery – Jepara</h3>
                    <p class="text-xs text-gray-400 mt-1 leading-relaxed">📍 RT.5/RW.5, Bucu, Kec. Kembang, Kabupaten Jepara, Jawa Tengah 59454</p>
                    <div class="flex flex-wrap gap-2 mt-3 mb-4">
                        <span class="bg-[#fef3ec] text-[#7a4b2b] text-xs px-2.5 py-1 rounded-full"><i class="fa-regular fa-clock mr-1"></i> Buka 06.00–19.00</span>
                        <span class="bg-[#fef3ec] text-[#7a4b2b] text-xs px-2.5 py-1 rounded-full"><i class="fa-solid fa-cake-candles mr-1"></i> Cake & Bakery</span>
                    </div>
                        <a href="https://maps.google.com/?cid=16829235595524921551" target="_blank"
                           class="block w-full bg-[#7a4b2b] text-white text-sm py-2.5 rounded-xl text-center hover:bg-[#5a3825] transition-colors">
                            <i class="fa-solid fa-map-location-dot mr-1"></i> Buka Maps
                        </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function handleOrder() {
    const name = document.getElementById('order_name').value.trim();
    const phone = document.getElementById('order_phone').value.trim();
    const product = document.getElementById('order_product').value;
    const qty = document.getElementById('order_qty').value || '1';
    const date = document.getElementById('order_date').value;
    const notes = document.getElementById('order_notes').value;

    if (!name || !phone || !product) {
        alert('Mohon lengkapi nama, nomor WhatsApp, dan produk yang dipesan.');
        return;
    }

    let msg = `Halo Aziziscake! Saya ${name} ingin pesan:\n\nProduk: ${product}\nJumlah: ${qty}`;
    if (date) msg += `\nTanggal dibutuhkan: ${date}`;
    if (notes) msg += `\nCatatan: ${notes}`;
    msg += `\n\nNo. WA: ${phone}\n\nMohon konfirmasi ketersediaan ya! 😊`;

    window.open('{{ $get('social_whatsapp', 'https://wa.me/6281392335843') }}?text=' + encodeURIComponent(msg), '_blank');
}
</script>
@endpush
