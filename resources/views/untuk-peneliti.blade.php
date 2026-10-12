@extends('layouts.app')

@section('title', __('sections.for_researchers.hero.title') . ' — Destinara')
@section('meta_description', __('sections.for_researchers.hero.subtitle'))
@section('meta_keywords', 'riset lapangan antropologi, penelitian etnografi desa, protokol FPIC kearifan lokal, etnobotani nusantara, data primer desa adat, ekspedisi ilmiah nusantara, destinara peneliti')
@section('og_image', asset('assets/img/hd/hero-about.jpg'))

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "{{ __('site.nav.home') }}",
      "item": "{{ url('/') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "{{ __('site.nav.for_researchers_full') }}",
      "item": "{{ route('for-researchers') }}"
    }
  ]
}
</script>
@endpush

@section('content')
@php
  $hero = $sections['hero'] ?? null;
  $ethics = $sections['ethics'] ?? null;
  $facilities = $sections['facilities'] ?? null;
@endphp

<main class="w-full bg-[#FAF9F6] dark:bg-[#140E0D] pt-20 sm:pt-24 pb-20 transition-colors">
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 space-y-14 sm:space-y-20">

    <!-- 1. Hero Section (Modern Clean Split Banner) -->
    @if(!$hero || $hero->is_active)
    <section class="relative w-full">
      <div class="bg-white dark:bg-[#1F1716] rounded-3xl sm:rounded-[40px] p-8 sm:p-12 lg:p-16 border border-gray-100 dark:border-white/5 shadow-sm">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
          
          <!-- Left: Hero Text -->
          <div class="lg:col-span-7 flex flex-col items-start gap-4">
            @if($hero?->badge)
            <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#51634b]/10 text-[#51634b] text-xs font-bold uppercase tracking-wider">
              <span class="w-1.5 h-1.5 rounded-full bg-[#51634b]"></span>
              <span>{{ $hero->badge }}</span>
            </div>
            @endif

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#1A1A1A] dark:text-white tracking-tight leading-tight">
              {{ $hero?->title ?? __('sections.for_researchers.hero.title') }}
            </h1>

            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 max-w-xl leading-relaxed">
              {{ $hero?->subtitle ?? __('sections.for_researchers.hero.subtitle') }}
            </p>

            <div class="flex flex-wrap items-center gap-3 pt-2">
              <a href="{{ $hero?->button_link ?? '#direktori-desa' }}" 
                 class="bg-[#703A3A] hover:bg-[#561D1E] text-white px-6 py-3 rounded-full text-xs font-bold shadow-md hover:shadow-lg transition-all">
                {{ $hero?->button_text ?? __('sections.for_researchers.hero.button_text') }}
              </a>
              <a href="#alur-riset" 
                 class="border border-gray-200 dark:border-white/10 hover:border-[#703A3A] text-gray-700 dark:text-gray-200 px-6 py-3 rounded-full text-xs font-bold transition-all">
                {{ __('sections.for_researchers.hero.btn_learn_fpic') }}
              </a>
            </div>

            <!-- Fieldnote Marginalia Card -->
            <div class="bg-gray-50 dark:bg-white/5 p-4 rounded-2xl border border-gray-100 dark:border-white/5 flex items-start gap-3 mt-2 w-full max-w-xl">
              <span class="material-symbols-outlined text-[#703A3A] text-[20px] shrink-0 mt-0.5">verified_user</span>
              <p class="text-xs text-gray-600 dark:text-gray-300 italic leading-relaxed">
                "{{ __('sections.for_researchers.hero.marginalia_quote') }}"
                <span class="block not-italic font-bold text-gray-900 dark:text-white text-[11px] mt-1">{{ __('sections.for_researchers.hero.marginalia_author') }}</span>
              </p>
            </div>
          </div>

          <!-- Right: Hero Image Plate -->
          <div class="lg:col-span-5 relative">
            <div class="relative w-full aspect-[4/5] rounded-3xl overflow-hidden shadow-lg border border-gray-100 dark:border-white/5">
              <img class="w-full h-full object-cover" alt="{{ $hero?->title ?? 'Antropolog budaya' }}" src="{{ $hero?->image_url ?? asset('assets/img/hd/peneliti-wawancara.jpg') }}"/>
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent pointer-events-none"></div>
              <div class="absolute bottom-4 left-4 right-4 p-3.5 bg-white/95 dark:bg-[#1E1B1B]/95 backdrop-blur-md rounded-2xl shadow-sm">
                <span class="text-[10px] font-bold text-[#703A3A] uppercase tracking-wider block">{{ __('sections.for_researchers.hero.plate_caption') }}</span>
                <p class="text-xs text-gray-700 dark:text-gray-200 mt-0.5 leading-snug">{{ $hero?->image_caption ?? 'Pendataan lisan silsilah irigasi Subak & penyerbukan benih di Desa Batur, Kintamani.' }}</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
    @endif

    <!-- 2. Section Fasilitas & 3 Pilar Riset (Clean Split Layout) -->
    <section class="w-full">
      <div class="max-w-2xl mb-8">
        <span class="text-xs font-bold uppercase tracking-wider text-[#51634b] block mb-2">
          {{ __('sections.for_researchers.facilities.tag') }}
        </span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1A1A1A] dark:text-white tracking-tight">
          {{ __('sections.for_researchers.facilities.title') }}
        </h2>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
        <!-- Kolom Kiri: Visual Kolase & Micro-Stats -->
        <div class="lg:col-span-5 flex flex-col gap-6">
          <div class="bg-white dark:bg-[#1F1716] rounded-3xl overflow-hidden shadow-sm border border-gray-100 dark:border-white/5 p-4">
            <div class="aspect-[16/10] overflow-hidden rounded-2xl mb-3">
              <img class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" alt="Naskah kuno" src="{{ asset('assets/img/hd/peneliti-lontar.jpg') }}"/>
            </div>
            <span class="text-xs font-bold text-[#703A3A] uppercase tracking-wider block">{{ __('sections.for_researchers.facilities.catalog_title') }}</span>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
              {{ __('sections.for_researchers.facilities.catalog_desc') }}
            </p>
          </div>

          <!-- Quick Stats Strip -->
          <div class="bg-white dark:bg-[#1F1716] p-6 rounded-3xl border border-gray-100 dark:border-white/5 shadow-sm grid grid-cols-3 gap-4 text-center">
            <div>
              <span class="text-2xl sm:text-3xl font-black text-[#703A3A] block">100%</span>
              <span class="text-[11px] text-gray-500 dark:text-gray-400">{{ __('sections.for_researchers.facilities.stat1_label') }}</span>
            </div>
            <div>
              <span class="text-2xl sm:text-3xl font-black text-[#51634b] block">18</span>
              <span class="text-[11px] text-gray-500 dark:text-gray-400">{{ __('sections.for_researchers.facilities.stat2_label') }}</span>
            </div>
            <div>
              <span class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white block">310+</span>
              <span class="text-[11px] text-gray-500 dark:text-gray-400">{{ __('sections.for_researchers.facilities.stat3_label') }}</span>
            </div>
          </div>
        </div>

        <!-- Kolom Kanan: 3 Pilar Cards -->
        <div class="lg:col-span-7 flex flex-col gap-4">
          <div class="bg-white dark:bg-[#1F1716] rounded-3xl p-6 sm:p-7 border border-gray-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all flex flex-col sm:flex-row gap-4 items-start">
            <div class="w-10 h-10 rounded-2xl bg-[#703A3A]/10 text-[#703A3A] flex items-center justify-center font-bold text-base shrink-0">
              01
            </div>
            <div class="flex-1">
              <div class="flex items-center gap-2 mb-1">
                <h3 class="text-base font-bold text-[#1A1A1A] dark:text-white">{{ __('sections.for_researchers.facilities.f1_title') }}</h3>
                <span class="bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-300 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase">{{ __('sections.for_researchers.facilities.tag_primary') }}</span>
              </div>
              <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ __('sections.for_researchers.facilities.f1_desc') }}</p>
              <div class="text-[11px] text-[#51634b] pt-2 flex items-center gap-1 font-semibold">
                <span class="material-symbols-outlined text-[15px]">folder_open</span>
                <span>{{ __('sections.for_researchers.facilities.f1_note') }}</span>
              </div>
            </div>
          </div>

          <div class="bg-white dark:bg-[#1F1716] rounded-3xl p-6 sm:p-7 border border-gray-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all flex flex-col sm:flex-row gap-4 items-start">
            <div class="w-10 h-10 rounded-2xl bg-[#703A3A]/10 text-[#703A3A] flex items-center justify-center font-bold text-base shrink-0">
              02
            </div>
            <div class="flex-1">
              <div class="flex items-center gap-2 mb-1">
                <h3 class="text-base font-bold text-[#1A1A1A] dark:text-white">{{ __('sections.for_researchers.facilities.f2_title') }}</h3>
                <span class="bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-300 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase">{{ __('sections.for_researchers.facilities.tag_bureaucracy') }}</span>
              </div>
              <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ __('sections.for_researchers.facilities.f2_desc') }}</p>
              <div class="text-[11px] text-[#51634b] pt-2 flex items-center gap-1 font-semibold">
                <span class="material-symbols-outlined text-[15px]">assignment_turned_in</span>
                <span>{{ __('sections.for_researchers.facilities.f2_note') }}</span>
              </div>
            </div>
          </div>

          <div class="bg-white dark:bg-[#1F1716] rounded-3xl p-6 sm:p-7 border border-gray-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all flex flex-col sm:flex-row gap-4 items-start">
            <div class="w-10 h-10 rounded-2xl bg-[#703A3A]/10 text-[#703A3A] flex items-center justify-center font-bold text-base shrink-0">
              03
            </div>
            <div class="flex-1">
              <div class="flex items-center gap-2 mb-1">
                <h3 class="text-base font-bold text-[#1A1A1A] dark:text-white">{{ __('sections.for_researchers.facilities.f3_title') }}</h3>
                <span class="bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-300 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase">{{ __('sections.for_researchers.facilities.tag_ethics') }}</span>
              </div>
              <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ __('sections.for_researchers.facilities.f3_desc') }}</p>
              <div class="text-[11px] text-[#51634b] pt-2 flex items-center gap-1 font-semibold">
                <span class="material-symbols-outlined text-[15px]">handshake</span>
                <span>{{ __('sections.for_researchers.facilities.f3_note') }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. Section Alur Riset 4 Tahap (Clean Stepper Cards) -->
    <section class="w-full" id="alur-riset">
      <div class="max-w-2xl mb-8">
        <span class="text-xs font-bold uppercase tracking-wider text-[#51634b] block mb-2">
          {{ __('sections.for_researchers.flow.tag') }}
        </span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1A1A1A] dark:text-white tracking-tight">
          {{ __('sections.for_researchers.flow.title') }}
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
          {{ __('sections.for_researchers.flow.subtitle') }}
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @for($s = 1; $s <= 4; $s++)
          <div class="bg-white dark:bg-[#1F1716] rounded-3xl p-6 sm:p-7 border border-gray-100 dark:border-white/5 shadow-sm flex flex-col justify-between">
            <div>
              <div class="flex items-center justify-between mb-3">
                <span class="w-10 h-10 rounded-2xl bg-[#703A3A]/10 text-[#703A3A] font-black text-sm flex items-center justify-center">
                  0{{ $s }}
                </span>
                <span class="text-[11px] text-gray-400 italic">{{ __('sections.for_researchers.flow.s' . $s . '_time') }}</span>
              </div>
              <h3 class="text-base font-bold text-[#1A1A1A] dark:text-white mt-1">
                {{ __('sections.for_researchers.flow.s' . $s . '_title') }}
              </h3>
              <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">
                {{ __('sections.for_researchers.flow.s' . $s . '_desc') }}
              </p>
            </div>
            <div class="pt-4 mt-4 border-t border-gray-100 dark:border-white/5 text-[11px] text-[#51634b] font-semibold">
              {{ __('sections.for_researchers.flow.s' . $s . '_out') }}
            </div>
          </div>
        @endfor
      </div>
    </section>

    <!-- 4. Section Direktori Desa Pilihan (Clean Travel Cards) -->
    <section class="w-full" id="direktori-desa">
      <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
          <span class="text-xs font-bold uppercase tracking-wider text-[#51634b] block mb-2">
            {{ __('sections.for_researchers.directory.tag') }}
          </span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1A1A1A] dark:text-white tracking-tight">
            {{ __('sections.for_researchers.directory.title') }}
          </h2>
          <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ __('sections.for_researchers.directory.subtitle') }}
          </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <span class="text-xs text-gray-400">{{ __('sections.for_researchers.directory.facility_label') }}</span>
          <span class="px-2.5 py-1 rounded-full bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-[11px] font-semibold text-gray-600 dark:text-gray-300">{{ __('sections.for_researchers.directory.fac_accom') }}</span>
          <span class="px-2.5 py-1 rounded-full bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-[11px] font-semibold text-gray-600 dark:text-gray-300">{{ __('sections.for_researchers.directory.fac_food') }}</span>
          <span class="px-2.5 py-1 rounded-full bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-[11px] font-semibold text-gray-600 dark:text-gray-300">{{ __('sections.for_researchers.directory.fac_elder') }}</span>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        <!-- Kartu 1: Sade -->
        <div class="bg-white dark:bg-[#1F1716] rounded-3xl p-3.5 shadow-sm hover:shadow-xl border border-gray-100 dark:border-white/5 transition-all flex flex-col justify-between group">
          <div>
            <div class="aspect-[16/10] overflow-hidden rounded-2xl relative mb-3">
              <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Desa Sade" src="{{ asset('assets/img/hd/peneliti-sade.jpg') }}"/>
              <span class="absolute top-3 left-3 bg-white/90 dark:bg-black/70 backdrop-blur-md text-[#1A1A1A] dark:text-white text-[11px] px-2.5 py-1 rounded-full font-bold shadow-xs">
                {{ __('sections.for_researchers.directory.c1_cat') }}
              </span>
            </div>
            <div class="px-2 pb-2">
              <div class="flex items-center justify-between text-xs text-gray-400 mb-1">
                <span>{{ __('sections.for_researchers.directory.c1_loc') }}</span>
                <span class="text-[#51634b] font-semibold">{{ __('sections.for_researchers.directory.c1_elders') }}</span>
              </div>
              <h3 class="text-base font-bold text-[#1A1A1A] dark:text-white">{{ __('sections.for_researchers.directory.c1_title') }}</h3>
              <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ __('sections.for_researchers.directory.c1_desc') }}</p>
            </div>
          </div>
          <div class="px-2 pt-3 border-t border-gray-100 dark:border-white/5 text-[11px] text-[#703A3A] font-semibold mt-2">
            {{ __('sections.for_researchers.directory.c1_accom') }}
          </div>
        </div>

        <!-- Kartu 2: Ciptagelar -->
        <div class="bg-white dark:bg-[#1F1716] rounded-3xl p-3.5 shadow-sm hover:shadow-xl border border-gray-100 dark:border-white/5 transition-all flex flex-col justify-between group">
          <div>
            <div class="aspect-[16/10] overflow-hidden rounded-2xl relative mb-3">
              <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Ciptagelar" src="{{ asset('assets/img/hd/peneliti-ciptagelar.jpg') }}"/>
              <span class="absolute top-3 left-3 bg-white/90 dark:bg-black/70 backdrop-blur-md text-[#1A1A1A] dark:text-white text-[11px] px-2.5 py-1 rounded-full font-bold shadow-xs">
                {{ __('sections.for_researchers.directory.c2_cat') }}
              </span>
            </div>
            <div class="px-2 pb-2">
              <div class="flex items-center justify-between text-xs text-gray-400 mb-1">
                <span>{{ __('sections.for_researchers.directory.c2_loc') }}</span>
                <span class="text-[#51634b] font-semibold">{{ __('sections.for_researchers.directory.c2_elders') }}</span>
              </div>
              <h3 class="text-base font-bold text-[#1A1A1A] dark:text-white">{{ __('sections.for_researchers.directory.c2_title') }}</h3>
              <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ __('sections.for_researchers.directory.c2_desc') }}</p>
            </div>
          </div>
          <div class="px-2 pt-3 border-t border-gray-100 dark:border-white/5 text-[11px] text-[#703A3A] font-semibold mt-2">
            {{ __('sections.for_researchers.directory.c2_accom') }}
          </div>
        </div>

        <!-- Kartu 3: Bleberan -->
        <div class="bg-white dark:bg-[#1F1716] rounded-3xl p-3.5 shadow-sm hover:shadow-xl border border-gray-100 dark:border-white/5 transition-all flex flex-col justify-between group">
          <div>
            <div class="aspect-[16/10] overflow-hidden rounded-2xl relative mb-3">
              <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Bleberan" src="{{ asset('assets/img/hd/peneliti-bleberan.jpg') }}"/>
              <span class="absolute top-3 left-3 bg-white/90 dark:bg-black/70 backdrop-blur-md text-[#1A1A1A] dark:text-white text-[11px] px-2.5 py-1 rounded-full font-bold shadow-xs">
                {{ __('sections.for_researchers.directory.c3_cat') }}
              </span>
            </div>
            <div class="px-2 pb-2">
              <div class="flex items-center justify-between text-xs text-gray-400 mb-1">
                <span>{{ __('sections.for_researchers.directory.c3_loc') }}</span>
                <span class="text-[#51634b] font-semibold">{{ __('sections.for_researchers.directory.c3_elders') }}</span>
              </div>
              <h3 class="text-base font-bold text-[#1A1A1A] dark:text-white">{{ __('sections.for_researchers.directory.c3_title') }}</h3>
              <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ __('sections.for_researchers.directory.c3_desc') }}</p>
            </div>
          </div>
          <div class="px-2 pt-3 border-t border-gray-100 dark:border-white/5 text-[11px] text-[#703A3A] font-semibold mt-2">
            {{ __('sections.for_researchers.directory.c3_accom') }}
          </div>
        </div>
      </div>
    </section>

    <!-- 5. Form Kontak & Fasilitasi Peneliti (Clean Split Card) -->
    <section class="w-full">
      <div class="bg-gradient-to-r from-[#3D1415] via-[#4A1D1E] to-[#682728] text-white rounded-3xl sm:rounded-[36px] p-8 sm:p-14 shadow-xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
          
          <div class="lg:col-span-6 flex flex-col gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-[#D4E9CA]">
              {{ __('sections.for_researchers.form.tag') }}
            </span>
            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight leading-tight">
              {{ __('sections.for_researchers.form.title') }}
            </h3>
            <p class="text-xs sm:text-sm text-[#D7C2C1] leading-relaxed">
              {{ __('sections.for_researchers.form.desc') }}
            </p>
            <div class="flex flex-col gap-2 pt-2 text-xs text-white/90">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-400 text-[18px]">done</span>
                <span>{{ __('sections.for_researchers.form.b1') }}</span>
              </div>
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-400 text-[18px]">done</span>
                <span>{{ __('sections.for_researchers.form.b2') }}</span>
              </div>
            </div>
          </div>

          <div class="lg:col-span-6">
            <div class="bg-white text-gray-900 rounded-3xl p-6 sm:p-8 shadow-2xl">
              <form class="flex flex-col gap-3" action="{{ route('contact.send') }}" method="POST">
                @csrf
                <input type="hidden" name="topic" value="Fasilitasi Riset & Kliring FPIC">
                
                <div>
                  <label class="block text-xs font-bold text-gray-700 mb-1" for="nama-peneliti">{{ __('sections.for_researchers.form.name_label') }}</label>
                  <input class="w-full bg-gray-50 text-gray-900 px-4 py-2.5 rounded-full border border-gray-200 text-xs outline-none focus:border-[#703A3A]" id="nama-peneliti" name="full_name" placeholder="{{ __('sections.for_researchers.form.name_placeholder') }}" required type="text"/>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1" for="institusi-kampus">{{ __('sections.for_researchers.form.inst_label') }}</label>
                    <input class="w-full bg-gray-50 text-gray-900 px-4 py-2.5 rounded-full border border-gray-200 text-xs outline-none focus:border-[#703A3A]" id="institusi-kampus" name="institution" placeholder="{{ __('sections.for_researchers.form.inst_placeholder') }}" required type="text"/>
                  </div>
                  <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1" for="whatsapp-peneliti">Nomor WhatsApp</label>
                    <input class="w-full bg-gray-50 text-gray-900 px-4 py-2.5 rounded-full border border-gray-200 text-xs outline-none focus:border-[#703A3A]" id="whatsapp-peneliti" name="whatsapp" placeholder="08xxxxxxxxxx" required type="tel"/>
                  </div>
                </div>

                <div>
                  <label class="block text-xs font-bold text-gray-700 mb-1" for="topik-fokus">{{ __('sections.for_researchers.form.topic_label') }}</label>
                  <textarea class="w-full bg-gray-50 text-gray-900 px-4 py-3 rounded-2xl border border-gray-200 text-xs outline-none focus:border-[#703A3A] resize-none" id="topik-fokus" name="message" placeholder="{{ __('sections.for_researchers.form.topic_placeholder') }}" rows="3"></textarea>
                </div>

                <button class="w-full bg-[#703A3A] hover:bg-[#561D1E] text-white py-3 rounded-full text-xs font-bold transition-all shadow-md cursor-pointer mt-1" type="submit">
                  {{ __('sections.for_researchers.form.submit_btn') }}
                </button>
              </form>
            </div>
          </div>

        </div>
      </div>
    </section>

  </div>
</main>
@endsection
