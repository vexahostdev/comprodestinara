@extends('layouts.app')

@section('title', __('site.legal.terms_title') . ' — ' . \App\Models\SiteSetting::get('company_legal_name', 'PT Destinara Chakrawal Artha'))
@section('meta_description', __('site.legal.terms_meta_desc'))
@section('meta_keywords', __('site.legal.terms_meta_keywords'))

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
      "name": "{{ __('site.legal.terms_title') }}",
      "item": "{{ route('legal.terms') }}"
    }
  ]
}
</script>
@endpush

@section('content')
<main class="w-full pt-20 sm:pt-24 bg-[#FFFFFF] dark:bg-[#140E0D] pb-20">
  <div class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 py-2 text-xs text-gray-500 dark:text-gray-400">
      <a href="{{ url('/') }}" class="hover:text-[#1F2B45] transition-colors">{{ __('site.nav.home') }}</a>
      <span>/</span>
      <span class="text-[#1E1B1B] dark:text-white font-medium">{{ __('site.legal.terms_title') }}</span>
    </nav>

    <!-- Header Dokumen Card -->
    <div class="bg-white dark:bg-[#1E1716] rounded-3xl p-6 sm:p-10 border border-gray-100 dark:border-white/5 shadow-sm space-y-6">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-3 max-w-3xl">
          <div class="flex items-center gap-2">
            <span class="px-3 py-1 text-[11px] uppercase tracking-wider font-bold rounded-full bg-[#1F2B45]/10 text-[#1F2B45]">
              {{ __('site.legal.official_legal_doc') }}
            </span>
            <span class="text-xs text-gray-400 font-medium">{{ __('site.legal.version') }} {{ $doc['version'] }}</span>
          </div>
          <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#1E1B1B] dark:text-white tracking-tight">
            {{ __('site.legal.terms_title') }}
          </h1>
          <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
            {!! __('site.legal.terms_intro', ['company' => \App\Models\SiteSetting::get('company_legal_name', 'PT DESTINARA CHAKRAWAL ARTHA')]) !!}
          </p>
        </div>

        <!-- Tombol Aksi Dokumen -->
        <div class="flex flex-wrap sm:flex-nowrap md:flex-col items-stretch sm:items-center md:items-end gap-3 shrink-0">
          <a href="{{ $streamUrl }}" target="_blank" rel="noopener noreferrer" 
             class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gray-50 dark:bg-white/5 hover:bg-gray-100 text-gray-700 dark:text-gray-200 rounded-full text-xs font-bold transition-all shadow-xs">
            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
            <span>{{ __('site.legal.open_new_tab') }}</span>
          </a>
          <a href="{{ $downloadUrl }}" 
             class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#1F2B45] hover:bg-[#16203A] text-white rounded-full text-xs font-bold transition-all shadow-sm">
            <span class="material-symbols-outlined text-[16px]">download</span>
            <span>{{ __('site.legal.download_pdf_copy') }}</span>
          </a>
        </div>
      </div>

      <!-- Navigasi Dokumen Terkait -->
      <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-white/5 text-xs flex-wrap">
        <span class="text-gray-400 font-medium">{{ __('site.legal.related_docs') }}:</span>
        <span class="font-bold text-[#1F2B45] flex items-center gap-1.5">
          <span class="material-symbols-outlined text-[15px]">description</span>
          <span>{{ __('site.footer.terms') }}</span>
        </span>
        <span class="text-gray-300">•</span>
        <a href="{{ route('legal.privacy') }}" class="text-gray-600 dark:text-gray-300 hover:text-[#1F2B45] transition-colors flex items-center gap-1.5 font-medium">
          <span class="material-symbols-outlined text-[15px]">shield</span>
          <span>{{ __('site.footer.privacy') }}</span>
        </a>
        <span class="text-gray-300">•</span>
        <a href="{{ route('legal.privacy.en') }}" class="text-gray-600 dark:text-gray-300 hover:text-[#1F2B45] transition-colors flex items-center gap-1.5 font-medium">
          <span class="material-symbols-outlined text-[15px]">translate</span>
          <span>{{ __('site.footer.privacy_en') }}</span>
        </a>
      </div>
    </div>

    <!-- PDF Viewer Container -->
    <div id="pdfViewerCard" class="bg-white dark:bg-[#1E1716] rounded-3xl border border-gray-100 dark:border-white/5 shadow-sm overflow-hidden transition-all duration-200">
      <div class="px-5 py-3.5 bg-gray-50 dark:bg-white/5 border-b border-gray-100 dark:border-white/5 flex items-center justify-between text-xs text-gray-600 dark:text-gray-300 flex-wrap gap-2">
        <div class="flex items-center gap-2 font-medium">
          <span class="material-symbols-outlined text-base text-[#51634b]">verified</span>
          <span>{{ $doc['filename'] }}</span>
          <span class="hidden md:inline text-[11px] text-gray-400 font-normal">({{ __('site.legal.view_scale') }})</span>
        </div>
        <div class="flex items-center gap-2">
          <button type="button" onclick="togglePdfFullscreen('pdfViewerCard')" 
                  class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-[#1E1716] rounded-full border border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-200 hover:text-[#1F2B45] font-semibold transition-all shadow-xs cursor-pointer"
                  title="{{ __('site.legal.fullscreen') }}">
            <span class="material-symbols-outlined text-base" id="fullscreenIcon">fullscreen</span>
            <span id="fullscreenText">{{ __('site.legal.fullscreen') }}</span>
          </button>
          <a href="{{ $streamUrl }}#zoom=80&navpanes=1&pagemode=bookmarks" target="_blank" rel="noopener noreferrer" 
             class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-[#1E1716] rounded-full border border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-200 hover:text-[#1F2B45] font-semibold transition-all shadow-xs"
             title="{{ __('site.legal.full_tab') }}">
            <span class="material-symbols-outlined text-base">open_in_new</span>
            <span>{{ __('site.legal.full_tab') }}</span>
          </a>
        </div>
      </div>

      <!-- Frame Viewer -->
      <div id="pdfFrameWrapper" class="relative w-full h-[78vh] md:h-[88vh] lg:h-[92vh] bg-[#525659]">
        <iframe 
          id="pdfFrame"
          src="{{ $streamUrl }}#zoom=80&toolbar=1&navpanes=1&pagemode=bookmarks" 
          type="application/pdf"
          class="w-full h-full border-0"
          allowfullscreen
          title="{{ $doc['title_id'] }}">
          
          <div class="p-8 text-center flex flex-col items-center justify-center h-full gap-4 text-white">
            <span class="material-symbols-outlined text-4xl text-[#D4E9CA]">picture_as_pdf</span>
            <p class="font-medium text-sm">
              {{ __('site.legal.browser_not_supported') }}
            </p>
            <div class="flex items-center gap-3">
              <a href="{{ $streamUrl }}" target="_blank" class="px-5 py-2.5 bg-[#1F2B45] text-white rounded-full text-xs font-bold">
                {{ __('site.legal.open_pdf') }}
              </a>
              <a href="{{ $downloadUrl }}" class="px-5 py-2.5 border border-white/30 text-white rounded-full text-xs font-bold">
                {{ __('site.legal.download_file') }}
              </a>
            </div>
          </div>
        </iframe>
      </div>
    </div>

    <!-- Catatan Penutup Card -->
    <div class="p-5 bg-white dark:bg-[#1E1716] rounded-2xl border border-gray-100 dark:border-white/5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-xs text-gray-500 dark:text-gray-400">
      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-base text-[#51634b]">verified_user</span>
        <span>
          {{ __('site.legal.official_terms_bound') }}
        </span>
      </div>
      <div>
        <span>{{ __('site.legal.legal_support') }}</span>
        <a href="mailto:{{ \App\Models\SiteSetting::get('contact_email_partnership', 'partnership@destinara.id') }}" class="font-bold text-[#1F2B45] hover:underline">
          {{ \App\Models\SiteSetting::get('contact_email_partnership', 'partnership@destinara.id') }}
        </a>
      </div>
    </div>

  </div>
</main>

@push('scripts')
<script>
  function togglePdfFullscreen(cardId) {
    const card = document.getElementById(cardId);
    if (!document.fullscreenElement && !document.webkitFullscreenElement) {
      if (card.requestFullscreen) {
        card.requestFullscreen();
      } else if (card.webkitRequestFullscreen) {
        card.webkitRequestFullscreen();
      } else if (card.msRequestFullscreen) {
        card.msRequestFullscreen();
      }
    } else {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      }
    }
  }

  function updateFullscreenUI() {
    const isFs = !!(document.fullscreenElement || document.webkitFullscreenElement);
    const icon = document.getElementById('fullscreenIcon');
    const text = document.getElementById('fullscreenText');
    const frameWrapper = document.getElementById('pdfFrameWrapper');
    if (icon) icon.textContent = isFs ? 'fullscreen_exit' : 'fullscreen';
    if (text) text.textContent = isFs ? '{{ __('site.legal.exit_fullscreen') }}' : '{{ __('site.legal.fullscreen') }}';
    if (frameWrapper) {
      frameWrapper.style.height = isFs ? 'calc(100vh - 52px)' : '';
    }
  }

  document.addEventListener('fullscreenchange', updateFullscreenUI);
  document.addEventListener('webkitfullscreenchange', updateFullscreenUI);
</script>
@endpush
@endsection
