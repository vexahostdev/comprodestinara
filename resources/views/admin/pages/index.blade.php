@extends('layouts.admin')

@section('title', 'Kelola Konten Halaman & Section')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Manajemen Konten Halaman &amp; Section</h1>
            <p class="text-xs text-gray-500 mt-0.5">Kelola teks judul, narasi, foto banner, tombol, dan susunan section di seluruh halaman publik Destinara.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route($activePage === 'home' ? 'home' : ($activePage === 'about' ? 'about' : ($activePage === 'contact' ? 'contact.index' : ($activePage === 'for-schools' ? 'for-schools' : ($activePage === 'for-researchers' ? 'for-researchers' : 'for-villages'))))) }}" 
               target="_blank" 
               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-2xl hover:bg-gray-50 transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[16px]">visibility</span>
                <span>Lihat Halaman Ini</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-center gap-2 shadow-sm">
            <span class="material-symbols-outlined text-emerald-600 text-sm">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Tabs Navigasi Halaman --}}
    <div class="bg-white rounded-xl p-1.5 border border-gray-200 shadow-sm">
        <div class="flex flex-wrap items-center gap-1">
            @foreach($pages as $slug => $label)
                @php $isActive = $activePage === $slug; @endphp
                <a href="{{ route('admin.pages.index', ['page' => $slug]) }}"
                   class="px-3.5 py-2 rounded-lg text-xs font-medium transition-all inline-flex items-center gap-1.5
                          {{ $isActive ? 'bg-[#1F2B45] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <span class="material-symbols-outlined text-[16px]">
                        @if($slug === 'home') home
                        @elseif($slug === 'about') auto_stories
                        @elseif($slug === 'for-schools') school
                        @elseif($slug === 'for-researchers') science
                        @elseif($slug === 'for-villages') agriculture
                        @else contact_support @endif
                    </span>
                    <span>{{ $label }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Daftar Section pada Halaman Aktif --}}
    <div class="grid grid-cols-1 gap-4">
        @forelse($sections as $section)
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:border-[#1F2B45]/40 transition-all flex flex-col md:flex-row gap-5 items-start justify-between">
                {{-- Info Section --}}
                <div class="flex-1 space-y-2.5">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-700">
                            Urutan: {{ $section->order }}
                        </span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-[#1F2B45]/10 text-[#1F2B45]">
                            KEY: {{ $section->section_key }}
                        </span>
                        @if($section->badge)
                            <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-amber-50 text-amber-800 border border-amber-200">
                                {{ $section->badge }}
                            </span>
                        @endif
                        @if($section->is_active)
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-100 text-emerald-800 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-rose-100 text-rose-800 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif
                            </span>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <span>{{ $section->section_name }}</span>
                        </h3>
                        @if($section->title)
                            <p class="text-xs font-semibold text-[#1F2B45] mt-1 line-clamp-1">
                                “{{ $section->title }}”
                            </p>
                        @endif
                        @if($section->subtitle)
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                {{ $section->subtitle }}
                            </p>
                        @endif
                    </div>

                    {{-- Tags & Detail Ringkas --}}
                    <div class="flex flex-wrap items-center gap-3 pt-1 text-[11px] text-gray-500">
                        @if($section->image)
                            <span class="flex items-center gap-1 text-sky-700 bg-sky-50 px-2 py-0.5 rounded">
                                <span class="material-symbols-outlined text-[14px]">image</span> Ada Foto Terpasang
                            </span>
                        @endif
                        @if(!empty($section->items) && count($section->items) > 0)
                            <span class="flex items-center gap-1 text-purple-700 bg-purple-50 px-2 py-0.5 rounded font-medium">
                                <span class="material-symbols-outlined text-[14px]">list_alt</span> {{ count($section->items) }} Item / Poin Dinamis
                            </span>
                        @endif
                        @if($section->button_text)
                            <span class="flex items-center gap-1 text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">
                                <span class="material-symbols-outlined text-[14px]">touch_app</span> Tombol: "{{ $section->button_text }}"
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Gambar Preview & Aksi --}}
                <div class="flex md:flex-col items-center md:items-end justify-between w-full md:w-auto gap-3 shrink-0 border-t md:border-t-0 pt-3 md:pt-0 border-gray-100">
                    @if($section->image)
                        <div class="w-24 h-16 rounded-lg overflow-hidden border border-gray-200 bg-gray-50 shrink-0">
                            <img src="{{ $section->image_url }}" alt="{{ $section->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('admin.pages.toggle', $section) }}">
                            @csrf
                            <button type="submit" 
                                    class="p-2 text-gray-500 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-colors"
                                    title="{{ $section->is_active ? 'Nonaktifkan Section' : 'Aktifkan Section' }}">
                                <span class="material-symbols-outlined text-[18px]">
                                    {{ $section->is_active ? 'visibility' : 'visibility_off' }}
                                </span>
                            </button>
                        </form>
                        <a href="{{ route('admin.pages.edit', $section) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#1F2B45] text-white text-xs font-semibold rounded-2xl hover:bg-[#16203A] transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[15px]">edit_note</span>
                            <span>Edit Konten</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl p-12 text-center border border-dashed border-gray-300">
                <span class="material-symbols-outlined text-4xl text-gray-300">layers_clear</span>
                <p class="text-xs text-gray-500 mt-2 font-medium">Belum ada data section untuk halaman ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
