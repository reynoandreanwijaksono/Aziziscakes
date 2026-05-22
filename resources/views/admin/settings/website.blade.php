@extends('layouts.admin')

@section('title', 'Website Content')
@section('subtitle', 'Sunting semua bagian halaman utama dan footer website')

@section('content')
<div x-data="{ activeSection: 'hero' }" class="grid gap-6 lg:grid-cols-[260px_1fr]">
    <aside class="hidden lg:block sticky top-6 self-start overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
        <div class="px-6 py-5 border-b border-gray-100">
            <p class="text-xs uppercase tracking-[0.24em] text-gray-500 font-semibold">Pengaturan Website</p>
            <h2 class="mt-3 text-lg font-semibold text-gray-900">Konten Beranda</h2>
        </div>
        <nav class="space-y-4 px-4 py-5 text-sm text-gray-600">
            <div>
                <p class="mb-3 text-xs uppercase tracking-[0.18em] text-gray-400">Beranda</p>
                <ul class="space-y-2">
                    <li>
                        <a href="#hero-section" @click.prevent="activeSection='hero'; window.location.hash='hero-section'"
                            :class="activeSection === 'hero' ? 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors bg-[#7a4b2b] text-white' : 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors text-gray-600 hover:bg-gray-100'">Bagian Hero</a>
                    </li>
                    <li>
                        <a href="#why-section" @click.prevent="activeSection='why'; window.location.hash='why-section'"
                            :class="activeSection === 'why' ? 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors bg-[#7a4b2b] text-white' : 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors text-gray-600 hover:bg-gray-100'">Kenapa Memilih Kami</a>
                    </li>
                    <li>
                        <a href="#about-section" @click.prevent="activeSection='about'; window.location.hash='about-section'"
                            :class="activeSection === 'about' ? 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors bg-[#7a4b2b] text-white' : 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors text-gray-600 hover:bg-gray-100'">Bagian About</a>
                    </li>
                    <li>
                        <a href="#testimonials-section" @click.prevent="activeSection='testimonials'; window.location.hash='testimonials-section'"
                            :class="activeSection === 'testimonials' ? 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors bg-[#7a4b2b] text-white' : 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors text-gray-600 hover:bg-gray-100'">Testimoni</a>
                    </li>
                    <li>
                        <a href="#faq-section" @click.prevent="activeSection='faq'; window.location.hash='faq-section'"
                            :class="activeSection === 'faq' ? 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors bg-[#7a4b2b] text-white' : 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors text-gray-600 hover:bg-gray-100'">FAQ</a>
                    </li>
                    <li>
                        <a href="#contact-section" @click.prevent="activeSection='contact'; window.location.hash='contact-section'"
                            :class="activeSection === 'contact' ? 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors bg-[#7a4b2b] text-white' : 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors text-gray-600 hover:bg-gray-100'">Kontak</a>
                    </li>
                    <li>
                        <a href="#social-section" @click.prevent="activeSection='social'; window.location.hash='social-section'"
                            :class="activeSection === 'social' ? 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors bg-[#7a4b2b] text-white' : 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors text-gray-600 hover:bg-gray-100'">Social Media</a>
                    </li>
                    <li>
                        <a href="#footer-section" @click.prevent="activeSection='footer'; window.location.hash='footer-section'"
                            :class="activeSection === 'footer' ? 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors bg-[#7a4b2b] text-white' : 'flex items-center gap-2 rounded-2xl px-3 py-2 transition-colors text-gray-600 hover:bg-gray-100'">Footer & SEO</a>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>

    <div>
        <div class="mb-6 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-gray-500">Pengaturan Website</p>
                    <h1 class="mt-3 text-2xl font-semibold text-gray-900">Website Content</h1>
                    <p class="mt-2 text-sm text-gray-500">Atur semua konten halaman utama, bagian beranda, dan footer dengan cepat.</p>
                </div>
                <div class="flex items-center gap-3 text-sm text-[#7a4b2b]">
                    <span class="hidden sm:inline">Lompat ke:</span>
                    <a href="#hero-section" class="rounded-full border border-[#7a4b2b] px-4 py-2 hover:bg-[#7a4b2b] hover:text-white transition-colors">Hero</a>
                    <a href="#why-section" class="rounded-full border border-gray-200 px-4 py-2 hover:bg-gray-100 transition-colors">Kenapa Memilih Kami</a>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.settings.website.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <section id="general-section" class="scroll-mt-24 bg-white rounded-3xl border border-gray-200 p-6 shadow-sm">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Pengaturan Umum</h2>
                            <p class="mt-1 text-sm text-gray-500">Atur logo utama yang digunakan di website.</p>
                        </div>
                        <span class="rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Umum</span>
                    </div>

                    <div class="mt-6 grid gap-4 lg:grid-cols-2">
                        <label class="block lg:col-span-2">
                            <span class="text-sm text-gray-600">Logo Website</span>
                            <input type="file" name="site_logo" accept="image/*"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                            @if($settings['site_logo'] ?? null)
                            <div class="mt-4 p-4 border border-gray-200 rounded-xl bg-gray-50 w-fit">
                                <p class="text-xs text-gray-500 mb-2">Logo Saat Ini:</p>
                                <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Site Logo" class="h-12 object-contain">
                            </div>
                            @endif
                        </label>
                    </div>
                </section>
                <section id="hero-section" class="scroll-mt-24 bg-white rounded-3xl border border-gray-200 p-6 shadow-sm">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Pengaturan Hero Beranda</h2>
                            <p class="mt-1 text-sm text-gray-500">Atur bagian hero utama di halaman beranda.</p>
                        </div>
                        <span class="rounded-full border border-[#7a4b2b] px-3 py-1 text-xs font-semibold text-[#7a4b2b]">Beranda</span>
                    </div>

                    <div class="mt-6 grid gap-4 lg:grid-cols-2">
                        <label class="block">
                            <span class="text-sm text-gray-600">Teks Badge</span>
                            <input type="text" name="hero_label" value="{{ old('hero_label', $settings['hero_label'] ?? '✦ Resep Rahasia Sejak 1990 ✦') }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        <label class="block">
                            <span class="text-sm text-gray-600">Teks Tombol CTA</span>
                            <input type="text" name="hero_primary_cta_text" value="{{ old('hero_primary_cta_text', $settings['hero_primary_cta_text'] ?? 'Pesan Sekarang') }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        <label class="block">
                            <span class="text-sm text-gray-600">Judul Utama</span>
                            <input type="text" name="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? 'Freshly Baked, Just for You!') }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        <label class="block">
                            <span class="text-sm text-gray-600">Subjudul Aksen (Miring)</span>
                            <input type="text" name="hero_secondary_cta_text" value="{{ old('hero_secondary_cta_text', $settings['hero_secondary_cta_text'] ?? 'Lihat Menu') }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        <label class="block lg:col-span-2">
                            <span class="text-sm text-gray-600">Deskripsi Utama</span>
                            <textarea name="hero_subtitle" rows="4" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? 'Roti dan kue premium dibuat setiap hari dengan bahan-bahan pilihan terbaik tanpa pengawet.') }}</textarea>
                        </label>
                        <label class="block">
                            <span class="text-sm text-gray-600">URL Tombol Utama</span>
                            <input type="text" name="hero_primary_cta_link" value="{{ old('hero_primary_cta_link', $settings['hero_primary_cta_link'] ?? route('products.index')) }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        <label class="block">
                            <span class="text-sm text-gray-600">URL Tombol Sekunder</span>
                            <input type="text" name="hero_secondary_cta_link" value="{{ old('hero_secondary_cta_link', $settings['hero_secondary_cta_link'] ?? route('products.index')) }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        <label class="block">
                            <span class="text-sm text-gray-600">Gambar Latar Hero</span>
                            <input type="text" name="hero_background_image" value="{{ old('hero_background_image', $settings['hero_background_image'] ?? 'https://images.unsplash.com/photo-1608198093002-ad4e005484ec') }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        <label class="block">
                            <span class="text-sm text-gray-600">Gambar Kiri Hero</span>
                            <input type="file" name="hero_image_1" accept="image/*"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                            @if($settings['hero_image_1'] ?? null)
                            <p class="mt-2 text-xs text-gray-500">Current: <a href="{{ asset($settings['hero_image_1']) }}" target="_blank" class="text-[#7a4b2b] underline">View Image</a></p>
                            @endif
                        </label>
                        <label class="block">
                            <span class="text-sm text-gray-600">Gambar Kanan Hero</span>
                            <input type="file" name="hero_image_2" accept="image/*"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                            @if($settings['hero_image_2'] ?? null)
                            <p class="mt-2 text-xs text-gray-500">Current: <a href="{{ asset($settings['hero_image_2']) }}" target="_blank" class="text-[#7a4b2b] underline">View Image</a></p>
                            @endif
                        </label>
                        <label class="block">
                            <span class="text-sm text-gray-600">Badge 1 Judul</span>
                            <input type="text" name="hero_badge_1_title" value="{{ old('hero_badge_1_title', $settings['hero_badge_1_title'] ?? '4.9/5.0') }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        <label class="block">
                            <span class="text-sm text-gray-600">Badge 1 Subjudul</span>
                            <input type="text" name="hero_badge_1_subtitle" value="{{ old('hero_badge_1_subtitle', $settings['hero_badge_1_subtitle'] ?? 'Ulasan Terbaik') }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        <label class="block">
                            <span class="text-sm text-gray-600">Badge 2 Judul</span>
                            <input type="text" name="hero_badge_2_title" value="{{ old('hero_badge_2_title', $settings['hero_badge_2_title'] ?? '100% Halal') }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        <label class="block">
                            <span class="text-sm text-gray-600">Badge 2 Subjudul</span>
                            <input type="text" name="hero_badge_2_subtitle" value="{{ old('hero_badge_2_subtitle', $settings['hero_badge_2_subtitle'] ?? 'Bahan Premium') }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                    </div>
                </section>

                <section id="why-section" class="scroll-mt-24 bg-white rounded-3xl border border-gray-200 p-6 shadow-sm">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Kenapa Memilih Kami</h2>
                            <p class="mt-1 text-sm text-gray-500">Atur konten untuk bagian 'Kenapa Memilih Aziziscake?' di beranda.</p>
                        </div>
                        <span class="rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Why Us</span>
                    </div>
                    <div class="mt-6 grid gap-4 lg:grid-cols-2">
                        <label class="block lg:col-span-2">
                            <span class="text-sm text-gray-600">Judul Utama</span>
                            <input type="text" name="why_title" value="{{ old('why_title', $settings['why_title'] ?? 'Kenapa Memilih Aziziscake?') }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        <label class="block lg:col-span-2">
                            <span class="text-sm text-gray-600">Deskripsi Utama</span>
                            <textarea name="why_description" rows="3" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20">{{ old('why_description', $settings['why_description'] ?? 'Kami berdedikasi memberikan kualitas dan rasa terbaik pada setiap gigitan, menjadikan setiap momen berharga Anda lebih manis dan tak terlupakan.') }}</textarea>
                        </label>
                        
                        <div class="lg:col-span-2 grid gap-4 lg:grid-cols-3 mt-4">
                            {{-- Card 1 --}}
                            <div class="border border-gray-200 rounded-2xl p-4 bg-gray-50">
                                <h3 class="font-medium text-gray-900 mb-3 text-sm">Fitur 1</h3>
                                <label class="block mb-3">
                                    <span class="text-xs text-gray-600">Judul Fitur</span>
                                    <input type="text" name="why_card_1_title" value="{{ old('why_card_1_title', $settings['why_card_1_title'] ?? 'Kualitas Premium') }}"
                                        class="mt-1 w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                                </label>
                                <label class="block">
                                    <span class="text-xs text-gray-600">Deskripsi Fitur</span>
                                    <textarea name="why_card_1_desc" rows="3" class="mt-1 w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20">{{ old('why_card_1_desc', $settings['why_card_1_desc'] ?? 'Dibuat menggunakan bahan-bahan pilihan berkualitas tinggi untuk menghasilkan rasa yang mewah dan lezat.') }}</textarea>
                                </label>
                            </div>
                            
                            {{-- Card 2 --}}
                            <div class="border border-gray-200 rounded-2xl p-4 bg-gray-50">
                                <h3 class="font-medium text-gray-900 mb-3 text-sm">Fitur 2</h3>
                                <label class="block mb-3">
                                    <span class="text-xs text-gray-600">Judul Fitur</span>
                                    <input type="text" name="why_card_2_title" value="{{ old('why_card_2_title', $settings['why_card_2_title'] ?? '100% Halal & Tanpa Pengawet') }}"
                                        class="mt-1 w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                                </label>
                                <label class="block">
                                    <span class="text-xs text-gray-600">Deskripsi Fitur</span>
                                    <textarea name="why_card_2_desc" rows="3" class="mt-1 w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20">{{ old('why_card_2_desc', $settings['why_card_2_desc'] ?? 'Produk kami dibuat segar setiap hari tanpa bahan pengawet buatan, sehingga aman dan sehat untuk keluarga.') }}</textarea>
                                </label>
                            </div>
                            
                            {{-- Card 3 --}}
                            <div class="border border-gray-200 rounded-2xl p-4 bg-gray-50">
                                <h3 class="font-medium text-gray-900 mb-3 text-sm">Fitur 3</h3>
                                <label class="block mb-3">
                                    <span class="text-xs text-gray-600">Judul Fitur</span>
                                    <input type="text" name="why_card_3_title" value="{{ old('why_card_3_title', $settings['why_card_3_title'] ?? 'Dibuat Penuh Cinta') }}"
                                        class="mt-1 w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                                </label>
                                <label class="block">
                                    <span class="text-xs text-gray-600">Deskripsi Fitur</span>
                                    <textarea name="why_card_3_desc" rows="3" class="mt-1 w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20">{{ old('why_card_3_desc', $settings['why_card_3_desc'] ?? 'Setiap kue dan roti diolah oleh baker berpengalaman dengan resep andalan yang dijaga konsistensi cita rasanya.') }}</textarea>
                                </label>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="gallery-section" class="scroll-mt-24 bg-white rounded-3xl border border-gray-200 p-6 shadow-sm">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Galeri Kami</h2>
                            <p class="mt-1 text-sm text-gray-500">Unggah foto-foto untuk bagian Galeri Kami.</p>
                        </div>
                        <span class="rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Gallery</span>
                    </div>

                    <div class="mt-6 grid gap-4 lg:grid-cols-2">
                        @for($i = 1; $i <= 5; $i++)
                        <div class="border border-gray-100 rounded-2xl p-4 bg-gray-50">
                            <h3 class="font-medium text-gray-900 mb-3">Foto {{ $i }}</h3>
                            <label class="block mb-3">
                                <span class="text-sm text-gray-600">Judul/Label Foto</span>
                                <input type="text" name="gallery_img_{{ $i }}_title" value="{{ old('gallery_img_'.$i.'_title', $settings['gallery_img_'.$i.'_title'] ?? ['Dapur Kami','Brownies','Kue Kering','Custom Cake','Birthday Cake'][$i-1]) }}" class="mt-1 w-full rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                            </label>
                            <label class="block">
                                <span class="text-sm text-gray-600">Unggah Gambar</span>
                                <input type="file" name="gallery_img_{{ $i }}" accept="image/*" class="mt-1 w-full rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                                @if(isset($settings['gallery_img_'.$i]))
                                    <img src="{{ asset('storage/' . $settings['gallery_img_'.$i]) }}" alt="Gallery Image {{ $i }}" class="h-16 mt-2 rounded-lg object-cover">
                                @endif
                            </label>
                        </div>
                        @endfor
                    </div>
                </section>

                <section id="about-section" class="scroll-mt-24 bg-white rounded-3xl border border-gray-200 p-6 shadow-sm">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">About Section</h2>
                            <p class="mt-1 text-sm text-gray-500">Kontrol teks dan gambar bagian tentang kami.</p>
                        </div>
                        <span class="rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">About</span>
                    </div>
                    <div class="mt-6 grid gap-4 lg:grid-cols-2">
                        <label class="block">
                            <span class="text-sm text-gray-600">Label About</span>
                            <input type="text" name="about_label" value="{{ old('about_label', $settings['about_label'] ?? '— Kisah Kami —') }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        <label class="block">
                            <span class="text-sm text-gray-600">Judul About</span>
                            <input type="text" name="about_title" value="{{ old('about_title', $settings['about_title'] ?? 'Tentang Aziziscake') }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        <label class="block lg:col-span-2">
                            <span class="text-sm text-gray-600">Paragraf 1</span>
                            <textarea name="about_paragraph_1" rows="3" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20">{{ old('about_paragraph_1', $settings['about_paragraph_1'] ?? 'Sejak lama, Aziziscake telah menghadirkan kelezatan kue dan roti berkualitas di jantung Jepara, Jawa Tengah — menggunakan resep keluarga yang penuh cinta dan diwariskan dengan bangga.') }}</textarea>
                        </label>
                        <label class="block lg:col-span-2">
                            <span class="text-sm text-gray-600">Paragraf 2</span>
                            <textarea name="about_paragraph_2" rows="3" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20">{{ old('about_paragraph_2', $settings['about_paragraph_2'] ?? 'Setiap produk kami dibuat fresh setiap hari menggunakan bahan premium pilihan tanpa pengawet sama sekali. Karena kami percaya, makanan terbaik adalah makanan yang jujur.') }}</textarea>
                        </label>
                        <label class="block lg:col-span-2">
                            <span class="text-sm text-gray-600">Gambar About</span>
                            <input type="text" name="about_image" value="{{ old('about_image', $settings['about_image'] ?? 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=700') }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        @for($i = 1; $i <= 4; $i++)
                            <label class="block">
                            <span class="text-sm text-gray-600">Feature {{ $i }} Title</span>
                            <input type="text" name="about_feature_{{ $i }}_title" value="{{ old('about_feature_'.$i.'_title', $settings['about_feature_'.$i.'_title'] ?? ['Bahan Lokal','Tanpa Pengawet','Cepat','Pengiriman'][$i-1]) }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                            </label>
                            <label class="block">
                                <span class="text-sm text-gray-600">Feature {{ $i }} Text</span>
                                <input type="text" name="about_feature_{{ $i }}_text" value="{{ old('about_feature_'.$i.'_text', $settings['about_feature_'.$i.'_text'] ?? ['Tepung & bahan pilihan premium','100% alami, sehat & segar','Dipanggang setiap pagi pukul 5','Pengiriman dalam 2 jam'][$i-1]) }}"
                                    class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                            </label>
                            @endfor
                    </div>
                </section>

                <section id="testimonials-section" class="scroll-mt-24 bg-white rounded-3xl border border-gray-200 p-6 shadow-sm">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Testimoni</h2>
                            <p class="mt-1 text-sm text-gray-500">Atur detail testimonial pelanggan di halaman utama.</p>
                        </div>
                        <span class="rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Testimoni</span>
                    </div>
                    <div class="mt-6 grid gap-4">
                        @for($i = 1; $i <= 3; $i++)
                            <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <label class="block">
                                    <span class="text-sm text-gray-600">Inisial #{{ $i }}</span>
                                    <input type="text" name="testimonial_{{ $i }}_initial" value="{{ old('testimonial_'.$i.'_initial', $settings['testimonial_'.$i.'_initial'] ?? ['SR','BW','AD'][$i-1]) }}"
                                        class="mt-1 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                                </label>
                                <label class="block">
                                    <span class="text-sm text-gray-600">Nama #{{ $i }}</span>
                                    <input type="text" name="testimonial_{{ $i }}_name" value="{{ old('testimonial_'.$i.'_name', $settings['testimonial_'.$i.'_name'] ?? ['Sari Rahayu','Budi Widodo','Ayu Dianty'][$i-1]) }}"
                                        class="mt-1 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                                </label>
                                <label class="block sm:col-span-2">
                                    <span class="text-sm text-gray-600">Role / Subtitle #{{ $i }}</span>
                                    <input type="text" name="testimonial_{{ $i }}_role" value="{{ old('testimonial_'.$i.'_role', $settings['testimonial_'.$i.'_role'] ?? ['Pelanggan Setia · Jepara','Pelanggan Baru · Kudus','Pelanggan Setia · Jepara'][$i-1]) }}"
                                        class="mt-1 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                                </label>
                                <label class="block sm:col-span-2">
                                    <span class="text-sm text-gray-600">Pesan #{{ $i }}</span>
                                    <textarea name="testimonial_{{ $i }}_text" rows="3" class="mt-1 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20">{{ old('testimonial_'.$i.'_text', $settings['testimonial_'.$i.'_text'] ?? ['Kuenya benar-benar luar biasa! Teksturnya lembut, rasanya pas di lidah, dan aromanya menggoda banget. Sudah langganan lama dan nggak pernah kecewa sama Aziziscake!','Custom cake untuk ulang tahun anak saya benar-benar membuat semua tamu terkejut! Desainnya persis seperti yang diminta, dan rasanya lebih enak dari tampilannya.','Cinnamon roll-nya meleleh di mulut! Harganya pun sangat terjangkau untuk kualitas sebagus ini. Pengirimannya juga cepat dan roti sampai masih hangat.'][$i-1]) }}</textarea>
                                </label>
                            </div>
                    </div>
                    @endfor
            </div>
            </section>

            <section id="faq-section" class="scroll-mt-24 bg-white rounded-3xl border border-gray-200 p-6 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">FAQ</h2>
                        <p class="mt-1 text-sm text-gray-500">Atur pertanyaan umum dan jawaban yang tampil di beranda.</p>
                    </div>
                    <span class="rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">FAQ</span>
                </div>
                <div class="mt-6 grid gap-4">
                    @for($i = 1; $i <= 5; $i++)
                        <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4">
                        <label class="block mb-3">
                            <span class="text-sm text-gray-600">Pertanyaan #{{ $i }}</span>
                            <input type="text" name="faq_{{ $i }}_question" value="{{ old('faq_'.$i.'_question', $settings['faq_'.$i.'_question'] ?? ['Apakah produk bisa dipesan dalam jumlah banyak (bulk order)?','Berapa lama ketahanan produk setelah dibeli?','Apakah tersedia opsi vegan atau bebas gluten?','Bagaimana cara memesan custom cake?','Apakah ada layanan pengiriman ke luar kota?'][$i-1]) }}"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
                        </label>
                        <label class="block">
                            <span class="text-sm text-gray-600">Jawaban #{{ $i }}</span>
                            <textarea name="faq_{{ $i }}_answer" rows="3" class="mt-1 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20">{{ old('faq_'.$i.'_answer', $settings['faq_'.$i.'_answer'] ?? ['Ya, kami menerima bulk order untuk berbagai keperluan seperti acara, arisan, atau corporate gift. Hubungi kami minimal 3 hari sebelum tanggal pengiriman untuk pemesanan lebih dari 50 pcs.','Roti dan pastry kami bertahan 2–3 hari pada suhu ruang, dan hingga 7 hari jika disimpan dalam kulkas. Custom cake lebih baik dikonsumsi dalam 2 hari.','Saat ini kami memiliki pilihan vegan untuk beberapa produk pastry dan kue. Untuk opsi bebas gluten, tersedia berdasarkan permintaan khusus dengan lead time 2 hari.','Pemesanan custom cake bisa melalui WhatsApp atau langsung di website. Sertakan detail desain, ukuran, rasa, dan tanggal dibutuhkan. Kami memerlukan minimal 5 hari kerja.','Saat ini layanan pengiriman kami mencakup area Jepara, Kudus, Pati, dan sekitarnya.'][$i-1]) }}</textarea>
                        </label>
                </div>
                @endfor
    </div>
    </section>

    <section id="contact-section" class="scroll-mt-24 bg-white rounded-3xl border border-gray-200 p-6 shadow-sm">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Kontak</h2>
                <p class="mt-1 text-sm text-gray-500">Ubah informasi kontak yang ditampilkan di footer dan halaman kontak.</p>
            </div>
            <span class="rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Kontak</span>
        </div>
        <div class="mt-6 grid gap-4 lg:grid-cols-2">
            <label class="block">
                <span class="text-sm text-gray-600">Label Kontak</span>
                <input type="text" name="contact_label" value="{{ old('contact_label', $settings['contact_label'] ?? '— Hubungi Kami —') }}"
                    class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
            </label>
            <label class="block">
                <span class="text-sm text-gray-600">Judul Kontak</span>
                <input type="text" name="contact_title" value="{{ old('contact_title', $settings['contact_title'] ?? 'Pesan Sekarang') }}"
                    class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
            </label>
            <label class="block lg:col-span-2">
                <span class="text-sm text-gray-600">Deskripsi Kontak</span>
                <textarea name="contact_description" rows="3" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20">{{ old('contact_description', $settings['contact_description'] ?? 'Isi form di samping atau hubungi kami langsung melalui WhatsApp. Kami siap membantu dari pukul 06.00 – 19.00 setiap hari.') }}</textarea>
            </label>
            <label class="block">
                <span class="text-sm text-gray-600">Alamat</span>
                <input type="text" name="contact_address" value="{{ old('contact_address', $settings['contact_address'] ?? 'Bucu, Kec. Kembang, Kabupaten Jepara, Jawa Tengah 59454') }}"
                    class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
            </label>
            <label class="block">
                <span class="text-sm text-gray-600">Nomor Telepon</span>
                <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '+62 813-9233-5843') }}"
                    class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
            </label>
            <label class="block">
                <span class="text-sm text-gray-600">Email</span>
                <input type="text" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? 'hello@aziziscake.id') }}"
                    class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
            </label>
            <label class="block">
                <span class="text-sm text-gray-600">Jam Buka</span>
                <input type="text" name="contact_hours" value="{{ old('contact_hours', $settings['contact_hours'] ?? 'Buka setiap hari 06.00 – 19.00') }}"
                    class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
            </label>
            <label class="block lg:col-span-2">
                <span class="text-sm text-gray-600">Catatan Kontak</span>
                <input type="text" name="contact_note" value="{{ old('contact_note', $settings['contact_note'] ?? 'Gratis ongkir min. Rp 150.000') }}"
                    class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
            </label>
        </div>
    </section>

    <section id="social-section" class="scroll-mt-24 bg-white rounded-3xl border border-gray-200 p-6 shadow-sm">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Social Media</h2>
                <p class="mt-1 text-sm text-gray-500">Kelola tautan jejaring sosial yang ditampilkan di footer.</p>
            </div>
            <span class="rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Social Media</span>
        </div>
        <div class="mt-6 grid gap-4 lg:grid-cols-2">
            <label class="block">
                <span class="text-sm text-gray-600">WhatsApp Link</span>
                <input type="text" name="social_whatsapp" value="{{ old('social_whatsapp', $settings['social_whatsapp'] ?? 'https://wa.me/6281392335843') }}"
                    class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
            </label>
            <label class="block">
                <span class="text-sm text-gray-600">Instagram Link</span>
                <input type="text" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? '#') }}"
                    class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
            </label>
            <label class="block">
                <span class="text-sm text-gray-600">Facebook Link</span>
                <input type="text" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? '#') }}"
                    class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
            </label>
            <label class="block">
                <span class="text-sm text-gray-600">TikTok Link</span>
                <input type="text" name="social_tiktok" value="{{ old('social_tiktok', $settings['social_tiktok'] ?? '#') }}"
                    class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
            </label>
        </div>
    </section>

    <section id="footer-section" class="scroll-mt-24 bg-white rounded-3xl border border-gray-200 p-6 shadow-sm">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Footer & SEO</h2>
                <p class="mt-1 text-sm text-gray-500">Atur teks footer dan metadata SEO utama.</p>
            </div>
            <span class="rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Footer</span>
        </div>
        <div class="mt-6 grid gap-4 lg:grid-cols-2">
            <label class="block lg:col-span-2">
                <span class="text-sm text-gray-600">Teks Footer</span>
                <textarea name="footer_text" rows="2" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20">{{ old('footer_text', $settings['footer_text'] ?? 'Menghadirkan kelezatan kue dan roti premium dengan resep keluarga dari Jepara, Jawa Tengah.') }}</textarea>
            </label>
            <label class="block lg:col-span-2">
                <span class="text-sm text-gray-600">SEO Title</span>
                <input type="text" name="seo_title" value="{{ old('seo_title', $settings['seo_title'] ?? 'Aziziscake – Toko Kue Premium Jepara') }}"
                    class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
            </label>
            <label class="block lg:col-span-2">
                <span class="text-sm text-gray-600">SEO Description</span>
                <textarea name="seo_description" rows="3" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20">{{ old('seo_description', $settings['seo_description'] ?? 'Aziziscake menyediakan kue dan roti premium dengan bahan pilihan, custom cake, dan layanan pesan antar cepat di Jepara.') }}</textarea>
            </label>
            <label class="block lg:col-span-2">
                <span class="text-sm text-gray-600">SEO Keywords</span>
                <input type="text" name="seo_keywords" value="{{ old('seo_keywords', $settings['seo_keywords'] ?? 'kue premium, bakery Jepara, custom cake, roti artisan, pastry') }}"
                    class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-[#7a4b2b] focus:ring-[#7a4b2b]/20" />
            </label>
        </div>
    </section>

    <div class="flex justify-end">
        <button type="submit" class="rounded-full bg-[#7a4b2b] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#5a3825]">Simpan Konten Website</button>
    </div>
</div>
</form>
</div>
</div>
@endsection