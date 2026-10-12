@extends('layouts.app')

@section('title', $destination->name . ' — ' . $destination->location . ' | Destinara')
@section('meta_description', Str::limit(strip_tags($destination->description ?? ($destination->name . ' di ' . $destination->location . '. Tapak belajar budaya terkurasi bersama Destinara.')), 155))
@section('meta_keywords', $destination->name . ', ' . $destination->location . ', ' . ($destination->badge ?? '') . ', tapak edukasi, desa adat, wisata budaya nusantara, destinara')
@section('og_image', $destination->image_url ?? asset('assets/img/hd/hero-fieldwork.jpg'))

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
          "name": "{{ __('site.nav.destinations') }}",
          "item": "{{ route('destinations.index') }}"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "{{ addslashes($destination->name) }}",
          "item": "{{ url()->current() }}"
        }
      ]
    },
    {
      "@type": "TouristDestination",
      "@id": "{{ url()->current() }}#destination",
      "name": "{{ addslashes($destination->name) }}",
      "description": "{{ addslashes(Str::limit(strip_tags($destination->description ?? ''), 250)) }}",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "{{ addslashes($destination->location) }}",
        "addressCountry": "ID"
      },
      "image": "{{ $destination->image_url ?? asset('assets/img/hd/hero-fieldwork.jpg') }}",
      "touristType": [
        "CulturalTourism",
        "EducationalTourism"
      ]
    }
  ]
}
</script>
@endpush

