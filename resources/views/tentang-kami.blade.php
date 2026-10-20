@extends('layouts.app')

@section('title', __('site.nav.about') . ' — ' . __('sections.about.hero.badge') . ' | Destinara')
@section('meta_description', __('sections.about.hero.title'))
@section('meta_keywords', 'tentang destinara, profil destinara, pt destinara chakrawal artha, inisiatif pendidikan tapak, pendiri destinara, pelestarian budaya nusantara')
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
      "name": "{{ __('site.nav.about') }}",
      "item": "{{ route('about') }}"
    }
  ]
}
</script>
@endpush

@section('content')
@php
  $hero = $sections['hero'] ?? null;
  $manifesto = $sections['manifesto'] ?? null;
  $founder = $sections['founder_story'] ?? null;
  $values = $sections['values'] ?? null;
  $gov = $sections['governance'] ?? null;
@endphp

<main class="w-full bg-[#FFFFFF] dark:bg-[#111315] pt-20 sm:pt-24 pb-20 transition-colors">
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 space-y-14 sm:space-y-20">

    <!-- 1. Hero Section (Modern Clean Island Banner) -->
    @if(!$hero || $hero->is_active)
    <section class="relative w-full">
      <div class="relative w-full min-h-[460px] sm:min-h-[520px] lg:min-h-[580px] rounded-3xl sm:rounded-3xl lg:rounded-3xl overflow-hidden bg-[#1F2937] shadow-sm border border-gray-200/50 flex items-end">
        <img src="{{ $hero?->image_url ?? asset('assets/img/hd/hero-about.jpg') }}" 
             alt="{{ $hero?->title ?? 'Tentang Kami Destinara' }}" 
             class="absolute inset-0 w-full h-full object-cover object-[center_35%] brightness-90"/>
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent pointer-events-none"></div>

        <div class="relative z-10 w-full p-6 sm:p-12 lg:p-16 max-w-4xl">
          @if($hero?->badge)
          <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#51634b]/80 backdrop-blur-md text-[#D4E9CA] text-xs font-bold uppercase tracking-wider mb-4">
            <span class="w-1.5 h-1.5 rounded-full bg-[#D4E9CA]"></span>
            <span>{{ $hero->badge }}</span>
          </div>
          @endif

          <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight drop-shadow-sm">
            {{ $hero?->title ?? 'Merajut Dialog Setara antara Ruang Kuliah dan Kearifan Warga Tapak Nusantara' }}
          </h1>

          <div class="flex flex-wrap items-center gap-4 text-white/90 text-xs sm:text-sm pt-4 font-medium">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md">
              <span class="material-symbols-outlined text-[16px] text-amber-300">verified</span>
              {{ $hero?->subtitle ?? 'Didokumentasikan sejak 2018' }}
            </span>
            <span class="text-white/70 italic">
              {{ $hero?->image_caption ?? 'Arsip Inisiatif Destinara — Yogyakarta, Magelang, & Enrekang' }}
            </span>
          </div>
        </div>
      </div>
    </section>
    @endif

    <!-- 2. Section Visi-Misi & Manifesto (Modern Minimalist Card) -->
    @if(!$manifesto || $manifesto->is_active)
    <section class="w-full" id="manifesto">
      <div class="bg-white dark:bg-[#1A1D21] rounded-3xl sm:rounded-3xl p-8 sm:p-14 border border-gray-100 dark:border-white/5 shadow-sm text-center flex flex-col items-center">
        <div class="w-12 h-12 rounded-2xl bg-[#1F2B45]/10 text-[#1F2B45] flex items-center justify-center mb-6">
          <span class="material-symbols-outlined text-[26px]">menu_book</span>
        </div>

        <blockquote class="text-xl sm:text-2xl lg:text-3xl font-bold text-[#1A1A1A] dark:text-white max-w-3xl leading-snug tracking-tight" id="filosofi">
          {{ $manifesto?->title ?? '“Pendidikan tidak semestinya datang ke desa sebagai penilai luar, melainkan sebagai tamu yang beradab dan pembelajar yang rendah hati.”' }}
        </blockquote>

        <div class="w-16 h-1 bg-[#1F2B45]/30 rounded-full my-6"></div>

        <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 max-w-2xl leading-relaxed italic">
          {{ $manifesto?->subtitle ?? 'Sebuah pegangan moral yang kami tuangkan dalam setiap penyusunan protokol etika tapak, modul pembekalan siswa, dan interaksi dengan sesepuh adat.' }}
        </p>

        @php
          $manifestoItems = $manifesto?->items ?? [
              ['stat' => __('sections.about.manifesto.stat1'), 'desc' => __('sections.about.manifesto.desc1')],
              ['stat' => __('sections.about.manifesto.stat2'), 'desc' => __('sections.about.manifesto.desc2')],
              ['stat' => __('sections.about.manifesto.stat3'), 'desc' => __('sections.about.manifesto.desc3')]
          ];
        @endphp
        <div class="mt-12 w-full grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach($manifestoItems as $idx => $mItem)
            <div class="bg-gray-50 dark:bg-white/5 rounded-2xl p-6 text-left flex flex-col justify-between border border-transparent hover:border-[#1F2B45]/20 transition-all">
              <span class="text-2xl lg:text-3xl font-extrabold text-[#1F2B45] dark:text-[#8FA8D0] tracking-tight block">
                {{ $mItem['stat'] ?? $mItem['title'] ?? '' }}
              </span>
              <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mt-2 leading-relaxed">
                {{ $mItem['desc'] ?? '' }}
              </p>
            </div>
          @endforeach
        </div>
      </div>
    </section>
    @endif

    <!-- 3. Cerita Pendirian & Rekam Jejak (Clean Split Layout) -->
    @if(!$founder || $founder->is_active)
    <section class="w-full" id="rekam-jejak">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
        <!-- Left: Image & Note -->
        <div class="lg:col-span-5 flex flex-col gap-4">
          <div class="rounded-3xl overflow-hidden shadow-sm border border-gray-100 dark:border-white/5 relative aspect-[4/3] sm:aspect-[16/11]">
            <img class="w-full h-full object-cover" alt="{{ $founder?->title ?? 'Musyawarah etika tapak' }}" src="{{ $founder?->image_url ?? asset('assets/img/hd/about-musyawarah.jpg') }}"/>
          </div>
          <div class="bg-white dark:bg-[#1A1D21] rounded-2xl p-5 border border-gray-100 dark:border-white/5 shadow-xs flex items-start gap-3.5">
            <span class="material-symbols-outlined text-[#1F2B45] text-[22px] shrink-0 mt-0.5">format_quote</span>
            <div>
              <p class="text-xs sm:text-sm text-gray-700 dark:text-gray-200 italic leading-relaxed">
                {{ __('sections.about.founder_story.quote') }}
              </p>
              <span class="text-[11px] font-bold text-gray-400 mt-1 block uppercase tracking-wider">
                {{ __('sections.about.founder_story.quote_author') }}
              </span>
            </div>
          </div>
        </div>

        <!-- Right: Story Essay -->
        <div class="lg:col-span-7 flex flex-col gap-4 bg-white dark:bg-[#1A1D21] rounded-3xl p-8 sm:p-12 border border-gray-100 dark:border-white/5 shadow-sm">
          <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#51634b]">
            <span class="material-symbols-outlined text-[18px]">history_edu</span>
            <span>{{ $founder?->badge ?? 'Latar Belakang & Perjalanan' }}</span>
          </div>

          <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1A1A1A] dark:text-white tracking-tight leading-snug">
            {{ $founder?->title ?? 'Bermula dari Keresahan atas Ekskursi yang Berjarak' }}
          </h2>

          @if($founder?->subtitle)
          <div class="text-sm sm:text-base font-medium text-gray-600 dark:text-gray-300 leading-relaxed">
            {{ $founder->subtitle }}
          </div>
          @endif

          <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 space-y-3 leading-relaxed">
            @if($founder?->content)
              {!! nl2br(e($founder->content)) !!}
            @else
              <p>
                Pada musim kemarau 2018, kami menyaksikan sendiri bagaimana puluhan bus pariwisata berukuran besar memadati jalan-jalan sempit di pedesaan Jawa Tengah. Ratusan pelajar diturunkan hanya untuk berfoto selama dua puluh menit, menginjak pematang sawah yang sedang disemai, lalu berlalu begitu saja.
              </p>
              <p>
                Bagi warga desa, kedatangan massal tersebut meninggalkan tumpukan sampah plastik dan kegaduhan tanpa transfer pengetahuan yang bermakna. Bagi para siswa, kunjungan itu tidak lebih dari tamasya sepintas yang gagal menumbuhkan empati sosio-ekologis maupun pemahaman antropologis yang hakiki.
              </p>
            @endif
          </div>
        </div>
      </div>
    </section>
    @endif

    <!-- 4. Tim Kurator (Clean Modern Card Grid) -->
    <section class="w-full">
      <div class="max-w-2xl mb-8">
        <span class="text-xs font-bold uppercase tracking-wider text-[#51634b] block mb-2">
          {{ __('sections.about.team.tag') }}
        </span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1A1A1A] dark:text-white tracking-tight">
          {{ __('sections.about.team.title') }}
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
          {{ __('sections.about.team.subtitle') }}
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
        @forelse($team as $member)
          <div class="bg-white dark:bg-[#1A1D21] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/5 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all flex flex-col justify-between group">
            <div class="flex flex-col gap-4">
              <div class="flex items-center gap-4">
                <img class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover shrink-0 border border-gray-100 shadow-xs" 
                     alt="{{ $member->name }}" 
                     src="{{ $member->photo_url }}"/>
                <div>
                  <span class="text-[11px] font-bold uppercase tracking-wider text-[#1F2B45] dark:text-[#8FA8D0] block">
                    {{ $member->role }}
                  </span>
                  <h3 class="text-lg font-bold text-[#1A1A1A] dark:text-white mt-0.5">
                    {{ $member->name }}
                  </h3>
                  @if($member->affiliation)
                    <span class="text-xs text-gray-400 italic block">{{ $member->affiliation }}</span>
                  @endif
                </div>
              </div>

              @if($member->bio)
              <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 leading-relaxed pt-2">
                {!! nl2br(e($member->bio)) !!}
              </div>
              @endif
            </div>

            <div class="mt-6 pt-4 border-t border-gray-100 dark:border-white/5 flex items-center justify-between text-xs text-gray-400">
              <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-[15px] text-[#51634b]">location_on</span>
                <span>{{ $member->location ?? 'Sekretariat Destinara' }}</span>
              </div>
              @if($member->email)
                <a href="mailto:{{ $member->email }}" class="text-[#1F2B45] hover:underline font-medium">
                  {{ $member->email }}
                </a>
              @endif
            </div>
          </div>
        @empty
          <p class="text-gray-400 col-span-2 text-center py-8">{{ __('sections.about.team.empty') }}</p>
        @endforelse
      </div>
    </section>

    <!-- 5. Closing CTA Banner (Deep Maroon Corporate Gradient) -->
    <section class="w-full">
      <div class="bg-gradient-to-r from-[#16203A] via-[#16203A] to-[#2E3D5C] text-white rounded-3xl sm:rounded-3xl p-8 sm:p-14 shadow-xl text-center flex flex-col items-center">
        <span class="text-xs font-bold uppercase tracking-wider text-[#D4E9CA] mb-2">
          {{ $gov?->badge ?? __('sections.about.cta.badge') }}
        </span>
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight max-w-xl">
          {{ $gov?->title ?? __('sections.about.cta.title') }}
        </h2>
        <p class="text-xs sm:text-sm text-[#D2D9E3] mt-3 max-w-lg leading-relaxed">
          {{ $gov?->subtitle ?? __('sections.about.cta.subtitle') }}
        </p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
          <a href="{{ $gov?->button_link ?? route('contact.index') }}" 
             class="bg-white text-[#16203A] hover:bg-gray-100 font-bold px-6 py-3 rounded-full text-xs shadow-md transition-all">
            {{ $gov?->button_text ?? __('sections.about.cta.button_text') }}
          </a>
          <a href="{{ route('destinations.index') }}" 
             class="border border-white/30 hover:border-white text-white font-bold px-6 py-3 rounded-2xl text-xs transition-all">
            {{ __('site.common.explore_destinations') }}
          </a>
        </div>
      </div>
    </section>

  </div>
</main>
@endsection
