@extends('layouts.app')

@section('title', __('sections.for_villages.hero.title') . ' | Destinara')
@section('meta_description', __('sections.for_villages.hero.subtitle'))
@section('meta_keywords', 'mitra desa wisata, kemitraan desa adat, homestay desa nusantara, pemberdayaan warga desa, wisata edukasi desa, kearifan lokal desa, daftar mitra destinara')
@section('og_image', asset('assets/img/hd/desa-serambi.jpg'))

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
      "name": "{{ __('site.nav.services') }}",
      "item": "{{ url('/') }}#navigation"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "{{ __('site.nav.for_villages') }}",
      "item": "{{ route('for-villages') }}"
    }
  ]
}
</script>
@endpush

@section('content')
@php
  $hero = $sections['hero'] ?? null;
  $villageBenefits = $sections['village_benefits'] ?? null;
@endphp
<main class="w-full pt-20 sm:pt-24 bg-[#FAF7F5] dark:bg-[#140E0D] pb-20">
  <div class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-8 space-y-16 sm:space-y-24">
    
    @if(!$hero || $hero->is_active)
    <!-- Hero Island Section (Split 2-Kolom Modern Pomaii) -->
    <section class="bg-white dark:bg-[#1E1716] rounded-3xl p-8 sm:p-12 lg:p-14 border border-gray-100 dark:border-white/5 shadow-sm">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
        
        <!-- Left: Text & Action -->
        <div class="lg:col-span-7 flex flex-col items-start gap-5">
          @if($hero?->badge || __('sections.for_villages.hero.badge'))
          <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#703A3A]/10 text-[#703A3A] text-xs font-bold uppercase tracking-wider">
            <span class="material-symbols-outlined text-[16px]">nature_people</span>
            <span>{{ $hero?->badge ?? __('sections.for_villages.hero.badge') }}</span>
          </div>
          @endif

          <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#1E1B1B] dark:text-white tracking-tight leading-tight">
            {{ $hero?->title ?? __('sections.for_villages.hero.title') }}
          </h1>

          <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 leading-relaxed max-w-2xl">
            {{ $hero?->subtitle ?? __('sections.for_villages.hero.subtitle') }}
          </p>

          <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5 w-full sm:w-auto pt-2">
            <a href="{{ $hero?->button_link ?? '#formulir-kemitraan' }}" 
               class="bg-[#703A3A] hover:bg-[#561D1E] text-white px-8 py-3.5 rounded-full text-xs font-bold text-center shadow-md hover:shadow-xl transition-all">
              {{ $hero?->button_text ?? __('sections.for_villages.hero.button_text') }}
            </a>
            <a href="https://wa.me/{{ \App\Models\SiteSetting::get('contact_whatsapp_ryan', '6285774410978') }}?text={{ urlencode('Halo Ryan, kami pengelola desa ingin menanyakan kemitraan tapak Destinara.') }}" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="border border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5 text-[#1E1B1B] dark:text-white px-6 py-3.5 rounded-full text-xs font-bold flex items-center justify-center gap-2 transition-all">
              <span class="material-symbols-outlined text-[18px] text-[#51634b]">chat</span>
              <span>{{ __('sections.for_villages.hero.ask_whatsapp') }}</span>
            </a>
          </div>

          <div class="flex flex-wrap items-center gap-4 sm:gap-6 pt-3 text-xs text-gray-600 dark:text-gray-400 font-medium">
            <div class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[#51634b] text-[18px]">check_circle</span>
              <span>{{ __('sections.for_villages.hero.perk_free') }}</span>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[#51634b] text-[18px]">check_circle</span>
              <span>{{ __('sections.for_villages.hero.perk_custom') }}</span>
            </div>
          </div>
        </div>

        <!-- Right: Visual Plate & Benefit Card -->
        <div class="lg:col-span-5 flex flex-col gap-4">
          <div class="relative aspect-[4/3] rounded-3xl overflow-hidden shadow-md bg-gray-100">
            <img src="{{ $hero?->image_url ?? asset('assets/img/hd/desa-serambi.jpg') }}" 
                 alt="{{ $hero?->title ?? __('sections.for_villages.hero.title') }}" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-5">
              <p class="text-xs text-white/90 italic">
                {{ $hero?->image_caption ?? __('sections.for_villages.hero.image_caption') }}
              </p>
            </div>
          </div>

          <div class="p-5 bg-[#FAF7F5] dark:bg-white/5 rounded-2xl border border-gray-100 dark:border-white/5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#703A3A]/10 text-[#703A3A] flex items-center justify-center shrink-0">
              <span class="material-symbols-outlined text-[24px]">volunteer_activism</span>
            </div>
            <div>
              <p class="text-sm font-bold text-[#1E1B1B] dark:text-white leading-tight">
                {{ __('sections.for_villages.hero.benefit_title') }}
              </p>
              <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                {{ __('sections.for_villages.hero.benefit_desc') }}
              </p>
            </div>
          </div>
        </div>

      </div>
    </section>
    @endif

    <!-- Elder Quote Section (Modern Clean Card) -->
    <section class="max-w-4xl mx-auto w-full">
      <div class="bg-white dark:bg-[#1E1716] rounded-3xl p-8 sm:p-12 border border-gray-100 dark:border-white/5 shadow-sm flex flex-col sm:flex-row items-center gap-8">
        <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-3xl overflow-hidden shrink-0 shadow-md">
          <img src="{{ asset('assets/img/hd/desa-lurah.jpg') }}" alt="Pak Lurah Marto Suwito" class="w-full h-full object-cover">
        </div>
        <div class="flex-1 flex flex-col gap-3 text-center sm:text-left">
          <span class="material-symbols-outlined text-3xl text-[#703A3A]">format_quote</span>
          <blockquote class="text-base sm:text-lg font-serif italic text-gray-800 dark:text-gray-200 leading-relaxed">
            "{{ __('sections.for_villages.elder_quote.quote') }}"
          </blockquote>
          <div class="pt-2">
            <p class="text-sm font-bold text-[#1E1B1B] dark:text-white">{{ __('sections.for_villages.elder_quote.author') }}</p>
            <p class="text-xs text-[#703A3A] font-semibold mt-0.5">{{ __('sections.for_villages.elder_quote.role') }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- 3 Core Benefits Cards -->
    <section class="space-y-8">
      <div class="text-center max-w-2xl mx-auto space-y-2">
        <span class="text-xs font-bold uppercase tracking-wider text-[#703A3A]">
          {{ __('sections.for_villages.benefits.tag') }}
        </span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1E1B1B] dark:text-white tracking-tight">
          {{ __('sections.for_villages.benefits.title') }}
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
          {{ __('sections.for_villages.benefits.subtitle') }}
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
        <!-- Benefit 1 -->
        <div class="bg-white dark:bg-[#1E1716] rounded-3xl p-7 border border-gray-100 dark:border-white/5 shadow-xs hover:shadow-md transition-all flex flex-col justify-between gap-5">
          <div class="space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-[#703A3A]/10 text-[#703A3A] flex items-center justify-center">
              <span class="material-symbols-outlined text-[26px]">handshake</span>
            </div>
            <h3 class="text-lg font-bold text-[#1E1B1B] dark:text-white leading-snug">
              {{ __('sections.for_villages.benefits.c1_title') }}
            </h3>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
              {{ __('sections.for_villages.benefits.c1_desc') }}
            </p>
          </div>
          <div class="p-3.5 bg-[#FAF7F5] dark:bg-white/5 rounded-2xl text-xs text-[#703A3A] font-medium italic">
            {{ __('sections.for_villages.benefits.c1_note') }}
          </div>
        </div>

        <!-- Benefit 2 -->
        <div class="bg-white dark:bg-[#1E1716] rounded-3xl p-7 border border-gray-100 dark:border-white/5 shadow-xs hover:shadow-md transition-all flex flex-col justify-between gap-5">
          <div class="space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-[#51634b]/10 text-[#51634b] flex items-center justify-center">
              <span class="material-symbols-outlined text-[26px]">payments</span>
            </div>
            <h3 class="text-lg font-bold text-[#1E1B1B] dark:text-white leading-snug">
              {{ __('sections.for_villages.benefits.c2_title') }}
            </h3>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
              {{ __('sections.for_villages.benefits.c2_desc') }}
            </p>
          </div>
          <div class="p-3.5 bg-[#FAF7F5] dark:bg-white/5 rounded-2xl text-xs text-[#51634b] font-medium italic">
            {{ __('sections.for_villages.benefits.c2_note') }}
          </div>
        </div>

        <!-- Benefit 3 -->
        <div class="bg-white dark:bg-[#1E1716] rounded-3xl p-7 border border-gray-100 dark:border-white/5 shadow-xs hover:shadow-md transition-all flex flex-col justify-between gap-5">
          <div class="space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-700 flex items-center justify-center">
              <span class="material-symbols-outlined text-[26px]">assignment_turned_in</span>
            </div>
            <h3 class="text-lg font-bold text-[#1E1B1B] dark:text-white leading-snug">
              {{ __('sections.for_villages.benefits.c3_title') }}
            </h3>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
              {{ __('sections.for_villages.benefits.c3_desc') }}
            </p>
          </div>
          <div class="p-3.5 bg-[#FAF7F5] dark:bg-white/5 rounded-2xl text-xs text-amber-700 font-medium italic">
            {{ __('sections.for_villages.benefits.c3_note') }}
          </div>
        </div>
      </div>
    </section>

    <!-- Visual Banner Break -->
    <section class="rounded-3xl overflow-hidden relative shadow-md">
      <div class="relative h-72 sm:h-80 w-full">
        <img src="{{ asset('assets/img/hd/desa-bukit.jpg') }}" 
             alt="{{ __('sections.for_villages.banner.title') }}" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/50 to-transparent flex items-center p-8 sm:p-14">
          <div class="max-w-xl text-white space-y-3">
            <span class="text-xs font-bold uppercase tracking-wider text-[#FAF7F5]/80">
              {{ __('sections.for_villages.banner.tag') }}
            </span>
            <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
              {{ __('sections.for_villages.banner.title') }}
            </h3>
            <p class="text-xs sm:text-sm text-white/80 leading-relaxed">
              {{ __('sections.for_villages.banner.desc') }}
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- 4-Step How It Works Section -->
    <section class="space-y-8">
      <div class="text-center max-w-2xl mx-auto space-y-2">
        <span class="text-xs font-bold uppercase tracking-wider text-[#703A3A]">
          {{ __('sections.for_villages.steps.tag') }}
        </span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1E1B1B] dark:text-white tracking-tight">
          {{ __('sections.for_villages.steps.title') }}
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
          {{ __('sections.for_villages.steps.subtitle') }}
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Step 1 -->
        <div class="bg-white dark:bg-[#1E1716] rounded-3xl p-6 sm:p-7 border border-gray-100 dark:border-white/5 shadow-xs hover:shadow-md transition-all flex flex-col justify-between gap-4">
          <div class="space-y-3">
            <span class="text-3xl font-extrabold text-[#703A3A] block leading-none">01</span>
            <h4 class="text-base font-bold text-[#1E1B1B] dark:text-white">
              {{ __('sections.for_villages.steps.s1_title') }}
            </h4>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
              {{ __('sections.for_villages.steps.s1_desc') }}
            </p>
          </div>
          <div class="pt-3 border-t border-gray-100 dark:border-white/5 text-xs text-gray-400 flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px] text-[#703A3A]">forum</span>
            <span>Dialog Awal</span>
          </div>
        </div>

        <!-- Step 2 -->
        <div class="bg-white dark:bg-[#1E1716] rounded-3xl p-6 sm:p-7 border border-gray-100 dark:border-white/5 shadow-xs hover:shadow-md transition-all flex flex-col justify-between gap-4">
          <div class="space-y-3">
            <span class="text-3xl font-extrabold text-[#703A3A] block leading-none">02</span>
            <h4 class="text-base font-bold text-[#1E1B1B] dark:text-white">
              {{ __('sections.for_villages.steps.s2_title') }}
            </h4>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
              {{ __('sections.for_villages.steps.s2_desc') }}
            </p>
          </div>
          <div class="pt-3 border-t border-gray-100 dark:border-white/5 text-xs text-gray-400 flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px] text-[#703A3A]">cottage</span>
            <span>Verifikasi Lokasi</span>
          </div>
        </div>

        <!-- Step 3 -->
        <div class="bg-white dark:bg-[#1E1716] rounded-3xl p-6 sm:p-7 border border-gray-100 dark:border-white/5 shadow-xs hover:shadow-md transition-all flex flex-col justify-between gap-4">
          <div class="space-y-3">
            <span class="text-3xl font-extrabold text-[#703A3A] block leading-none">03</span>
            <h4 class="text-base font-bold text-[#1E1B1B] dark:text-white">
              {{ __('sections.for_villages.steps.s3_title') }}
            </h4>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
              {{ __('sections.for_villages.steps.s3_desc') }}
            </p>
          </div>
          <div class="pt-3 border-t border-gray-100 dark:border-white/5 text-xs text-gray-400 flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px] text-[#703A3A]">policy</span>
            <span>Pakta FPIC</span>
          </div>
        </div>

        <!-- Step 4 -->
        <div class="bg-white dark:bg-[#1E1716] rounded-3xl p-6 sm:p-7 border border-gray-100 dark:border-white/5 shadow-xs hover:shadow-md transition-all flex flex-col justify-between gap-4">
          <div class="space-y-3">
            <span class="text-3xl font-extrabold text-[#51634b] block leading-none">04</span>
            <h4 class="text-base font-bold text-[#1E1B1B] dark:text-white">
              {{ __('sections.for_villages.steps.s4_title') }}
            </h4>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
              {{ __('sections.for_villages.steps.s4_desc') }}
            </p>
          </div>
          <div class="pt-3 border-t border-gray-100 dark:border-white/5 text-xs text-[#51634b] flex items-center gap-1.5 font-medium">
            <span class="material-symbols-outlined text-[16px]">groups</span>
            <span>Rombongan Tiba</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Registration Form & FAQ Section -->
    <section id="formulir-kemitraan" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      <!-- Left: Form Card -->
      <div class="lg:col-span-7 bg-white dark:bg-[#1E1716] p-8 sm:p-10 rounded-3xl border border-gray-100 dark:border-white/5 shadow-sm space-y-6">
        <div>
          <span class="text-xs font-bold uppercase tracking-wider text-[#703A3A]">
            {{ __('sections.for_villages.form.tag') }}
          </span>
          <h3 class="text-2xl font-extrabold text-[#1E1B1B] dark:text-white tracking-tight mt-1">
            {{ __('sections.for_villages.form.title') }}
          </h3>
          <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ __('sections.for_villages.form.subtitle') }}
          </p>
        </div>

        <form class="space-y-4" id="mitraForm" onsubmit="event.preventDefault(); showToast('{{ addslashes(__('sections.for_villages.form.toast_success')) }}', 'success'); this.reset();">
          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5" for="namaLengkap">
              {{ __('sections.for_villages.form.name_label') }}
            </label>
            <input class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-xs sm:text-sm text-[#1E1B1B] dark:text-white placeholder-gray-400 focus:outline-none focus:border-[#703A3A] transition-all" 
                   id="namaLengkap" 
                   placeholder="{{ __('sections.for_villages.form.name_placeholder') }}" 
                   required type="text"/>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5" for="nomorHp">
                {{ __('sections.for_villages.form.phone_label') }}
              </label>
              <input class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-xs sm:text-sm text-[#1E1B1B] dark:text-white placeholder-gray-400 focus:outline-none focus:border-[#703A3A] transition-all" 
                     id="nomorHp" 
                     placeholder="{{ __('sections.for_villages.form.phone_placeholder') }}" 
                     required type="tel"/>
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5" for="peranWarga">
                {{ __('sections.for_villages.form.role_label') }}
              </label>
              <select class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-xs sm:text-sm text-[#1E1B1B] dark:text-white focus:outline-none focus:border-[#703A3A] transition-all cursor-pointer" 
                      id="peranWarga">
                <option value="pengurus-pokdarwis">{{ __('sections.for_villages.form.role_pokdarwis') }}</option>
                <option value="aparatur-desa">{{ __('sections.for_villages.form.role_aparatur') }}</option>
                <option value="tetua-adat">{{ __('sections.for_villages.form.role_tetua') }}</option>
                <option value="warga-perseorangan">{{ __('sections.for_villages.form.role_warga') }}</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5" for="lokasiDesa">
              {{ __('sections.for_villages.form.location_label') }}
            </label>
            <input class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-xs sm:text-sm text-[#1E1B1B] dark:text-white placeholder-gray-400 focus:outline-none focus:border-[#703A3A] transition-all" 
                   id="lokasiDesa" 
                   placeholder="{{ __('sections.for_villages.form.location_placeholder') }}" 
                   required type="text"/>
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5" for="kegiatanKhas">
              {{ __('sections.for_villages.form.activities_label') }}
            </label>
            <textarea class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-xs sm:text-sm text-[#1E1B1B] dark:text-white placeholder-gray-400 focus:outline-none focus:border-[#703A3A] transition-all resize-none" 
                      id="kegiatanKhas" 
                      placeholder="{{ __('sections.for_villages.form.activities_placeholder') }}" 
                      rows="3"></textarea>
          </div>

          <button class="w-full bg-[#703A3A] hover:bg-[#561D1E] text-white py-3.5 px-6 rounded-full text-xs font-bold text-center shadow-md hover:shadow-xl transition-all cursor-pointer mt-2" 
                  type="submit">
            {{ __('sections.for_villages.form.submit_btn') }}
          </button>
        </form>
      </div>

      <!-- Right: FAQ & Direct Contact -->
      <div class="lg:col-span-5 flex flex-col gap-6">
        <div class="bg-white dark:bg-[#1E1716] p-8 rounded-3xl border border-gray-100 dark:border-white/5 shadow-sm space-y-4">
          <h4 class="text-lg font-bold text-[#1E1B1B] dark:text-white">
            {{ __('sections.for_villages.faq.title') }}
          </h4>
          <div class="space-y-3">
            <div class="p-4 rounded-2xl bg-[#FAF7F5] dark:bg-white/5 space-y-1">
              <p class="text-xs font-bold text-[#1E1B1B] dark:text-white">
                {{ __('sections.for_villages.faq.q1') }}
              </p>
              <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                {{ __('sections.for_villages.faq.a1') }}
              </p>
            </div>
            <div class="p-4 rounded-2xl bg-[#FAF7F5] dark:bg-white/5 space-y-1">
              <p class="text-xs font-bold text-[#1E1B1B] dark:text-white">
                {{ __('sections.for_villages.faq.q2') }}
              </p>
              <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                {{ __('sections.for_villages.faq.a2') }}
              </p>
            </div>
            <div class="p-4 rounded-2xl bg-[#FAF7F5] dark:bg-white/5 space-y-1">
              <p class="text-xs font-bold text-[#1E1B1B] dark:text-white">
                {{ __('sections.for_villages.faq.q3') }}
              </p>
              <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                {{ __('sections.for_villages.faq.a3') }}
              </p>
            </div>
          </div>
        </div>

        <!-- Direct Contact Card -->
        <div class="bg-white dark:bg-[#1E1716] p-6 rounded-3xl border border-gray-100 dark:border-white/5 shadow-sm flex items-center gap-4">
          <div class="w-12 h-12 rounded-full bg-[#51634b]/10 text-[#51634b] flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[24px]">support_agent</span>
          </div>
          <div>
            <p class="text-xs font-bold text-[#1E1B1B] dark:text-white">{{ __('sections.for_villages.faq.talk_direct_title') }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
              {!! __('sections.for_villages.faq.talk_direct_desc', ['name' => '<a href="https://wa.me/' . \App\Models\SiteSetting::get('contact_whatsapp_ryan', '6285774410978') . '?text=' . urlencode('Halo Ryan, kami pengelola desa ingin menanyakan kemitraan tapak Destinara.') . '" target="_blank" rel="noopener" class="text-[#703A3A] font-bold hover:underline">Mas Ryan</a>', 'phone' => '+62 857-7441-0978']) !!}
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Deep Maroon Bottom CTA -->
    <section class="bg-[#561D1E] text-white rounded-3xl p-10 sm:p-14 lg:p-16 text-center space-y-6 shadow-xl relative overflow-hidden">
      <div class="max-w-2xl mx-auto space-y-3 relative z-10">
        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-white/10 text-white mb-2">
          <span class="material-symbols-outlined text-2xl">door_front</span>
        </span>
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight">
          {{ __('sections.for_villages.cta.title') }}
        </h2>
        <p class="text-xs sm:text-sm text-white/80 leading-relaxed">
          {{ __('sections.for_villages.cta.desc') }}
        </p>
      </div>

      <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 relative z-10">
        <a href="#formulir-kemitraan" 
           class="w-full sm:w-auto bg-white hover:bg-gray-100 text-[#561D1E] px-8 py-3.5 rounded-full text-xs font-bold shadow-md transition-all">
          {{ __('sections.for_villages.cta.btn_register') }}
        </a>
        <a href="https://wa.me/{{ \App\Models\SiteSetting::get('contact_whatsapp_ryan', '6285774410978') }}?text={{ urlencode('Halo Ryan, kami pengelola desa ingin mendaftarkan destinasi kami.') }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="w-full sm:w-auto border border-white/30 hover:bg-white/10 text-white px-7 py-3.5 rounded-full text-xs font-bold flex items-center justify-center gap-2 transition-all">
          <span class="material-symbols-outlined text-[18px]">chat</span>
          <span>{{ __('sections.for_villages.cta.btn_whatsapp') }}</span>
        </a>
      </div>

      <p class="text-[11px] text-white/60 italic relative z-10">
        {{ __('sections.for_villages.cta.note') }}
      </p>
    </section>

  </div>
</main>
@endsection