@section('content')
<main class="w-full pt-20 sm:pt-24 bg-[#FAF7F5] dark:bg-[#140E0D] pb-20">
  <div class="flex flex-col w-full">

    <!-- Header Dossier Top -->
    <section class="w-full max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-8 pt-8 sm:pt-12 pb-6">
      <div class="flex flex-col gap-4">
        
        <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#703A3A] hover:underline self-start">
          <span class="material-symbols-outlined text-[16px]">arrow_back</span>
          <span>{{ __('site.common.back_to_index') }}</span>
        </a>

        <div class="flex items-center gap-2 flex-wrap pt-1">
          <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#51634b]/10 text-[#51634b] uppercase tracking-wider">
            {{ $destination->location }}
          </span>
          @if($destination->badge)
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#703A3A]/10 text-[#703A3A] uppercase tracking-wider">
              {{ $destination->badge }}
            </span>
          @endif
          <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-white/10 text-gray-600 dark:text-gray-300 uppercase tracking-wider">
            {{ $destination->category }}
          </span>
        </div>

        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#1E1B1B] dark:text-white tracking-tight leading-tight">
          {{ $destination->name }}
        </h1>

        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 max-w-3xl leading-relaxed">
          {{ $destination->lead ?? Str::limit(strip_tags($destination->description), 180) }}
        </p>

      </div>
    </section>

    <!-- Main Content & Details Grid -->
    <section class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
        
        <!-- Left Content Column -->
        <div class="lg:col-span-8 flex flex-col gap-8">
          
          <!-- Image Visual Container -->
          <div class="relative w-full aspect-[16/10] sm:aspect-[16/9] rounded-3xl overflow-hidden bg-gray-100 shadow-md">
            <img src="{{ $destination->image_url }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
          </div>

          <!-- Description Block -->
          <div class="bg-white dark:bg-[#1F1716] p-6 sm:p-8 rounded-3xl border border-gray-100 dark:border-white/5 shadow-sm flex flex-col gap-4">
            <h3 class="text-xl font-bold text-[#1E1B1B] dark:text-white">
              {{ __('site.common.site_narrative_context') }}
            </h3>
            <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
              {!! nl2br(e($destination->description)) !!}
            </div>
          </div>

          @if($destination->research_focus)
            <!-- Research Focus Highlight -->
            <div class="p-6 bg-white dark:bg-[#1F1716] rounded-3xl border border-gray-100 dark:border-white/5 shadow-sm flex flex-col gap-2">
              <span class="text-xs font-bold uppercase tracking-wider text-[#51634b] flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">biotech</span>
                <span>{{ __('site.common.research_learning_focus') }}</span>
              </span>
              <p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed">
                {{ $destination->research_focus }}
              </p>
            </div>
          @endif

        </div>

        <!-- Right Sticky Booking / Information Card -->
        <div class="lg:col-span-4 flex flex-col gap-6 sticky top-28">
          <div class="bg-white dark:bg-[#1F1716] p-6 sm:p-7 rounded-3xl border border-gray-100 dark:border-white/5 shadow-xl flex flex-col gap-5">
            
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-white/5">
              <h4 class="text-base font-bold text-[#1E1B1B] dark:text-white">
                {{ __('site.common.dossier_summary') }}
              </h4>
              <span class="inline-flex items-center gap-1 text-xs font-semibold text-[#51634b]">
                <span class="w-2 h-2 rounded-full bg-[#51634b]"></span>
                <span>Terverifikasi</span>
              </span>
            </div>

            <div class="flex flex-col gap-3.5 text-xs">
              <div class="flex items-start justify-between py-1 border-b border-gray-50 dark:border-white/5">
                <span class="text-gray-500 dark:text-gray-400">{{ __('site.common.administrative_location') }}</span>
                <span class="font-bold text-[#1E1B1B] dark:text-white text-right">{{ $destination->location }}</span>
              </div>
              <div class="flex items-start justify-between py-1 border-b border-gray-50 dark:border-white/5">
                <span class="text-gray-500 dark:text-gray-400">{{ __('site.common.landscape_category') }}</span>
                <span class="font-bold text-[#1E1B1B] dark:text-white uppercase">{{ $destination->category }}</span>
              </div>
              <div class="flex items-start justify-between py-1 border-b border-gray-50 dark:border-white/5">
                <span class="text-gray-500 dark:text-gray-400">{{ __('site.common.field_learning_module') }}</span>
                <span class="font-bold text-[#1E1B1B] dark:text-white text-right">{{ $destination->module_name ?? __('site.common.contextual_curriculum') }}</span>
              </div>
              <div class="flex items-start justify-between py-1 border-b border-gray-50 dark:border-white/5">
                <span class="text-gray-500 dark:text-gray-400">{{ __('site.common.max_group_capacity') }}</span>
                <span class="font-bold text-[#51634b]">{{ $destination->capacity ?? __('site.common.default_capacity_range') }}</span>
              </div>
              <div class="flex items-start justify-between py-1">
                <span class="text-gray-500 dark:text-gray-400">{{ __('site.common.cultural_protocol') }}</span>
                <span class="font-bold text-[#703A3A]">{{ __('site.common.fpic_verified_badge') }}</span>
              </div>
            </div>

            <div class="pt-2 flex flex-col gap-3">
              <a href="{{ route('contact.index') }}" 
                 class="w-full bg-[#703A3A] hover:bg-[#561D1E] text-white py-3.5 px-4 rounded-full text-xs font-bold text-center block shadow-md hover:shadow-xl transition-all">
                <span>{{ __('site.common.apply_program_here') }}</span>
              </a>
              <a href="https://wa.me/{{ \App\Models\SiteSetting::get('contact_whatsapp', '6282116200363') }}?text={{ urlencode('Halo Destinara, saya tertarik dengan tapak ' . $destination->name . ' untuk program lapangan.') }}" 
                 target="_blank" 
                 rel="noopener noreferrer" 
                 class="w-full bg-white dark:bg-[#1F1716] border border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5 text-[#2B211E] dark:text-white py-3 px-4 rounded-full text-xs font-bold text-center flex items-center justify-center gap-2 transition-all">
                <span class="material-symbols-outlined text-[18px] text-[#51634b]">chat</span>
                <span>{{ __('site.common.consult_whatsapp') }}</span>
              </a>
            </div>

          </div>
        </div>

      </div>
    </section>

    @if(isset($related) && $related->count() > 0)
    <!-- Related Destinations Section -->
    <section class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full border-t border-gray-100 dark:border-white/10 mt-6">
      <div class="flex items-center justify-between mb-6">
        <div>
          <span class="text-xs font-bold uppercase tracking-wider text-[#51634b] block mb-1">
            {{ __('site.common.curated_destinations') }}
          </span>
          <h3 class="text-2xl font-extrabold text-[#1E1B1B] dark:text-white tracking-tight">
            {{ __('site.common.related_destinations') }}
          </h3>
        </div>
        <a href="{{ route('destinations.index') }}" class="text-xs font-bold text-[#703A3A] hover:underline flex items-center gap-1">
          <span>{{ __('site.common.view_all_destinations') }}</span>
          <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
        </a>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($related as $rel)
          <div class="bg-white dark:bg-[#1F1716] rounded-3xl p-3.5 shadow-sm hover:shadow-xl border border-gray-100 dark:border-white/5 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between group">
            <div>
              <div class="relative w-full aspect-[16/11] rounded-2xl overflow-hidden bg-gray-100 mb-3">
                <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute top-3 left-3 flex gap-1.5 flex-wrap">
                  <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-black/60 backdrop-blur-md text-white uppercase tracking-wider">
                    {{ $rel->location }}
                  </span>
                </div>
              </div>
              <h4 class="text-base font-bold text-[#1E1B1B] dark:text-white group-hover:text-[#703A3A] transition-colors leading-snug mb-1">
                {{ $rel->name }}
              </h4>
              <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                {{ $rel->lead ?? Str::limit(strip_tags($rel->description), 90) }}
              </p>
            </div>
            <div class="pt-4 mt-3 border-t border-gray-50 dark:border-white/5 flex items-center justify-between">
              <span class="text-xs font-bold text-[#51634b]">
                {{ $rel->capacity ?? '20-30 Peserta' }}
              </span>
              <a href="{{ route('destinations.show', $rel->slug) }}" class="text-xs font-bold text-[#703A3A] group-hover:underline flex items-center gap-1">
                <span>{{ __('site.common.read_more') }}</span>
                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
              </a>
            </div>
          </div>
        @endforeach
      </div>
    </section>
    @endif

  </div>
</main>
@endsection
