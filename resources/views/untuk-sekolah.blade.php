@extends('layouts.app')

@section('title', __('site.nav.for_schools') . ' — ' . __('sections.for_schools.hero.title') . ' | Destinara')
@section('meta_description', __('sections.for_schools.hero.subtitle'))
@section('meta_keywords', 'program edukasi sekolah, study tour berizin, field trip kurikulum merdeka, live in desa edukatif, dana bos study tour resmi, destinara sekolah')
@section('og_image', asset('assets/img/hd/sekolah-diskusi.jpg'))

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
      "name": "{{ __('site.nav.for_schools') }}",
      "item": "{{ route('for-schools') }}"
    }
  ]
}
</script>
@endpush

@section('content')
@php
  $hero = $sections['hero'] ?? null;
  $benefits = $sections['benefits'] ?? null;
  $flow = $sections['flow'] ?? null;
  $cta = $sections['cta_schools'] ?? null;
@endphp

<main class="w-full bg-[#FAF9F6] dark:bg-[#140E0D] pt-20 sm:pt-24 pb-20 transition-colors">
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 space-y-14 sm:space-y-20">

    <!-- 1. Hero Section (Modern Clean Split Banner) -->
    @if(!$hero || $hero->is_active)
    <section class="relative w-full">
      <div class="bg-white dark:bg-[#1F1716] rounded-3xl sm:rounded-[40px] p-8 sm:p-12 lg:p-16 border border-gray-100 dark:border-white/5 shadow-sm">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
          
          <!-- Left: Hero Text -->
          <div class="lg:col-span-6 flex flex-col items-start gap-4">
            @if($hero?->badge)
            <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#51634b]/10 text-[#51634b] text-xs font-bold uppercase tracking-wider">
              <span class="w-1.5 h-1.5 rounded-full bg-[#51634b]"></span>
              <span>{{ $hero->badge }}</span>
            </div>
            @endif

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#1A1A1A] dark:text-white tracking-tight leading-tight">
              {{ $hero?->title ?? __('sections.for_schools.hero.title') }}
            </h1>

            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 max-w-xl leading-relaxed">
              {{ $hero?->subtitle ?? __('sections.for_schools.hero.subtitle') }}
            </p>

            <div class="flex flex-wrap items-center gap-3 pt-2">
              <a href="{{ $hero?->button_link ?? '#konsultasi' }}" 
                 class="bg-[#703A3A] hover:bg-[#561D1E] text-white px-6 py-3 rounded-full text-xs font-bold shadow-md hover:shadow-lg transition-all">
                {{ $hero?->button_text ?? __('sections.for_schools.hero.button_text') }}
              </a>
              <div class="flex items-center gap-1.5 text-xs font-semibold text-[#51634b] px-3 py-2 rounded-full bg-[#51634b]/10">
                <span class="material-symbols-outlined text-[17px]">verified_user</span>
                <span>{{ __('site.common.verified_docs') }}</span>
              </div>
            </div>

            <!-- Trust Badges Strip -->
            <div class="pt-6 mt-2 border-t border-gray-100 dark:border-white/5 flex flex-wrap items-center gap-4 text-xs font-medium text-gray-500 dark:text-gray-400 w-full">
              <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[#703A3A] text-[18px]">gavel</span>
                <span>{{ __('site.common.legal_mou') }}</span>
              </div>
              <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[#703A3A] text-[18px]">health_and_safety</span>
                <span>{{ __('sections.for_schools.values.v2_title') }}</span>
              </div>
              <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[#703A3A] text-[18px]">receipt_long</span>
                <span>{{ __('sections.for_schools.cta_schools.inspection_draft') }}</span>
              </div>
            </div>
          </div>

          <!-- Right: Hero Image Plate -->
          <div class="lg:col-span-6 relative">
            <div class="relative w-full aspect-[4/3] rounded-3xl overflow-hidden shadow-lg border border-gray-100 dark:border-white/5">
              <img class="w-full h-full object-cover" alt="{{ $hero?->title ?? 'Siswa berdiskusi' }}" src="{{ $hero?->image_url ?? asset('assets/img/hd/sekolah-diskusi.jpg') }}"/>
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent pointer-events-none"></div>
              <div class="absolute bottom-4 left-4 right-4 p-3.5 bg-white/95 dark:bg-[#1E1B1B]/95 backdrop-blur-md rounded-2xl shadow-sm flex items-center justify-between gap-3">
                <div>
                  <p class="text-xs font-bold text-gray-900 dark:text-white leading-tight">Sanggar Lapangan Pentingsari</p>
                  <p class="text-[11px] text-gray-500 dark:text-gray-400 italic">{{ $hero?->image_caption ?? 'Observasi etnobotani terpadu — Kelas VIII' }}</p>
                </div>
                <span class="px-2.5 py-1 rounded-full bg-[#51634b]/15 text-[#51634b] text-[10px] font-bold uppercase tracking-wider shrink-0">
                  SOP Level A
                </span>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
    @endif

    <!-- 2. Section Manfaat: 4 Pilar Kepastian (Clean 4-Card Grid) -->
    @if(!$benefits || $benefits->is_active)
    <section class="w-full" id="silabus">
      <div class="max-w-2xl mb-8">
        <span class="text-xs font-bold uppercase tracking-wider text-[#51634b] block mb-2">
          {{ $benefits?->badge ?? 'STANDAR PENYELENGGARAAN RESMI' }}
        </span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1A1A1A] dark:text-white tracking-tight">
          {{ $benefits?->title ?? 'Mengapa sekolah mempercayakan pembelajaran lapangan pada Destinara' }}
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">
          {{ $benefits?->subtitle ?? 'Dirancang untuk melenyapkan keraguan komite, memastikan keselamatan fisik setiap peserta didik, dan menuntaskan sasaran capaian kurikulum.' }}
        </p>
      </div>

      @php
        $benefitItems = $benefits?->items ?? [
            ['icon' => 'verified_user', 'title' => __('sections.for_schools.values.v1_title'), 'desc' => __('sections.for_schools.values.v1_desc')],
            ['icon' => 'menu_book', 'title' => __('sections.for_schools.values.v3_title'), 'desc' => __('sections.for_schools.values.v3_desc')],
            ['icon' => 'health_and_safety', 'title' => __('sections.for_schools.values.v2_title'), 'desc' => __('sections.for_schools.values.v2_desc')],
            ['icon' => 'receipt_long', 'title' => __('sections.for_schools.values.v4_title'), 'desc' => __('sections.for_schools.values.v4_desc')]
        ];
      @endphp

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($benefitItems as $bItem)
          <div class="bg-white dark:bg-[#1F1716] rounded-3xl p-6 sm:p-7 border border-gray-100 dark:border-white/5 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all flex flex-col gap-3 group">
            <div class="w-11 h-11 rounded-2xl bg-[#703A3A]/10 text-[#703A3A] flex items-center justify-center group-hover:scale-105 transition-transform">
              <span class="material-symbols-outlined text-[24px]">{{ $bItem['icon'] ?? 'verified' }}</span>
            </div>
            <h3 class="text-base font-bold text-[#1A1A1A] dark:text-white mt-1">
              {{ $bItem['title'] ?? '' }}
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
              {{ $bItem['desc'] ?? '' }}
            </p>
          </div>
        @endforeach
      </div>
    </section>
    @endif

    <!-- 3. Section Alur & Proses (Clean Stepper Cards) -->
    @if(!$flow || $flow->is_active)
    <section class="w-full">
      <div class="max-w-2xl mb-8">
        <span class="text-xs font-bold uppercase tracking-wider text-[#51634b] block mb-2">
          {{ $flow?->badge ?? __('sections.for_schools.flow.tag') }}
        </span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1A1A1A] dark:text-white tracking-tight">
          {{ $flow?->title ?? __('sections.for_schools.flow.title') }}
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">
          {{ $flow?->subtitle ?? __('sections.for_schools.flow.subtitle') }}
        </p>
      </div>

      @php
        $flowItems = $flow?->items ?? [
            ['step' => '01', 'title' => __('sections.for_schools.flow.s1_title'), 'desc' => __('sections.for_schools.flow.s1_desc')],
            ['step' => '02', 'title' => __('sections.for_schools.flow.s2_title'), 'desc' => __('sections.for_schools.flow.s2_desc')],
            ['step' => '03', 'title' => __('sections.for_schools.flow.s3_title'), 'desc' => __('sections.for_schools.flow.s3_desc')],
            ['step' => '04', 'title' => __('sections.for_schools.flow.s4_title'), 'desc' => __('sections.for_schools.flow.s4_desc')]
        ];
      @endphp

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($flowItems as $idx => $fItem)
          <div class="bg-white dark:bg-[#1F1716] rounded-3xl p-6 sm:p-7 border border-gray-100 dark:border-white/5 shadow-sm flex flex-col gap-3">
            <span class="text-3xl font-black text-[#703A3A] dark:text-[#E8999B]">
              {{ $fItem['step'] ?? sprintf('%02d', $idx + 1) }}
            </span>
            <h4 class="text-base font-bold text-[#1A1A1A] dark:text-white">
              {{ $fItem['title'] ?? '' }}
            </h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
              {{ $fItem['desc'] ?? '' }}
            </p>
          </div>
        @endforeach
      </div>
    </section>
    @endif

    <!-- 4. Closing CTA & Consultation Form (Clean Modern Split Card) -->
    @if(!$cta || $cta->is_active)
    <section class="w-full" id="konsultasi">
      <div class="bg-gradient-to-r from-[#3D1415] via-[#4A1D1E] to-[#682728] text-white rounded-3xl sm:rounded-[36px] p-8 sm:p-14 shadow-xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
          
          <div class="lg:col-span-7 flex flex-col gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-[#D4E9CA]">
              {{ $cta?->badge ?? __('sections.for_schools.cta_schools.badge') }}
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight leading-tight">
              {{ $cta?->title ?? __('sections.for_schools.cta_schools.title') }}
            </h2>
            <p class="text-xs sm:text-sm text-[#D7C2C1] max-w-xl leading-relaxed">
              {{ $cta?->subtitle ?? __('sections.for_schools.cta_schools.subtitle') }}
            </p>
          </div>

          <div class="lg:col-span-5">
            <div class="bg-white text-[#1E1B1B] rounded-3xl p-6 sm:p-8 shadow-2xl flex flex-col gap-4">
              <div>
                <p class="text-lg font-bold text-gray-900">{{ __('sections.for_schools.cta_schools.schedule_title') }}</p>
                <p class="text-xs text-gray-500">{{ __('sections.for_schools.cta_schools.schedule_subtitle') }}</p>
              </div>

              <form class="flex flex-col gap-3" action="{{ route('contact.send') }}" method="POST">
                @csrf
                <input type="hidden" name="topic" value="{{ __('sections.for_schools.hero.title') }}">
                
                <div class="flex flex-col gap-1">
                  <label class="text-xs font-bold text-gray-700" for="full_name">
                    {{ __('site.form.full_name') }} <span class="text-[#703A3A]">*</span>
                  </label>
                  <input class="w-full px-4 py-2.5 rounded-full bg-gray-50 text-gray-900 text-xs border border-gray-200 focus:outline-none focus:border-[#703A3A]" 
                         id="full_name" name="full_name" placeholder="{{ __('site.form.full_name_placeholder') }}" required type="text"/>
                </div>

                <input type="hidden" name="institution" value="{{ __('site.form.institution') }}">

                <div class="flex flex-col gap-1">
                  <label class="text-xs font-bold text-gray-700" for="whatsapp">
                    {{ __('site.form.whatsapp') }} <span class="text-[#703A3A]">*</span>
                  </label>
                  <input class="w-full px-4 py-2.5 rounded-full bg-gray-50 text-gray-900 text-xs border border-gray-200 focus:outline-none focus:border-[#703A3A]" 
                         id="whatsapp" name="whatsapp" placeholder="{{ __('site.form.whatsapp_placeholder') }}" required type="tel"/>
                </div>

                <button class="mt-2 w-full bg-[#703A3A] hover:bg-[#561D1E] text-white py-3 rounded-full text-xs font-bold transition-all shadow-md cursor-pointer" type="submit">
                  <span>{{ $cta?->button_text ?? __('sections.for_schools.cta_schools.submit_btn') }}</span>
                </button>
              </form>
            </div>
          </div>

        </div>
      </div>
    </section>
    @endif

  </div>
</main>
@endsection
