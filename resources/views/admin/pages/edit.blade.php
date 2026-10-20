@extends('layouts.admin')

@section('title', 'Edit Section: ' . $section->section_name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.pages.index', ['page' => $section->page_slug]) }}" class="hover:text-gray-700 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                    <span>Kembali ke Halaman {{ $pages[$section->page_slug] ?? $section->page_slug }}</span>
                </a>
            </div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Edit Konten: {{ $section->section_name }}</h1>
            <p class="text-xs text-gray-500 mt-0.5">Halaman: <span class="font-semibold text-gray-700">{{ $pages[$section->page_slug] ?? $section->page_slug }}</span> | Key: <code class="bg-gray-100 px-1 py-0.5 rounded text-[11px] text-[#1F2B45]">{{ $section->section_key }}</code></p>
        </div>
    </div>

    @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs space-y-1">
            <div class="font-bold flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">error</span>
                <span>Terjadi kesalahan pada formulir:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-rose-700 pl-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('admin.pages.update', $section) }}" method="POST" enctype="multipart/form-data" 
          x-data="{ 
              items: {{ json_encode($section->items ?? []) }},
              addItem() {
                  this.items.push({ icon: 'verified', title: '', desc: '', stat: '', label: '' });
              },
              removeItem(index) {
                  this.items.splice(index, 1);
              }
          }" 
          class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm space-y-5">
            <h2 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-[#1F2B45]">edit_note</span>
                <span>Informasi &amp; Teks Utama Section</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-700 mb-1" for="title">
                        Judul Utama (Title / Headline)
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $section->title) }}"
                           placeholder="cth. Menghidupkan Ruang Belajar Nyata..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45] focus:border-[#1F2B45]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1" for="badge">
                        Label / Badge Kecil
                    </label>
                    <input type="text" name="badge" id="badge" value="{{ old('badge', $section->badge) }}"
                           placeholder="cth. Arsip Lapangan No. 042"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45] focus:border-[#1F2B45]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1" for="subtitle">
                    Sub-judul / Lead Paragraph (Subtitle)
                </label>
                <textarea name="subtitle" id="subtitle" rows="3"
                          placeholder="Penjelasan ringkas atau pengantar section..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45] focus:border-[#1F2B45]">{{ old('subtitle', $section->subtitle) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1" for="content">
                    Narasi Panjang / Paragraf Konten Lengkap
                </label>
                <textarea name="content" id="content" rows="6"
                          placeholder="Teks naratif lengkap (opsional, jika section memiliki deskripsi cerita panjang)..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45] focus:border-[#1F2B45] font-mono leading-relaxed">{{ old('content', $section->content) }}</textarea>
                <span class="block text-[11px] text-gray-400 mt-1">Gunakan pemisah baris/enter untuk membagi paragraf.</span>
            </div>
        </div>

        {{-- Foto / Media Section --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm space-y-5">
            <h2 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-[#1F2B45]">image</span>
                <span>Foto &amp; Media Visual Section</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-5 items-start">
                <div class="md:col-span-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Foto Saat Ini</label>
                    @if($section->image)
                        <div class="relative w-full aspect-video rounded-lg overflow-hidden border border-gray-200 bg-gray-50 shadow-sm">
                            <img src="{{ $section->image_url }}" alt="Preview" class="w-full h-full object-cover">
                        </div>
                        <span class="block text-[11px] text-gray-400 mt-1.5 truncate">{{ $section->image }}</span>
                    @else
                        <div class="w-full aspect-video rounded-lg border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 bg-gray-50 text-xs">
                            <span class="material-symbols-outlined text-3xl mb-1">image_not_supported</span>
                            <span>Tidak ada foto</span>
                        </div>
                    @endif
                </div>

                <div class="md:col-span-8 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1" for="image_file">
                            Unggah Foto Baru (JPG, PNG, WEBP, Maks. 5MB)
                        </label>
                        <input type="file" name="image_file" id="image_file" accept="image/*"
                               class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-xs file:mr-3 file:py-1 file:px-3 file:rounded-2xl file:border-0 file:text-xs file:font-semibold file:bg-[#1F2B45]/10 file:text-[#1F2B45] hover:file:bg-[#1F2B45]/20">
                        <span class="block text-[11px] text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti foto saat ini.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1" for="image_caption">
                            Keterangan Foto (Caption / Arsip Lapangan)
                        </label>
                        <input type="text" name="image_caption" id="image_caption" value="{{ old('image_caption', $section->image_caption) }}"
                               placeholder="cth. Tapak Studi Etnobotani Pewarnaan Alami, Sanggar Tarum..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45] focus:border-[#1F2B45]">
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi (CTA) --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm space-y-5">
            <h2 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-[#1F2B45]">touch_app</span>
                <span>Tombol Aksi (Call To Action / Link)</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Tombol Utama --}}
                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200/80 space-y-3">
                    <span class="block text-xs font-bold text-gray-800">Tombol Utama</span>
                    <div>
                        <label class="block text-[11px] font-medium text-gray-600 mb-1">Teks Tombol</label>
                        <input type="text" name="button_text" value="{{ old('button_text', $section->button_text) }}"
                               placeholder="cth. Jelajahi Destinasi"
                               class="w-full px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-gray-600 mb-1">Tautan / URL (href)</label>
                        <input type="text" name="button_link" value="{{ old('button_link', $section->button_link) }}"
                               placeholder="cth. /destinasi atau https://..."
                               class="w-full px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45]">
                    </div>
                </div>

                {{-- Tombol Sekunder --}}
                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200/80 space-y-3">
                    <span class="block text-xs font-bold text-gray-800">Tombol Sekunder (Opsional)</span>
                    <div>
                        <label class="block text-[11px] font-medium text-gray-600 mb-1">Teks Tombol Sekunder</label>
                        <input type="text" name="secondary_button_text" value="{{ old('secondary_button_text', $section->secondary_button_text) }}"
                               placeholder="cth. Unduh Silabus"
                               class="w-full px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-gray-600 mb-1">Tautan / URL Sekunder</label>
                        <input type="text" name="secondary_button_link" value="{{ old('secondary_button_link', $section->secondary_button_link) }}"
                               placeholder="cth. /untuk-sekolah"
                               class="w-full px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45]">
                    </div>
                </div>
            </div>
        </div>

        {{-- Dynamic Items Repeater (Untuk Micro Metrics, 4 Pilar, Alur Langkah, dll) --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm space-y-5" x-show="items.length > 0 || {{ !empty($section->items) ? 'true' : 'false' }}">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h2 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-[#1F2B45]">list_alt</span>
                    <span>Daftar Poin / Kartu / Langkah Khusus (Items)</span>
                </h2>
                <button type="button" @click="addItem()" class="inline-flex items-center gap-1 text-xs font-semibold text-[#1F2B45] hover:text-[#16203A]">
                    <span class="material-symbols-outlined text-[16px]">add_circle</span>
                    <span>Tambah Poin</span>
                </button>
            </div>

            <p class="text-xs text-gray-500">Bagian ini digunakan untuk section dengan banyak kartu seperti 4 Pilar Nilai, 3 Metrik Manifesto, Alur Kemitraan, atau Fasilitas Riset.</p>

            <div class="space-y-4">
                <template x-for="(item, index) in items" :key="index">
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl space-y-3 relative group">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-gray-700" x-text="'Item #' + (index + 1)"></span>
                            <button type="button" @click="removeItem(index)" class="text-rose-500 hover:text-rose-700 text-xs flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                                <span>Hapus</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div x-show="item.stat !== undefined">
                                <label class="block text-[11px] font-medium text-gray-600 mb-1">Angka / Metrik (Stat)</label>
                                <input type="text" :name="'items[' + index + '][stat]'" x-model="item.stat"
                                       class="w-full px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs">
                            </div>
                            <div x-show="item.step !== undefined">
                                <label class="block text-[11px] font-medium text-gray-600 mb-1">Nomor Langkah (Step)</label>
                                <input type="text" :name="'items[' + index + '][step]'" x-model="item.step"
                                       class="w-full px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs">
                            </div>
                            <div x-show="item.icon !== undefined">
                                <label class="block text-[11px] font-medium text-gray-600 mb-1">Nama Icon (Material Symbols)</label>
                                <input type="text" :name="'items[' + index + '][icon]'" x-model="item.icon"
                                       placeholder="verified, handshake, nature, etc"
                                       class="w-full px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs">
                            </div>
                            <div :class="(item.stat !== undefined || item.step !== undefined || item.icon !== undefined) ? 'md:col-span-2' : 'md:col-span-3'">
                                <label class="block text-[11px] font-medium text-gray-600 mb-1">Judul / Label Poin</label>
                                <input type="text" :name="'items[' + index + '][title]'" x-model="item.title"
                                       class="w-full px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-medium text-gray-600 mb-1">Deskripsi Penjelasan Poin</label>
                            <textarea :name="'items[' + index + '][desc]'" x-model="item.desc" rows="2"
                                      class="w-full px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs"></textarea>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Status & Aksi Simpan --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $section->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-[#1F2B45] border-gray-300 rounded focus:ring-[#1F2B45]">
                <span class="text-xs font-semibold text-gray-700">Tampilkan Section Ini di Halaman Publik</span>
            </label>

            <div class="flex items-center gap-2.5 w-full sm:w-auto">
                <a href="{{ route('admin.pages.index', ['page' => $section->page_slug]) }}" 
                   class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 text-center transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="w-full sm:w-auto px-5 py-2 bg-[#1F2B45] hover:bg-[#16203A] text-white rounded-2xl text-xs font-bold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">save</span>
                    <span>Simpan Perubahan Section</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
