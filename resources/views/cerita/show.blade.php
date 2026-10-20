@extends('layouts.app')

@section('title', $story->title . ' — Destinara')
@section('meta_description', Str::limit(strip_tags($story->excerpt ?? $story->content ?? $story->title), 155))
@section('meta_keywords', ($story->category ?? 'Warta Tapak') . ', ' . ($story->author_name ?? 'Destinara') . ', monograf lapangan, etnografi nusantara, kearifan lokal, destinara')
@section('og_type', 'article')
@section('og_image', $story->image_url ?? asset('assets/img/hd/hero-about.jpg'))

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@graph": [
    {
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
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "{{ addslashes($story->title) }}",
          "item": "{{ url()->current() }}"
        }
      ]
    },
    {
      "@type": "Article",
      "@id": "{{ url()->current() }}#article",
      "headline": "{{ addslashes($story->title) }}",
      "description": "{{ addslashes(Str::limit(strip_tags($story->excerpt ?? $story->content ?? ''), 250)) }}",
      "image": "{{ $story->image_url ?? asset('assets/img/hd/hero-about.jpg') }}",
      "author": {
        "@type": "Person",
        "name": "{{ addslashes($story->author_name ?? __('site.common.destinara_curator')) }}"
      },
      "publisher": {
        "@id": "{{ url('/') }}/#organization"
      },
      "datePublished": "{{ ($story->published_at ?? $story->created_at)->toIso8601String() }}",
      "dateModified": "{{ $story->updated_at->toIso8601String() }}",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ url()->current() }}"
      }
    }
  ]
}
</script>
@endpush

@section('content')
<main class="w-full pt-20 sm:pt-24 bg-[#FFFFFF] dark:bg-[#140E0D] pb-20">
  <div class="max-w-[1000px] mx-auto px-4 sm:px-6 lg:px-8 space-y-8 sm:space-y-10">

    <!-- Top Navigation & Breadcrumb -->
    <div class="flex items-center justify-between pt-4">
      <a href="{{ route('stories.index') }}" 
         class="inline-flex items-center gap-2 text-xs font-bold text-[#1F2B45] bg-white dark:bg-[#1E1716] px-4 py-2 rounded-full border border-gray-100 dark:border-white/5 shadow-xs hover:shadow-md transition-all">
        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
        <span>{{ __('site.common.back_to_stories') }}</span>
      </a>

      <div class="flex items-center gap-2">
        <span class="px-3 py-1 rounded-full bg-[#1F2B45]/10 text-[#1F2B45] text-xs font-bold uppercase tracking-wider">
          {{ $story->category }}
        </span>
        <span class="text-xs text-gray-500 dark:text-gray-400 font-medium hidden sm:inline">
          {{ $story->read_time }}
        </span>
      </div>
    </div>

    <!-- Article Header Card -->
    <header class="bg-white dark:bg-[#1E1716] rounded-3xl p-6 sm:p-10 border border-gray-100 dark:border-white/5 shadow-sm space-y-4">
      <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 font-medium">
        <span>{{ $story->archive_no }}</span>
        <span>•</span>
        <span>{{ $story->read_time }}</span>
      </div>

      <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#1E1B1B] dark:text-white tracking-tight leading-tight">
        {{ $story->title }}
      </h1>

      <div class="flex items-center gap-3 pt-3 border-t border-gray-100 dark:border-white/5 text-xs text-gray-600 dark:text-gray-400">
        <span class="font-bold text-[#1E1B1B] dark:text-white">{{ $story->author_name }}</span>
        @if($story->author_role)
          <span>•</span>
          <span>{{ $story->author_role }}</span>
        @endif
        <span>•</span>
        <span>{{ $story->published_at ? $story->published_at->translatedFormat('d M Y') : now()->translatedFormat('d M Y') }}</span>
      </div>
    </header>

    <!-- Main Hero Image Plate -->
    <div class="relative w-full aspect-[16/9] rounded-3xl overflow-hidden shadow-md bg-gray-100">
      <img src="{{ $story->image_url }}" alt="{{ $story->title }}" class="w-full h-full object-cover">
    </div>

    <!-- Article Body Card -->
    <article class="bg-white dark:bg-[#1E1716] rounded-3xl p-8 sm:p-12 border border-gray-100 dark:border-white/5 shadow-sm space-y-8">
      <div class="prose prose-lg max-w-none text-sm sm:text-base text-gray-700 dark:text-gray-200 leading-relaxed space-y-6">
        @if($story->content)
          {!! $story->content !!}
        @else
          <p>{{ $story->excerpt }}</p>
        @endif
      </div>

      <!-- Article Footer Consultation Bar -->
      <div class="pt-8 border-t border-gray-100 dark:border-white/5 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
        <div class="text-xs text-gray-500 dark:text-gray-400 italic">
          {{ __('site.common.archived_in_knowledge') }}
        </div>
        <a href="{{ route('contact.index') }}" 
           class="bg-[#1F2B45] hover:bg-[#16203A] text-white px-6 py-3 rounded-full text-xs font-bold text-center shadow-md hover:shadow-xl transition-all">
          {{ __('site.common.discuss_this_topic') }}
        </a>
      </div>
    </article>

  </div>
</main>
@endsection
