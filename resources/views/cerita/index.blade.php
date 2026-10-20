@extends('layouts.app')

@section('title', __('site.common.stories_page_title'))
@section('meta_description', __('site.common.stories_page_desc'))
@section('meta_keywords', 'cerita destinara, monograf lapangan, etnobotani nusantara, warta budaya adat, catatan antropologi, arsip pengetahuan tapak')
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
      "name": "{{ __('site.nav.stories') }}",
      "item": "{{ route('stories.index') }}"
    }
  ]
}
</script>
@endpush

@section('content')
<main class="w-full pt-20 sm:pt-24 bg-[#FFFFFF] dark:bg-[#111315] pb-20">
  <div class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-8 space-y-12 sm:space-y-16">

    <!-- Top Header Banner -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-6 border-b border-gray-200/60 dark:border-white/10">
      <div class="space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#1F2B45]/10 text-[#1F2B45] text-xs font-bold uppercase tracking-wider">
          <span class="material-symbols-outlined text-[16px]">menu_book</span>
          <span>{{ __('site.common.field_stories_badge') }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#111827] dark:text-white tracking-tight leading-tight">
          {{ __('site.common.stories_hero_title') }}
        </h1>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 max-w-2xl leading-relaxed">
          {{ __('site.common.stories_hero_desc') }}
        </p>
      </div>

      <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 dark:text-gray-400 shrink-0">
        <span class="w-2.5 h-2.5 rounded-full bg-[#1F2B45]"></span>
        <span>Arsip Catatan Lapangan Terkurasi</span>
      </div>
    </div>

    <!-- Featured Story (Pomaii Hero Article Card) -->
    @if($featuredStory)
    <section class="bg-white dark:bg-[#1A1D21] rounded-3xl p-6 sm:p-10 border border-gray-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
        
        <div class="lg:col-span-7">
          <a href="{{ route('stories.show', $featuredStory->slug) }}" class="block relative w-full aspect-[16/10] rounded-2xl sm:rounded-3xl overflow-hidden group shadow-md">
            <img src="{{ $featuredStory->image_url }}" alt="{{ $featuredStory->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>
          </a>
        </div>

        <div class="lg:col-span-5 flex flex-col justify-between gap-5">
          <div class="space-y-4">
            <div class="flex items-center gap-2 flex-wrap text-xs">
              <span class="px-3 py-1 rounded-full bg-[#1F2B45]/10 text-[#1F2B45] font-bold uppercase tracking-wider">
                {{ $featuredStory->category }}
              </span>
              <span class="text-gray-400">•</span>
              <span class="text-gray-500 dark:text-gray-400 font-medium">{{ $featuredStory->archive_no }}</span>
              <span class="text-gray-400">•</span>
              <span class="text-gray-500 dark:text-gray-400 font-medium">{{ $featuredStory->read_time }}</span>
            </div>

            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#111827] dark:text-white leading-snug tracking-tight">
              <a href="{{ route('stories.show', $featuredStory->slug) }}" class="hover:text-[#1F2B45] transition-colors">
                {{ $featuredStory->title }}
              </a>
            </h2>

            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
              {{ $featuredStory->excerpt }}
            </p>
          </div>

          <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-white/5 text-xs">
            <span class="text-gray-500 dark:text-gray-400 font-medium">
              {{ __('site.common.by_author', ['author' => $featuredStory->author_name]) }}
            </span>
            <a href="{{ route('stories.show', $featuredStory->slug) }}" 
               class="bg-[#1F2B45] hover:bg-[#16203A] text-white px-5 py-2.5 rounded-full text-xs font-bold inline-flex items-center gap-1.5 shadow-xs transition-all">
              <span>{{ __('site.common.read_more') }}</span>
              <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
          </div>
        </div>

      </div>
    </section>
    @endif

    <!-- Stories Grid (Clean Rounded-3xl Cards) -->
    <section class="space-y-8">
      <div class="flex items-center justify-between">
        <div>
          <span class="text-xs font-bold uppercase tracking-wider text-[#1F2B45] block mb-1">
            {{ __('site.common.field_collection_badge') }}
          </span>
          <h3 class="text-2xl font-extrabold text-[#111827] dark:text-white tracking-tight">
            {{ __('site.common.recent_notes_archive') }}
          </h3>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @forelse($stories as $story)
          <article class="bg-white dark:bg-[#1A1D21] rounded-3xl p-4 sm:p-5 border border-gray-100 dark:border-white/5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between group">
            
            <div class="space-y-4">
              <a href="{{ route('stories.show', $story->slug) }}" class="relative w-full aspect-[16/10] overflow-hidden block rounded-2xl shadow-sm">
                <img src="{{ $story->image_url }}" alt="{{ $story->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/90 backdrop-blur-md text-[#1F2B45] text-[11px] font-bold uppercase tracking-wider shadow-xs">
                  {{ $story->category }}
                </div>
              </a>

              <div class="space-y-2">
                <div class="flex items-center gap-2 text-[11px] text-gray-500 dark:text-gray-400 font-medium">
                  <span>{{ $story->read_time }}</span>
                  <span>•</span>
                  <span>{{ $story->published_at ? $story->published_at->translatedFormat('d M Y') : '' }}</span>
                </div>

                <h4 class="text-base sm:text-lg font-bold text-[#111827] dark:text-white leading-snug group-hover:text-[#1F2B45] transition-colors">
                  <a href="{{ route('stories.show', $story->slug) }}">
                    {{ $story->title }}
                  </a>
                </h4>

                <p class="text-xs text-gray-600 dark:text-gray-300 line-clamp-3 leading-relaxed">
                  {{ $story->excerpt }}
                </p>
              </div>
            </div>

            <div class="pt-4 mt-4 border-t border-gray-100 dark:border-white/5 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
              <span class="font-medium truncate">{{ $story->author_name }}</span>
              <a href="{{ route('stories.show', $story->slug) }}" class="text-[#1F2B45] font-bold hover:underline shrink-0">
                Baca →
              </a>
            </div>

          </article>
        @empty
          <div class="col-span-3 text-center py-16 bg-white dark:bg-[#1A1D21] rounded-3xl border border-gray-100 dark:border-white/5">
            <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">article</span>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('site.common.no_stories') }}</p>
          </div>
        @endforelse
      </div>

      <div class="pt-6">
        {{ $stories->links() }}
      </div>
    </section>

  </div>
</main>
@endsection
