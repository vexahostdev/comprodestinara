@extends('layouts.app')

@section('title', 'Destinara — ' . ($sections['hero']->title ?? __('sections.home.hero.title')))
@section('meta_description', $sections['hero']->subtitle ?? __('sections.home.hero.subtitle'))
@section('meta_keywords', 'destinara, wisata edukasi nusantara, field trip sekolah, study tour berizin, live in desa, riset antropologi, penelitian tapak, kearifan lokal, kemitraan desa wisata, etnobotani, layanan destinara')
@section('og_image', asset('assets/img/hd/hero-home.jpg'))

@section('content')
@php
  $hero = $sections['hero'] ?? null;
  $featuredList = $featuredDestinations->take(4);
  // Ensure we have 4 items for the exact 4-card grid
  if ($featuredList->count() < 4 && isset($allDestinations)) {
      $featuredList = $allDestinations->take(4);
  }
@endphp

<main class="w-full bg-[#FAF9F6] dark:bg-[#140E0D] pb-16 lg:pb-24 pt-20 sm:pt-24 transition-colors">
  <div class="max-w-[1440px] mx-auto px-3 sm:px-6 lg:px-8 space-y-12 sm:space-y-16">

    <!-- ==================== 1. HERO SECTION (POMAII MODERN ISLAND LAYOUT) ==================== -->
    <section class="relative w-full">
      <div class="relative w-full min-h-[580px] sm:min-h-[620px] lg:min-h-[680px] rounded-[32px] sm:rounded-[40px] lg:rounded-[48px] overflow-hidden bg-[#FAF9F6] dark:bg-[#140E0D] shadow-sm border border-gray-200/40 dark:border-white/10">
        
        <!-- Scenic Nature Photography (Right/Full Background) -->
        <img src="{{ $hero?->image_url ?? asset('assets/img/hd/hero-home.jpg') }}" 
             alt="{{ $hero?->title ?? __('sections.home.hero.title') }}" 
             class="absolute inset-0 w-full h-full object-cover object-[center_30%]" />

        <!-- Organic Fluid Shape on the Left (Desktop SVG Wave Mask) -->
        <svg class="absolute inset-0 w-full h-full pointer-events-none hidden md:block" viewBox="0 0 1440 700" fill="none" preserveAspectRatio="none">
          <path d="M0 0 H520 C640 140 670 240 590 380 C510 520 620 620 560 700 H0 V0 Z" class="fill-[#FAF9F6] dark:fill-[#140E0D]"/>
          <!-- Subtle Soft Glassy Border Glow -->
          <path d="M520 0 C640 140 670 240 590 380 C510 520 620 620 560 700" stroke="rgba(255,255,255,0.6)" stroke-width="6"/>
        </svg>

        <!-- Mobile Semi-transparent Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#FAF9F6] via-[#FAF9F6]/90 to-transparent dark:from-[#140E0D] dark:via-[#140E0D]/90 dark:to-transparent md:hidden pointer-events-none"></div>

        <!-- Right Side: Translucent Organic Liquid Wave Ribbons -->
        <div class="absolute -right-16 top-1/4 w-80 h-96 pointer-events-none opacity-60 hidden xl:block">
          <svg viewBox="0 0 300 400" fill="none" class="w-full h-full">
            <path d="M50 0 C150 80 280 180 200 300 C150 380 50 350 0 400" stroke="rgba(255,255,255,0.7)" stroke-width="48" stroke-linecap="round" class="blur-xs"/>
            <path d="M80 30 C170 100 260 200 190 310" stroke="rgba(255,255,255,0.4)" stroke-width="24" stroke-linecap="round"/>
          </svg>
        </div>

        <!-- Top Right: Decorative 3x3 Dot Grid -->
        <div class="absolute top-8 right-8 z-20 pointer-events-none hidden sm:block opacity-60">
          <div class="grid grid-cols-3 gap-2">
            @for($i = 0; $i < 9; $i++)
              <span class="w-1.5 h-1.5 rounded-full bg-white shadow-xs"></span>
            @endfor
          </div>
        </div>

        <!-- Top Left: Botanical Leaf Illustration Accent -->
        <div class="absolute top-6 left-6 sm:top-10 sm:left-10 z-20 pointer-events-none opacity-80">
          <svg class="w-10 h-10 sm:w-14 sm:h-14 text-[#51634B] dark:text-[#A7C89F]" viewBox="0 0 64 64" fill="currentColor">
            <path d="M12 52 C20 40 32 30 52 14 C36 18 24 28 16 42 C14 45 13 49 12 52 Z" opacity="0.65"/>
            <path d="M18 40 C28 32 38 24 50 16 C38 24 30 34 22 46 Z" opacity="0.85"/>
            <circle cx="14" cy="48" r="2" fill="currentColor"/>
          </svg>
        </div>

        <!-- Hero Content Area (Left Positioned) -->
        <div class="relative z-20 max-w-xl sm:max-w-2xl py-14 sm:py-20 px-6 sm:px-12 lg:px-16 flex flex-col justify-center min-h-[580px] sm:min-h-[620px] lg:min-h-[680px]">
          
          <!-- Micro Kicker Badge -->
          <div class="text-[11px] sm:text-xs font-extrabold tracking-[0.25em] text-[#703A3A] dark:text-[#E8999B] uppercase mb-4 sm:mb-5">
            {{ $hero?->badge ?? __('sections.home.hero.badge') }}
          </div>

          <!-- Headline: Clean & Modern with Corporate Maroon Brush Stroke -->
          <h1 class="text-3xl sm:text-4xl lg:text-[46px] lg:leading-[1.18] font-black text-[#1A1A1A] dark:text-white tracking-tight mb-5">
            <span class="relative inline-block">
              {{ $hero?->title ?? __('sections.home.hero.title') }}
              <!-- Curved hand-drawn brush underline stroke in corporate maroon -->
              <svg class="absolute -bottom-2 sm:-bottom-3 left-0 w-full max-w-[280px] h-3 sm:h-4 text-[#703A3A] dark:text-[#E8999B]" viewBox="0 0 260 14" fill="none">
                <path d="M3 10C65 2 195 2 257 11" stroke="currentColor" stroke-width="4.5" stroke-linecap="round"/>
              </svg>
            </span>
          </h1>

          <!-- Calming Subtitle (Minim Teks, Nyaman Dibaca) -->
          <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 max-w-md sm:max-w-lg leading-relaxed mb-8 font-normal">
            {{ $hero?->subtitle ?? __('sections.home.hero.subtitle') }}
          </p>

          <!-- Solid Pill CTA Button -->
          <div>
            <a href="{{ $hero?->button_link ?? route('destinations.index') }}" 
               class="inline-flex items-center gap-2.5 bg-[#703A3A] hover:bg-[#561D1E] text-white font-bold text-xs sm:text-sm px-8 py-4 rounded-full shadow-[0_10px_25px_rgba(112,58,58,0.25)] hover:shadow-xl hover:scale-105 transition-all duration-300">
              <span>{{ $hero?->button_text ?? __('sections.home.hero.button_text') }}</span>
              <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
          </div>

        </div>

      </div>

      <!-- ==================== 2. FLOATING SEARCH BAR ==================== -->
      <div class="max-w-[1140px] mx-auto px-3 sm:px-6 relative -mt-10 sm:-mt-12 z-30">
        <form action="{{ route('destinations.index') }}" method="GET" 
              class="bg-white dark:bg-[#1E1716] rounded-3xl lg:rounded-full p-2.5 sm:p-3 shadow-[0_20px_50px_rgba(0,0,0,0.08)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.4)] border border-gray-100 dark:border-white/10 flex flex-col lg:flex-row items-center gap-2 lg:gap-0">
          
          <!-- Slot 1: Lokasi / Destinasi -->
          <div class="w-full lg:flex-1 px-5 py-2 hover:bg-gray-50/80 dark:hover:bg-white/5 rounded-2xl lg:rounded-full transition-colors flex items-center gap-3.5 cursor-pointer">
            <span class="material-symbols-outlined text-gray-400 text-[22px]">location_on</span>
            <div class="flex-1 min-w-0">
              <label for="q-search" class="block text-xs font-bold text-gray-900 dark:text-white leading-none mb-1">{{ __('site.nav.destinations') }}</label>
              <input type="text" id="q-search" name="q" placeholder="{{ __('site.common.all_regions') }}" 
                     class="w-full text-xs text-gray-600 dark:text-gray-300 bg-transparent border-0 p-0 focus:ring-0 focus:outline-none placeholder-gray-400 font-medium">
            </div>
          </div>

          <div class="hidden lg:block w-px h-8 bg-gray-200 dark:bg-white/10 shrink-0"></div>

          <!-- Slot 2: Mandat / Jalur Program -->
          <div class="w-full lg:flex-1 px-5 py-2 hover:bg-gray-50/80 dark:hover:bg-white/5 rounded-2xl lg:rounded-full transition-colors flex items-center gap-3.5 cursor-pointer">
            <span class="material-symbols-outlined text-gray-400 text-[22px]">school</span>
            <div class="flex-1 min-w-0">
              <span class="block text-xs font-bold text-gray-900 dark:text-white leading-none mb-1">{{ __('sections.home.gateways.tag') }}</span>
              <select name="mandate" class="w-full text-xs text-gray-600 dark:text-gray-300 bg-transparent border-0 p-0 focus:ring-0 focus:outline-none cursor-pointer font-medium">
                <option value="" class="dark:bg-[#1E1716]">{{ __('site.common.cat_all') }}</option>
                <option value="school" class="dark:bg-[#1E1716]">{{ __('sections.home.gateways.school_tag') }}</option>
                <option value="research" class="dark:bg-[#1E1716]">{{ __('sections.home.gateways.research_tag') }}</option>
                <option value="village" class="dark:bg-[#1E1716]">{{ __('sections.home.gateways.village_tag') }}</option>
              </select>
            </div>
          </div>

          <div class="hidden lg:block w-px h-8 bg-gray-200 dark:bg-white/10 shrink-0"></div>

          <!-- Slot 3: Kategori Lanskap -->
          <div class="w-full lg:flex-1 px-5 py-2 hover:bg-gray-50/80 dark:hover:bg-white/5 rounded-2xl lg:rounded-full transition-colors flex items-center gap-3.5 cursor-pointer">
            <span class="material-symbols-outlined text-gray-400 text-[22px]">landscape</span>
            <div class="flex-1 min-w-0">
              <span class="block text-xs font-bold text-gray-900 dark:text-white leading-none mb-1">{{ __('site.common.landscape_category') }}</span>
              <select name="category" class="w-full text-xs text-gray-600 dark:text-gray-300 bg-transparent border-0 p-0 focus:ring-0 focus:outline-none cursor-pointer font-medium">
                <option value="" class="dark:bg-[#1E1716]">{{ __('site.common.cat_all') }}</option>
                <option value="budaya" class="dark:bg-[#1E1716]">{{ __('site.common.cat_culture') }}</option>
                <option value="ekologi" class="dark:bg-[#1E1716]">{{ __('site.common.cat_ecology') }}</option>
                <option value="pangan" class="dark:bg-[#1E1716]">{{ __('site.common.cat_food') }}</option>
                <option value="bahari" class="dark:bg-[#1E1716]">{{ __('site.common.cat_marine') }}</option>
              </select>
            </div>
          </div>

          <div class="hidden lg:block w-px h-8 bg-gray-200 dark:bg-white/10 shrink-0"></div>

          <!-- Slot 4: Kapasitas Rombongan -->
          <div class="w-full lg:flex-1 px-5 py-2 hover:bg-gray-50/80 dark:hover:bg-white/5 rounded-2xl lg:rounded-full transition-colors flex items-center gap-3.5 cursor-pointer">
            <span class="material-symbols-outlined text-gray-400 text-[22px]">group</span>
            <div class="flex-1 min-w-0">
              <span class="block text-xs font-bold text-gray-900 dark:text-white leading-none mb-1">{{ __('site.common.max_group_capacity') }}</span>
              <span class="text-xs text-gray-500 dark:text-gray-400 font-medium block truncate">{{ __('site.common.default_capacity_range') }}</span>
            </div>
          </div>

          <!-- Action Button: Maroon Pill Button -->
          <div class="w-full lg:w-auto px-2 shrink-0">
            <button type="submit" 
                    class="w-full lg:w-auto bg-[#703A3A] hover:bg-[#561D1E] text-white px-7 py-3.5 rounded-full text-xs font-bold flex items-center justify-center gap-2 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer">
              <span>{{ __('site.common.explore_destinations') }}</span>
              <span class="material-symbols-outlined text-[16px]">search</span>
            </button>
          </div>

        </form>
      </div>

      <!-- ==================== 3. TRUST STRIP (4 MINIMALIST LINE ICONS) ==================== -->
      <div class="max-w-[1140px] mx-auto px-4 sm:px-6 mt-12 mb-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
          
          <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-full border border-gray-200 dark:border-white/10 flex items-center justify-center text-[#703A3A] dark:text-[#E8999B] shrink-0 bg-white dark:bg-[#1E1716] shadow-xs">
              <span class="material-symbols-outlined text-[24px]">verified_user</span>
            </div>
            <div>
              <h4 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white leading-tight">{{ __('sections.home.safety_matrix.p2_title') }}</h4>
              <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-snug">{{ __('site.common.verified_fpic') }}</p>
            </div>
          </div>

          <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-full border border-gray-200 dark:border-white/10 flex items-center justify-center text-[#703A3A] dark:text-[#E8999B] shrink-0 bg-white dark:bg-[#1E1716] shadow-xs">
              <span class="material-symbols-outlined text-[24px]">health_and_safety</span>
            </div>
            <div>
              <h4 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white leading-tight">{{ __('sections.home.safety_matrix.p1_title') }}</h4>
              <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-snug">{{ __('site.common.medical_sop') }}</p>
            </div>
          </div>

          <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-full border border-gray-200 dark:border-white/10 flex items-center justify-center text-[#703A3A] dark:text-[#E8999B] shrink-0 bg-white dark:bg-[#1E1716] shadow-xs">
              <span class="material-symbols-outlined text-[24px]">menu_book</span>
            </div>
            <div>
              <h4 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white leading-tight">{{ __('sections.home.safety_matrix.p4_title') }}</h4>
              <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-snug">{{ __('site.common.syllabus_module') }}</p>
            </div>
          </div>

          <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-full border border-gray-200 dark:border-white/10 flex items-center justify-center text-[#703A3A] dark:text-[#E8999B] shrink-0 bg-white dark:bg-[#1E1716] shadow-xs">
              <span class="material-symbols-outlined text-[24px]">school</span>
            </div>
            <div>
              <h4 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white leading-tight">{{ __('sections.home.safety_matrix.p3_title') }}</h4>
              <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-snug">{{ __('site.common.verified_docs') }}</p>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- ==================== 4. FEATURED DESTINATIONS (4 FULL-BLEED PHOTO PORTRAIT CARDS) ==================== -->
    <section class="w-full">
      <!-- Section Header -->
      <div class="flex items-center justify-between mb-6 sm:mb-8">
        <div class="flex items-center gap-2">
          <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">{{ __('sections.home.featured_destinations.title') }}</h2>
          <span class="text-xl">🌿</span>
        </div>
        <a href="{{ route('destinations.index') }}" class="text-xs font-bold text-gray-700 dark:text-gray-300 hover:text-[#703A3A] dark:hover:text-[#E8999B] flex items-center gap-1.5 group transition-colors">
          <span>{{ __('sections.home.featured_destinations.all_btn') }}</span>
          <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </a>
      </div>

      <!-- 4 Columns Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
        @foreach($featuredList as $dest)
        <a href="{{ route('destinations.show', $dest->slug) }}" 
           class="relative aspect-[3/4] rounded-3xl overflow-hidden group shadow-md hover:shadow-2xl transition-all duration-300 block bg-[#231917]">
          
          <!-- Full-Bleed Photography -->
          <img src="{{ $dest->cover_image_url ?? $dest->image_url ?? asset('assets/img/hd/dest-wonosadi.jpg') }}" 
               alt="{{ $dest->name }}" 
               class="absolute inset-0 w-full h-full object-cover group-hover:scale-108 transition-transform duration-700 ease-out" />
          
          <!-- Top subtle scrim for badge contrast -->
          <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-black/40 to-transparent pointer-events-none"></div>

          <!-- Top-Left Frosted Rating Badge -->
          <div class="absolute top-4 left-4 px-3 py-1 rounded-full bg-black/50 backdrop-blur-md text-white text-xs font-bold flex items-center gap-1 shadow-sm">
            <span class="text-amber-400">★</span>
            <span>{{ $dest->rating ?? '4.8' }}</span>
          </div>

          <!-- Bottom Full Gradient Scrim & Info -->
          <div class="absolute inset-x-0 bottom-0 p-5 bg-gradient-to-t from-black/90 via-black/50 to-transparent flex items-end justify-between">
            <div class="min-w-0 pr-2">
              <h3 class="text-white font-extrabold text-lg leading-snug group-hover:text-amber-300 transition-colors truncate">
                {{ $dest->name }}
              </h3>
              <p class="text-white/75 text-xs line-clamp-1 mt-0.5">
                {{ $dest->city ?? $dest->province ?? 'Nusantara' }} • {{ $dest->category_label ?? __('site.common.cat_culture') }}
              </p>
            </div>
            <div class="text-amber-400 font-extrabold text-base sm:text-lg shrink-0 font-mono">
              Rp {{ number_format($dest->price_per_pax ?? 45000, 0, ',', '.') }}
            </div>
          </div>

        </a>
        @endforeach
      </div>
    </section>

    <!-- ==================== 5. CATEGORY ICONS ROW (6 CIRCULAR SAGE PILLS) ==================== -->
    <section class="w-full py-4">
      <div class="flex items-center justify-center gap-4 sm:gap-8 lg:gap-14 flex-wrap">
        
        <a href="{{ route('destinations.index', ['category' => 'budaya']) }}" class="flex items-center gap-3 group">
          <div class="w-13 h-13 rounded-full bg-[#EBF1E8] dark:bg-[#253022] text-[#51634B] dark:text-[#A7C89F] flex items-center justify-center group-hover:bg-[#703A3A] group-hover:text-white transition-all shadow-xs">
            <span class="material-symbols-outlined text-[24px]">museum</span>
          </div>
          <span class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-[#703A3A] dark:group-hover:text-[#E8999B] transition-colors">{{ __('site.common.cat_culture') }}</span>
        </a>

        <a href="{{ route('destinations.index', ['category' => 'ekologi']) }}" class="flex items-center gap-3 group">
          <div class="w-13 h-13 rounded-full bg-[#EBF1E8] dark:bg-[#253022] text-[#51634B] dark:text-[#A7C89F] flex items-center justify-center group-hover:bg-[#703A3A] group-hover:text-white transition-all shadow-xs">
            <span class="material-symbols-outlined text-[24px]">forest</span>
          </div>
          <span class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-[#703A3A] dark:group-hover:text-[#E8999B] transition-colors">{{ __('site.common.cat_ecology') }}</span>
        </a>

        <a href="{{ route('destinations.index', ['category' => 'pangan']) }}" class="flex items-center gap-3 group">
          <div class="w-13 h-13 rounded-full bg-[#EBF1E8] dark:bg-[#253022] text-[#51634B] dark:text-[#A7C89F] flex items-center justify-center group-hover:bg-[#703A3A] group-hover:text-white transition-all shadow-xs">
            <span class="material-symbols-outlined text-[24px]">agriculture</span>
          </div>
          <span class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-[#703A3A] dark:group-hover:text-[#E8999B] transition-colors">{{ __('site.common.cat_food') }}</span>
        </a>

        <a href="{{ route('destinations.index', ['category' => 'bahari']) }}" class="flex items-center gap-3 group">
          <div class="w-13 h-13 rounded-full bg-[#EBF1E8] dark:bg-[#253022] text-[#51634B] dark:text-[#A7C89F] flex items-center justify-center group-hover:bg-[#703A3A] group-hover:text-white transition-all shadow-xs">
            <span class="material-symbols-outlined text-[24px]">water</span>
          </div>
          <span class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-[#703A3A] dark:group-hover:text-[#E8999B] transition-colors">{{ __('site.common.cat_marine') }}</span>
        </a>

        <a href="{{ route('for-schools') }}" class="flex items-center gap-3 group">
          <div class="w-13 h-13 rounded-full bg-[#EBF1E8] dark:bg-[#253022] text-[#51634B] dark:text-[#A7C89F] flex items-center justify-center group-hover:bg-[#703A3A] group-hover:text-white transition-all shadow-xs">
            <span class="material-symbols-outlined text-[24px]">school</span>
          </div>
          <span class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-[#703A3A] dark:group-hover:text-[#E8999B] transition-colors">{{ __('sections.home.gateways.school_tag') }}</span>
        </a>

        <a href="{{ route('for-researchers') }}" class="flex items-center gap-3 group">
          <div class="w-13 h-13 rounded-full bg-[#EBF1E8] dark:bg-[#253022] text-[#51634B] dark:text-[#A7C89F] flex items-center justify-center group-hover:bg-[#703A3A] group-hover:text-white transition-all shadow-xs">
            <span class="material-symbols-outlined text-[24px]">biotech</span>
          </div>
          <span class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-[#703A3A] dark:group-hover:text-[#E8999B] transition-colors">{{ __('sections.home.gateways.research_tag') }}</span>
        </a>

      </div>
    </section>

    <!-- ==================== 6. TRAVEL STORIES & GUIDES (POMAII 3-PART CARD) ==================== -->
    <section class="w-full">
      <div class="bg-[#F3EFE6] dark:bg-[#1E1716] rounded-[32px] sm:rounded-[40px] p-6 sm:p-10 lg:p-12 relative overflow-hidden border border-[#E8E2D5] dark:border-white/10 transition-colors">
        
        <!-- Bottom-Right Botanical Leaf Illustration -->
        <div class="absolute bottom-4 right-4 pointer-events-none opacity-40">
          <svg class="w-24 h-24 text-[#51634B] dark:text-[#A7C89F]" viewBox="0 0 100 100" fill="currentColor">
            <path d="M10 90 C30 70 50 50 90 20 C65 30 45 50 30 70 Z"/>
          </svg>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
          
          <!-- Column 1: Left Text & CTA (5 cols) -->
          <div class="lg:col-span-5 space-y-4">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 block">
              {{ __('sections.home.stories.tag') }}
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight leading-tight">
              {{ __('sections.home.stories.title') }}
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed max-w-sm">
              {{ __('sections.home.stories.subtitle') }}
            </p>
            <div class="pt-2">
              <a href="{{ route('stories.index') }}" 
                 class="inline-flex items-center gap-2 bg-[#703A3A] hover:bg-[#561D1E] text-white px-6 py-3.5 rounded-full text-xs font-bold transition-all duration-200 shadow-sm hover:shadow-md">
                <span>{{ __('sections.home.stories.all_btn') }}</span>
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
              </a>
            </div>
          </div>

          <!-- Column 2 & 3: Article Cards Grid (7 cols) -->
          <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
            
            @forelse($stories->take(2) as $story)
            <div class="bg-white dark:bg-[#251D1C] rounded-2xl sm:rounded-3xl p-4 sm:p-5 shadow-sm border border-gray-100 dark:border-white/10 group hover:shadow-md transition-shadow">
              <a href="{{ route('stories.show', $story->slug) }}" class="block space-y-3">
                <div class="relative aspect-[16/10] rounded-xl sm:rounded-2xl overflow-hidden bg-gray-100 dark:bg-white/5">
                  <img src="{{ $story->cover_image_url ?? $story->image_url ?? asset('assets/img/hd/story-ulin.jpg') }}" 
                       alt="{{ $story->title }}" 
                       class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                </div>
                <div>
                  <h3 class="font-bold text-sm sm:text-base text-gray-900 dark:text-white group-hover:text-[#703A3A] dark:group-hover:text-[#E8999B] transition-colors leading-snug line-clamp-2">
                    {{ $story->title }}
                  </h3>
                  <span class="text-[11px] text-gray-400 dark:text-gray-400 mt-1 block">
                    {{ $story->read_time ?? '5' }} {{ __('site.common.minutes') }} • {{ $story->author ?? __('site.common.destinara_curator') }}
                  </span>
                </div>
              </a>
            </div>
            @empty
            <!-- Fallback Story 1 -->
            <div class="bg-white dark:bg-[#251D1C] rounded-2xl sm:rounded-3xl p-4 sm:p-5 shadow-sm border border-gray-100 dark:border-white/10 group hover:shadow-md transition-shadow">
              <a href="{{ route('stories.index') }}" class="block space-y-3">
                <div class="relative aspect-[16/10] rounded-xl sm:rounded-2xl overflow-hidden bg-gray-100 dark:bg-white/5">
                  <img src="{{ asset('assets/img/hd/story-ulin.jpg') }}" alt="{{ __('site.footer.monograph_sikka') }}" 
                       class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                </div>
                <div>
                  <h3 class="font-bold text-sm sm:text-base text-gray-900 dark:text-white group-hover:text-[#703A3A] dark:group-hover:text-[#E8999B] transition-colors leading-snug">
                    {{ __('site.footer.monograph_sikka') }}
                  </h3>
                  <span class="text-[11px] text-gray-400 dark:text-gray-400 mt-1 block">5 {{ __('site.common.minutes') }}</span>
                </div>
              </a>
            </div>

            <!-- Fallback Story 2 -->
            <div class="bg-white dark:bg-[#251D1C] rounded-2xl sm:rounded-3xl p-4 sm:p-5 shadow-sm border border-gray-100 dark:border-white/10 group hover:shadow-md transition-shadow">
              <a href="{{ route('stories.index') }}" class="block space-y-3">
                <div class="relative aspect-[16/10] rounded-xl sm:rounded-2xl overflow-hidden bg-gray-100 dark:bg-white/5">
                  <img src="{{ asset('assets/img/hd/peneliti-sade.jpg') }}" alt="{{ __('site.common.field_stories_badge') }}" 
                       class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                </div>
                <div>
                  <h3 class="font-bold text-sm sm:text-base text-gray-900 dark:text-white group-hover:text-[#703A3A] dark:group-hover:text-[#E8999B] transition-colors leading-snug">
                    {{ __('site.common.field_stories_badge') }}
                  </h3>
                  <span class="text-[11px] text-gray-400 dark:text-gray-400 mt-1 block">4 {{ __('site.common.minutes') }}</span>
                </div>
              </a>
            </div>
            @endforelse

          </div>

        </div>

      </div>
    </section>

    <!-- ==================== 7. PANORAMA BANNER (CORPORATE MAROON THEME) ==================== -->
    <section class="w-full">
      <div class="bg-gradient-to-r from-[#3D1415] via-[#4A1D1E] to-[#682728] rounded-[32px] sm:rounded-[40px] text-white overflow-hidden shadow-xl grid grid-cols-1 lg:grid-cols-12 items-center relative border border-white/10">
        
        <!-- Left Side: Scenic Landscape Image with Curved Cut -->
        <div class="lg:col-span-6 h-64 sm:h-80 lg:h-96 relative overflow-hidden">
          <img src="{{ asset('assets/img/hd/dest-kintamani.jpg') }}" alt="{{ __('sections.home.intro_story.title') }}" 
               class="w-full h-full object-cover"/>
          <!-- Gradient Scrim to Deep Maroon -->
          <div class="absolute inset-0 bg-gradient-to-t lg:bg-gradient-to-r from-transparent via-[#4A1D1E]/50 to-[#4A1D1E] pointer-events-none"></div>
        </div>

        <!-- Right Side: Content Area -->
        <div class="lg:col-span-6 p-8 sm:p-12 lg:pr-16 space-y-4 relative z-10">
          <span class="text-xs font-bold uppercase tracking-widest text-[#FFCBB5] flex items-center gap-1.5">
            <span>{{ __('sections.home.intro_story.badge') }}</span>
            <span class="text-amber-400">⚡</span>
          </span>

          <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight leading-tight text-white">
            {{ __('sections.home.intro_story.title') }}
          </h2>

          <p class="text-xs sm:text-sm text-white/80 leading-relaxed max-w-md">
            {{ __('sections.home.intro_story.subtitle') }}
          </p>

          <div class="pt-2">
            <a href="{{ route('about') }}" 
               class="inline-flex items-center gap-2 bg-[#703A3A] hover:bg-[#8C5151] border border-white/20 text-white font-bold text-xs sm:text-sm px-8 py-3.5 rounded-full shadow-lg hover:scale-105 transition-all duration-300">
              <span>{{ __('sections.home.intro_story.button_text') }}</span>
              <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
          </div>
        </div>

        <!-- Bottom-Right Floral Ornament Accent -->
        <div class="absolute bottom-0 right-0 pointer-events-none opacity-40 hidden sm:block">
          <svg class="w-40 h-40 text-rose-300" viewBox="0 0 160 160" fill="currentColor">
            <path d="M120 120 C100 80 140 50 160 70 C150 100 130 110 120 120 Z" fill="#8C5151"/>
            <path d="M110 130 C70 120 60 150 80 160 C100 150 110 140 110 130 Z" fill="#703A3A"/>
            <path d="M130 110 C150 80 160 110 160 130 C140 130 130 120 130 110 Z" fill="#B36666"/>
            <circle cx="125" cy="125" r="8" fill="#F0C2A0"/>
          </svg>
        </div>

      </div>
    </section>

    <!-- ==================== 8. STATS ROW (4 METRICS + SOSIAL) ==================== -->
    <section class="w-full py-4 border-b border-gray-200/80 dark:border-white/10">
      <div class="flex flex-col md:flex-row items-center justify-between gap-6 py-4">
        
        <!-- 4 Stats -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 sm:gap-10 w-full md:w-auto">
          
          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-[#703A3A] dark:text-[#E8999B] text-[26px]">verified</span>
            <div>
              <span class="text-base font-extrabold text-gray-900 dark:text-white block leading-tight font-mono">12+</span>
              <span class="text-[11px] text-gray-500 dark:text-gray-400">{{ __('sections.home.stats.sites_verified') }}</span>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-[#703A3A] dark:text-[#E8999B] text-[26px]">group</span>
            <div>
              <span class="text-base font-extrabold text-gray-900 dark:text-white block leading-tight font-mono">1.400+</span>
              <span class="text-[11px] text-gray-500 dark:text-gray-400">{{ __('sections.home.stats.students_field') }}</span>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-amber-500 text-[26px]">menu_book</span>
            <div>
              <span class="text-base font-extrabold text-gray-900 dark:text-white block leading-tight font-mono">28+</span>
              <span class="text-[11px] text-gray-500 dark:text-gray-400">{{ __('sections.home.stats.modules_published') }}</span>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-[#703A3A] dark:text-[#E8999B] text-[26px]">handshake</span>
            <div>
              <span class="text-base font-extrabold text-gray-900 dark:text-white block leading-tight font-mono">35+</span>
              <span class="text-[11px] text-gray-500 dark:text-gray-400">{{ __('sections.home.stats.partner_institutions') }}</span>
            </div>
          </div>

        </div>

        <!-- Social Media / Follow -->
        <div class="flex items-center gap-3 self-center md:self-auto">
          <span class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ __('site.footer.company') }}</span>
          <div class="flex items-center gap-2">
            <a href="https://instagram.com/destinara.id" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-gray-100 dark:bg-white/10 hover:bg-[#703A3A] hover:text-white text-gray-700 dark:text-gray-300 flex items-center justify-center transition-colors text-xs font-bold" title="Instagram">ig</a>
            <a href="https://wa.me/6282116200363" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-gray-100 dark:bg-white/10 hover:bg-[#703A3A] hover:text-white text-gray-700 dark:text-gray-300 flex items-center justify-center transition-colors text-xs font-bold" title="WhatsApp">wa</a>
          </div>
        </div>

      </div>
    </section>

  </div>
</main>
@endsection