@extends('layouts.app')

@section('title', __('site.common.curated_destinations') . ' | Destinara')
@section('meta_description', __('site.common.curated_destinations_desc'))
@section('meta_keywords', 'destinasi desa wisata, desa adat nusantara, direktori tapak edukasi, tempat study tour budaya, live in desa wisata, destinara destinasi')
@section('og_image', asset('assets/img/hd/hero-fieldwork.jpg'))

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
      "name": "{{ __('site.nav.destinations') }}",
      "item": "{{ route('destinations.index') }}"
    }
  ]
}
</script>
@endpush

@section('content')
<main class="w-full pt-20 sm:pt-24 bg-[#FFFFFF] dark:bg-[#0A0A0A] pb-20">
  <div class="flex flex-col w-full">
    
    <!-- Header Banner -->
    <section class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-8 w-full pt-8 sm:pt-12 pb-4">
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-6 border-b border-gray-200/60 dark:border-white/10">
        <div>
          <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#51634b]/10 text-[#51634b] text-xs font-bold uppercase tracking-wider rounded-full mb-3">
            <span class="w-1.5 h-1.5 rounded-full bg-[#51634b]"></span>
            <span>Katalog Tapak Terkurasi {{ date('Y') }}</span>
          </div>
          <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#111827] dark:text-white tracking-tight">
            {{ __('site.common.curated_destinations') }}
          </h1>
          <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 max-w-2xl leading-relaxed">
            {{ __('site.common.curated_destinations_desc') }}
          </p>
        </div>

        <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 dark:text-gray-400 shrink-0">
          <span class="w-2.5 h-2.5 rounded-full bg-[#51634b]"></span>
          <span>{{ $destinations->count() }} Tapak Aktif Terkurasi</span>
        </div>
      </div>

      <!-- Search & Category Filters Bar (Modern Traveloka Floating Filter) -->
      <div class="mt-6 bg-white dark:bg-[#141414] p-4 rounded-2xl sm:rounded-full border border-gray-100 dark:border-white/10 shadow-sm flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
        
        <!-- Category Filter Pills -->
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1 w-full flex-nowrap">
          <a href="{{ route('destinations.index') }}" 
             class="px-4 py-2 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all whitespace-nowrap {{ !request('category') || request('category') === 'all' ? 'bg-[#1F2B45] text-white shadow-xs' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5' }}">
            {{ __('site.common.all_regions') }}
          </a>
          <a href="{{ route('destinations.index', ['category' => 'budaya']) }}" 
             class="px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wider transition-all whitespace-nowrap {{ request('category') === 'budaya' ? 'bg-[#1F2B45] text-white shadow-xs' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5' }}">
            🏛️ {{ __('site.common.cat_culture') }}
          </a>
          <a href="{{ route('destinations.index', ['category' => 'ekologi']) }}" 
             class="px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wider transition-all whitespace-nowrap {{ request('category') === 'ekologi' ? 'bg-[#1F2B45] text-white shadow-xs' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5' }}">
            🌱 {{ __('site.common.cat_ecology') }}
          </a>
          <a href="{{ route('destinations.index', ['category' => 'pangan']) }}" 
             class="px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wider transition-all whitespace-nowrap {{ request('category') === 'pangan' ? 'bg-[#1F2B45] text-white shadow-xs' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5' }}">
            🌾 {{ __('site.common.cat_food') }}
          </a>
          <a href="{{ route('destinations.index', ['category' => 'bahari']) }}" 
             class="px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wider transition-all whitespace-nowrap {{ request('category') === 'bahari' ? 'bg-[#1F2B45] text-white shadow-xs' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5' }}">
            🌊 {{ __('site.common.cat_marine') }}
          </a>
        </div>

        <!-- Quick Keyword Search -->
        <form action="{{ route('destinations.index') }}" method="GET" class="shrink-0 flex items-center gap-2">
          @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
          @endif
          <div class="relative w-full sm:w-64">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama tapak..." 
                   class="w-full pl-9 pr-4 py-2 text-xs bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-full text-[#111827] dark:text-white placeholder-gray-400 focus:outline-none focus:border-[#1F2B45]">
            <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-400 text-[16px]">search</span>
          </div>
          <button type="submit" class="bg-[#1F2B45] text-white px-4 py-2 rounded-2xl text-xs font-bold shrink-0 hover:bg-[#16203A] transition-colors">
            Cari
          </button>
        </form>

      </div>
    </section>

    <!-- Modern Destination Cards Grid (Clean, Rounded-3xl, Minimal Text) -->
    <section class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-8 mt-8 w-full">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @forelse($destinations as $dest)
          <div class="bg-white dark:bg-[#141414] rounded-3xl p-3.5 shadow-sm hover:shadow-xl border border-gray-100 dark:border-white/5 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between group">
            
            <div>
              <!-- Image Container -->
              <div class="relative w-full aspect-[16/11] rounded-2xl overflow-hidden bg-gray-100 mb-3">
                
                @if(!empty($dest->rating) && $dest->rating > 0)
                <!-- Floating Rating Pill (Frosted Glass) -->
                <div class="absolute top-3 left-3 z-10 bg-black/50 backdrop-blur-md text-white text-xs px-2.5 py-1 rounded-full font-bold flex items-center gap-1 shadow-xs">
                  <span class="text-amber-400 text-[13px]">★</span>
                  <span>{{ number_format($dest->rating, 1) }}</span>
                </div>
                @endif

                <!-- Location Pill -->
                <div class="absolute top-3 right-3 z-10 bg-white/90 dark:bg-[#141414]/90 backdrop-blur-md text-[#1F2937] dark:text-white text-[11px] font-semibold px-2.5 py-1 rounded-full shadow-xs">
                  {{ $dest->location ?? 'Indonesia' }}
                </div>

                <img src="{{ $dest->thumbnail_url ?? ($dest->cover_url ?? ($dest->image_url ?? asset('assets/img/hd/hero-fieldwork.jpg'))) }}" 
                     alt="{{ $dest->name ?? 'Destinasi' }}" 
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-106"/>
                
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent pointer-events-none"></div>

                <!-- Title Overlay inside Image -->
                <div class="absolute bottom-3 inset-x-3 text-white">
                  <h2 class="text-lg font-bold drop-shadow-sm leading-snug">
                    <a href="{{ route('destinations.show', $dest->slug) }}" class="hover:underline">
                      {{ $dest->name }}
                    </a>
                  </h2>
                </div>
              </div>

              <!-- Body Info: Clean & Concise -->
              <div class="px-2 pb-2">
                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed mb-3">
                  {{ $dest->lead ?? (isset($dest->description) ? Str::limit(strip_tags($dest->description), 100) : '') }}
                </p>

                @if(!empty($dest->research_focus))
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-300 text-[11px] rounded-full font-medium">
                  <span class="material-symbols-outlined text-[14px] text-[#51634b]">biotech</span>
                  <span class="truncate max-w-[200px]">{{ $dest->research_focus }}</span>
                </div>
                @endif
              </div>
            </div>

            <!-- Footer: Capacity & CTA Button -->
            <div class="px-2 pt-3 border-t border-gray-100 dark:border-white/5 flex items-center justify-between mt-2">
              <div class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                <span class="material-symbols-outlined text-[16px] text-[#51634b]">group</span>
                <span>{{ $dest->capacity ?? 'Terkurasi' }}</span>
              </div>

              <a href="{{ route('destinations.show', $dest->slug) }}" 
                 class="bg-[#1F2B45] hover:bg-[#16203A] text-white px-4 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-1.5 shadow-xs">
                <span>Buka Silabus</span>
                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
              </a>
            </div>

          </div>
        @empty
          <div class="col-span-1 sm:col-span-2 lg:col-span-3 py-16 text-center text-gray-500 bg-white dark:bg-[#141414] rounded-3xl p-8 border border-gray-100 dark:border-white/5">
            <span class="material-symbols-outlined text-4xl text-gray-400 mb-2">search_off</span>
            <p class="text-sm font-semibold">{{ __('site.common.no_destinations') }}</p>
            <a href="{{ route('destinations.index') }}" class="inline-block mt-3 text-xs font-bold text-[#1F2B45] hover:underline">{{ __('site.common.back_to_all') }}</a>
          </div>
        @endforelse
      </div>
    </section>

  </div>
</main>
@endsection
