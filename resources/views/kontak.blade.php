@extends('layouts.app')

@section('title', ($hero?->title ?? __('sections.contact.hero.title')) . ' — ' . __('site.nav.contact_full') . ' | Destinara')
@section('meta_description', $hero?->subtitle ?? __('sections.contact.hero.subtitle'))
@section('meta_keywords', 'kontak destinara, narahubung destinara, konsultasi study tour edukasi, kantor destinara yogyakarta jakarta, kemitraan desa')
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
      "name": "{{ __('site.nav.contact') }}",
      "item": "{{ route('contact.index') }}"
    }
  ]
}
</script>
@endpush

@section('content')
@php
  $hero = $sections['hero'] ?? null;
  $officeHours = $sections['office_hours'] ?? null;
@endphp
<main class="w-full pt-20 sm:pt-24 bg-[#FFFFFF] dark:bg-[#0A0A0A] pb-20">
  <div class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-8 space-y-12 sm:space-y-16">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-6 border-b border-gray-200/60 dark:border-white/10">
      <div class="space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#1F2B45]/10 text-[#1F2B45] text-xs font-bold uppercase tracking-wider">
          <span class="w-2 h-2 rounded-full bg-[#1F2B45]"></span>
          <span>{{ $hero?->badge ?? __('sections.contact.hero.badge') }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#111827] dark:text-white tracking-tight leading-tight">
          {{ $hero?->title ?? __('sections.contact.hero.title') }}
        </h1>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 max-w-2xl leading-relaxed">
          {{ $hero?->subtitle ?? __('sections.contact.hero.subtitle') }}
        </p>
      </div>

      <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 dark:text-gray-400 shrink-0">
        <span class="w-2.5 h-2.5 rounded-full bg-[#51634b]"></span>
        <span>Respons Aktif Senin–Sabtu</span>
      </div>
    </div>

    <!-- Form & Narahubung Grid (Split 2-Kolom Modern Pomaii) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
      
      <!-- Kolom Kiri: Formulir Konsultasi -->
      <div class="lg:col-span-6 bg-white dark:bg-[#141414] p-8 sm:p-10 rounded-3xl border border-gray-100 dark:border-white/5 shadow-sm space-y-6">
        <div>
          <span class="text-xs font-bold uppercase tracking-wider text-[#1F2B45]">
            {{ __('sections.contact.form.tag') }}
          </span>
          <h2 class="text-2xl font-extrabold text-[#111827] dark:text-white tracking-tight mt-1">
            {{ __('sections.contact.form.title') }}
          </h2>
          <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ __('sections.contact.form.subtitle') }}
          </p>
        </div>

        <form class="space-y-4" id="form-konsultasi" action="{{ route('contact.send') }}" method="POST">
          @csrf
          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5" for="full_name">
              {{ __('sections.contact.form.name_label') }} <span class="text-[#1F2B45]">*</span>
            </label>
            <input class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-xs sm:text-sm text-[#111827] dark:text-white placeholder-gray-400 focus:outline-none focus:border-[#1F2B45] transition-all" 
                   id="full_name" name="full_name" value="{{ old('full_name') }}" 
                   placeholder="{{ __('sections.contact.form.name_placeholder') }}" required type="text"/>
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5" for="institution">
              {{ __('sections.contact.form.inst_label') }} <span class="text-[#1F2B45]">*</span>
            </label>
            <input class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-xs sm:text-sm text-[#111827] dark:text-white placeholder-gray-400 focus:outline-none focus:border-[#1F2B45] transition-all" 
                   id="institution" name="institution" value="{{ old('institution') }}" 
                   placeholder="{{ __('sections.contact.form.inst_placeholder') }}" required type="text"/>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5" for="whatsapp">
                {{ __('sections.contact.form.wa_label') }} <span class="text-[#1F2B45]">*</span>
              </label>
              <input class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-xs sm:text-sm text-[#111827] dark:text-white placeholder-gray-400 focus:outline-none focus:border-[#1F2B45] transition-all" 
                     id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" 
                     placeholder="{{ __('sections.contact.form.wa_placeholder') }}" required type="tel"/>
            </div>

            <div>
              <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5" for="topic">
                {{ __('sections.contact.form.topic_label') }}
              </label>
              <select class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-xs sm:text-sm text-[#111827] dark:text-white focus:outline-none focus:border-[#1F2B45] transition-all cursor-pointer" 
                      id="topic" name="topic">
                <option value="sekolah">{{ __('sections.contact.form.topic_school') }}</option>
                <option value="riset">{{ __('sections.contact.form.topic_research') }}</option>
                <option value="desa">{{ __('sections.contact.form.topic_village') }}</option>
                <option value="kurikulum">{{ __('sections.contact.form.topic_curriculum') }}</option>
                <option value="lainnya">{{ __('sections.contact.form.topic_other') }}</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5" for="notes">
              {{ __('sections.contact.form.notes_label') }}
            </label>
            <textarea class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-xs sm:text-sm text-[#111827] dark:text-white placeholder-gray-400 focus:outline-none focus:border-[#1F2B45] transition-all resize-y" 
                      id="notes" name="notes" 
                      placeholder="{{ __('sections.contact.form.notes_placeholder') }}" rows="4"></textarea>
          </div>

          <div class="p-4 rounded-2xl bg-[#FFFFFF] dark:bg-white/5 flex items-start gap-3">
            <span class="material-symbols-outlined text-[#51634b] text-[20px] shrink-0 mt-0.5">verified_user</span>
            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
              {{ __('sections.contact.form.fpic_notice') }}
            </p>
          </div>

          <button class="w-full bg-[#1F2B45] hover:bg-[#16203A] text-white py-3.5 px-6 rounded-2xl text-xs font-bold flex items-center justify-center gap-2 shadow-md hover:shadow-xl transition-all cursor-pointer mt-2" 
                  type="submit">
            <span class="material-symbols-outlined text-[18px]">outgoing_mail</span>
            <span>{{ __('sections.contact.form.submit_btn') }}</span>
          </button>
        </form>

        <div class="hidden p-4 rounded-2xl bg-[#51634b]/10 text-[#51634b] flex items-center gap-2" id="confirm-box">
          <span class="material-symbols-outlined text-[20px]">check_circle</span>
          <p class="text-xs font-semibold">
            {{ __('sections.contact.form.confirm_msg') }}
          </p>
        </div>
      </div>

      <!-- Kolom Kanan: Narahubung WhatsApp, Surel, & Kantor -->
      <div class="lg:col-span-6 flex flex-col gap-6">
        
        <!-- Kartu Narahubung Langsung (Maya, Azki, Ryan) -->
        <div class="bg-white dark:bg-[#141414] p-8 rounded-3xl border border-gray-100 dark:border-white/5 shadow-sm space-y-6">
          <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-white/5">
            <div>
              <span class="text-xs font-bold uppercase tracking-wider text-[#1F2B45] block">Narahubung Resmi</span>
              <h3 class="text-lg font-bold text-[#111827] dark:text-white">{{ __('sections.contact.wa_card.title') }}</h3>
            </div>
            <span class="text-[11px] font-semibold text-gray-500 dark:text-gray-400">{{ $officeHours?->label ?? __('sections.contact.office_hours.label') }}</span>
          </div>

          <p class="text-xs text-gray-500 dark:text-gray-400">
            {{ __('sections.contact.wa_card.desc') }}
          </p>

          <div class="space-y-4">
            <!-- 1. Maya -->
            <div class="p-4 rounded-2xl bg-[#FFFFFF] dark:bg-white/5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
              <div>
                <div class="flex items-center gap-2">
                  <span class="text-sm font-bold text-[#111827] dark:text-white">Maya</span>
                  <span class="px-2 py-0.5 rounded-full bg-[#1F2B45]/10 text-[#1F2B45] text-[10px] font-bold uppercase tracking-wider">
                    {{ __('sections.contact.wa_card.maya_tag') }}
                  </span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ __('sections.contact.wa_card.maya_desc') }}</p>
                <p class="text-xs font-semibold text-[#1F2B45] mt-1">+62 821-1620-0363</p>
              </div>
              <a href="https://wa.me/{{ \App\Models\SiteSetting::get('contact_whatsapp_maya', '6282116200363') }}?text={{ urlencode('Halo Maya, saya ingin berkonsultasi mengenai program sekolah dan kemitraan Destinara.') }}" 
                 target="_blank" rel="noopener noreferrer"
                 class="bg-[#1F2B45] hover:bg-[#16203A] text-white px-5 py-2.5 rounded-2xl text-xs font-bold flex items-center justify-center gap-1.5 shrink-0 shadow-xs transition-all">
                <span class="material-symbols-outlined text-[16px]">chat</span>
                <span>{{ __('sections.contact.wa_card.chat_btn', ['name' => 'Maya']) }}</span>
              </a>
            </div>

            <!-- 2. Azki -->
            <div class="p-4 rounded-2xl bg-[#FFFFFF] dark:bg-white/5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
              <div>
                <div class="flex items-center gap-2">
                  <span class="text-sm font-bold text-[#111827] dark:text-white">Azki</span>
                  <span class="px-2 py-0.5 rounded-full bg-[#51634b]/10 text-[#51634b] text-[10px] font-bold uppercase tracking-wider">
                    {{ __('sections.contact.wa_card.azki_tag') }}
                  </span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ __('sections.contact.wa_card.azki_desc') }}</p>
                <p class="text-xs font-semibold text-[#51634b] mt-1">+62 858-9486-0696</p>
              </div>
              <a href="https://wa.me/{{ \App\Models\SiteSetting::get('contact_whatsapp_azki', '6285894860696') }}?text={{ urlencode('Halo Azki, saya ingin berdiskusi mengenai penelitian lapangan dan kliring etik FPIC.') }}" 
                 target="_blank" rel="noopener noreferrer"
                 class="bg-[#1F2B45] hover:bg-[#16203A] text-white px-5 py-2.5 rounded-2xl text-xs font-bold flex items-center justify-center gap-1.5 shrink-0 shadow-xs transition-all">
                <span class="material-symbols-outlined text-[16px]">chat</span>
                <span>{{ __('sections.contact.wa_card.chat_btn', ['name' => 'Azki']) }}</span>
              </a>
            </div>

            <!-- 3. Ryan -->
            <div class="p-4 rounded-2xl bg-[#FFFFFF] dark:bg-white/5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
              <div>
                <div class="flex items-center gap-2">
                  <span class="text-sm font-bold text-[#111827] dark:text-white">Ryan</span>
                  <span class="px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-700 text-[10px] font-bold uppercase tracking-wider">
                    {{ __('sections.contact.wa_card.ryan_tag') }}
                  </span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ __('sections.contact.wa_card.ryan_desc') }}</p>
                <p class="text-xs font-semibold text-amber-700 mt-1">+62 857-7441-0978</p>
              </div>
              <a href="https://wa.me/{{ \App\Models\SiteSetting::get('contact_whatsapp_ryan', '6285774410978') }}?text={{ urlencode('Halo Ryan, kami ingin berkonsultasi mengenai kemitraan desa adat dan operasional tapak.') }}" 
                 target="_blank" rel="noopener noreferrer"
                 class="bg-[#1F2B45] hover:bg-[#16203A] text-white px-5 py-2.5 rounded-2xl text-xs font-bold flex items-center justify-center gap-1.5 shrink-0 shadow-xs transition-all">
                <span class="material-symbols-outlined text-[16px]">chat</span>
                <span>{{ __('sections.contact.wa_card.chat_btn', ['name' => 'Ryan']) }}</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Surel Resmi & Lokasi Kantor -->
        <div class="bg-white dark:bg-[#141414] p-8 rounded-3xl border border-gray-100 dark:border-white/5 shadow-sm space-y-6">
          <h3 class="text-lg font-bold text-[#111827] dark:text-white">{{ __('sections.contact.email_card.title') }}</h3>
          
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-4 rounded-2xl bg-[#FFFFFF] dark:bg-white/5 space-y-1">
              <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">{{ __('sections.contact.email_card.partnership_label') }}</span>
              <p class="text-xs font-bold text-[#1F2B45] select-all">partnership@destinara.id</p>
              <p class="text-[11px] text-gray-500 dark:text-gray-400">{{ __('sections.contact.email_card.partnership_sub') }}</p>
            </div>

            <div class="p-4 rounded-2xl bg-[#FFFFFF] dark:bg-white/5 space-y-1">
              <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">{{ __('sections.contact.email_card.general_label') }}</span>
              <p class="text-xs font-bold text-[#1F2B45] select-all">hello@destinara.id</p>
              <p class="text-[11px] text-gray-500 dark:text-gray-400">{{ __('sections.contact.email_card.general_sub') }}</p>
            </div>
          </div>

          <!-- Sanggar Sleman & Jakarta -->
          <div class="space-y-4 pt-2">
            <div class="p-4 rounded-2xl border border-gray-100 dark:border-white/5 space-y-2">
              <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-[#111827] dark:text-white flex items-center gap-1.5">
                  <span class="material-symbols-outlined text-[16px] text-[#1F2B45]">location_on</span>
                  <span>{{ $officeHours?->sleman_title ?? __('sections.contact.office_hours.sleman_title') }}</span>
                </span>
                <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-white/10 text-[10px] font-semibold text-gray-600 dark:text-gray-300">
                  {{ __('sections.contact.office_hours.sleman_badge') }}
                </span>
              </div>
              <p class="text-xs text-gray-500 dark:text-gray-400">{{ $officeHours?->sleman_desc ?? __('sections.contact.office_hours.sleman_desc') }}</p>
              <p class="text-[11px] text-[#51634b] font-medium flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">schedule</span>
                <span>{{ $officeHours?->sleman_time ?? __('sections.contact.office_hours.sleman_time') }}</span>
              </p>
            </div>

            <div class="p-4 rounded-2xl border border-gray-100 dark:border-white/5 space-y-2">
              <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-[#111827] dark:text-white flex items-center gap-1.5">
                  <span class="material-symbols-outlined text-[16px] text-[#1F2B45]">apartment</span>
                  <span>{{ $officeHours?->jakarta_title ?? __('sections.contact.office_hours.jakarta_title') }}</span>
                </span>
                <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-white/10 text-[10px] font-semibold text-gray-600 dark:text-gray-300">
                  {{ __('sections.contact.office_hours.jakarta_badge') }}
                </span>
              </div>
              <p class="text-xs text-gray-500 dark:text-gray-400">{{ $officeHours?->jakarta_desc ?? __('sections.contact.office_hours.jakarta_desc') }}</p>
              <p class="text-[11px] text-gray-400">{{ $officeHours?->jakarta_time ?? __('sections.contact.office_hours.jakarta_time') }}</p>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Komitmen Etika Nusantara (3 Clean Cards) -->
    <section class="space-y-8 pt-8">
      <div class="text-center max-w-2xl mx-auto space-y-2">
        <span class="text-xs font-bold uppercase tracking-wider text-[#1F2B45]">
          {{ __('sections.contact.ethics.tag') }}
        </span>
        <h3 class="text-2xl sm:text-3xl font-extrabold text-[#111827] dark:text-white tracking-tight">
          {{ __('sections.contact.ethics.title') }}
        </h3>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
        <div class="bg-white dark:bg-[#141414] rounded-3xl p-7 border border-gray-100 dark:border-white/5 shadow-xs space-y-3">
          <div class="w-12 h-12 rounded-2xl bg-[#51634b]/10 text-[#51634b] flex items-center justify-center">
            <span class="material-symbols-outlined text-[26px]">nature_people</span>
          </div>
          <h4 class="text-base font-bold text-[#111827] dark:text-white">{{ __('sections.contact.ethics.p1_title') }}</h4>
          <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
            {{ __('sections.contact.ethics.p1_desc') }}
          </p>
        </div>

        <div class="bg-white dark:bg-[#141414] rounded-3xl p-7 border border-gray-100 dark:border-white/5 shadow-xs space-y-3">
          <div class="w-12 h-12 rounded-2xl bg-[#1F2B45]/10 text-[#1F2B45] flex items-center justify-center">
            <span class="material-symbols-outlined text-[26px]">local_library</span>
          </div>
          <h4 class="text-base font-bold text-[#111827] dark:text-white">{{ __('sections.contact.ethics.p2_title') }}</h4>
          <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
            {{ __('sections.contact.ethics.p2_desc') }}
          </p>
        </div>

        <div class="bg-white dark:bg-[#141414] rounded-3xl p-7 border border-gray-100 dark:border-white/5 shadow-xs space-y-3">
          <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-700 flex items-center justify-center">
            <span class="material-symbols-outlined text-[26px]">account_balance_wallet</span>
          </div>
          <h4 class="text-base font-bold text-[#111827] dark:text-white">{{ __('sections.contact.ethics.p3_title') }}</h4>
          <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
            {{ __('sections.contact.ethics.p3_desc') }}
          </p>
        </div>
      </div>
    </section>

  </div>
</main>
@endsection
