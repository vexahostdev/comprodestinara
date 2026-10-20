<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>

  <!-- Anti-FOUC Theme Script: Instant Theme Apply before DOM paint -->
  <script>
    (function() {
      try {
        var storedTheme = localStorage.getItem('destinara-theme');
        var systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (storedTheme === 'dark' || (!storedTheme && systemPrefersDark)) {
          document.documentElement.classList.add('dark');
        } else {
          document.documentElement.classList.remove('dark');
        }
      } catch (e) {}
    })();
  </script>

  <title>@yield('title', 'Destinara — Menghidupkan Ruang Belajar Nyata di Tapak Nusantara')</title>
  <meta name="description" content="@yield('meta_description', 'Inisiatif pendidikan lapangan dan riset berbasis komunitas yang menjembatani kurikulum institusi dengan kearifan tapak dan pengetahuan lokal di seluruh Nusantara.')"/>

  <!-- Canonical & Search Engine Directives -->
  <link rel="canonical" href="@yield('canonical_url', url()->current())"/>
  <meta name="robots" content="@yield('robots', 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1')"/>
  <meta name="keywords" content="@yield('meta_keywords', 'destinara, wisata edukasi, study tour resmi, riset antropologi, penelitian tapak, live in desa nusantara, kearifan lokal, kemitraan pengelola desa, kurikulum lapangan, etnobotani nusantara, layanan destinara')"/>
  <meta name="author" content="Destinara"/>
  <meta name="publisher" content="PT DESTINARA CHAKRAWAL ARTHA"/>

  <!-- Google Search Console & Bing Webmaster Verification -->
  @if($gsc = \App\Models\SiteSetting::get('google_site_verification'))
  <meta name="google-site-verification" content="{{ $gsc }}"/>
  @endif
  @if($bing = \App\Models\SiteSetting::get('bing_site_verification'))
  <meta name="msvalidate.01" content="{{ $bing }}"/>
  @endif

  <!-- Open Graph / Social Media Metadata (Facebook, WhatsApp, LinkedIn) -->
  <meta property="og:site_name" content="Destinara"/>
  <meta property="og:type" content="@yield('og_type', 'website')"/>
  <meta property="og:title" content="@yield('og_title', View::yieldContent('title', 'Destinara — Menghidupkan Ruang Belajar Nyata di Tapak Nusantara'))"/>
  <meta property="og:description" content="@yield('og_description', View::yieldContent('meta_description', 'Inisiatif pendidikan lapangan dan riset berbasis komunitas yang menjembatani kurikulum institusi dengan kearifan tapak dan pengetahuan lokal di seluruh Nusantara.'))"/>
  <meta property="og:url" content="@yield('canonical_url', url()->current())"/>
  <meta property="og:image" content="@yield('og_image', asset('assets/img/hd/hero-home.jpg'))"/>
  <meta property="og:image:alt" content="Destinara — Ruang Belajar Nyata di Tapak Nusantara"/>
  <meta property="og:locale" content="id_ID"/>

  <!-- Twitter Card Metadata -->
  <meta name="twitter:card" content="summary_large_image"/>
  <meta name="twitter:title" content="@yield('og_title', View::yieldContent('title', 'Destinara — Menghidupkan Ruang Belajar Nyata di Tapak Nusantara'))"/>
  <meta name="twitter:description" content="@yield('og_description', View::yieldContent('meta_description', 'Inisiatif pendidikan lapangan dan riset berbasis komunitas yang menjembatani kurikulum institusi dengan kearifan tapak dan pengetahuan lokal di seluruh Nusantara.'))"/>
  <meta name="twitter:image" content="@yield('og_image', asset('assets/img/hd/hero-home.jpg'))"/>

  <!-- Google Analytics 4 (GA4) -->
  @if($gaId = \App\Models\SiteSetting::get('google_analytics_id'))
  <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{{ $gaId }}');
  </script>
  @endif

  <!-- Schema.org JSON-LD Structured Data: WebSite, Organization, & Google Sitelinks Navigation Hierarchy -->
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@graph": [
      {
        "@type": "WebSite",
        "@id": "{{ url('/') }}/#website",
        "url": "{{ url('/') }}",
        "name": "Destinara",
        "alternateName": ["Destinara Nusantara", "Layanan Destinara", "PT DESTINARA CHAKRAWAL ARTHA"],
        "description": "Inisiatif pendidikan lapangan dan riset berbasis komunitas yang menjembatani kurikulum institusi dengan kearifan tapak di seluruh Nusantara.",
        "inLanguage": "id-ID",
        "publisher": {
          "@id": "{{ url('/') }}/#organization"
        },
        "potentialAction": {
          "@type": "SearchAction",
          "target": {
            "@type": "EntryPoint",
            "urlTemplate": "{{ route('destinations.index') }}?q={search_term_string}"
          },
          "query-input": "required name=search_term_string"
        }
      },
      {
        "@type": "Organization",
        "@id": "{{ url('/') }}/#organization",
        "name": "Destinara",
        "legalName": "{{ \App\Models\SiteSetting::get('company_legal_name', 'PT DESTINARA CHAKRAWAL ARTHA') }}",
        "url": "{{ url('/') }}",
        "logo": {
          "@type": "ImageObject",
          "url": "{{ asset('assets/img/logo-horizontal.png') }}",
          "width": 300,
          "height": 80
        },
        "description": "Inisiatif pendidikan lapangan dan riset berbasis komunitas yang menjembatani kurikulum institusi dengan kearifan tapak dan pengetahuan lokal di seluruh Nusantara.",
        "email": "{{ \App\Models\SiteSetting::get('contact_email_partnership', 'partnership@destinara.id') }}",
        "telephone": "+{{ \App\Models\SiteSetting::get('contact_whatsapp', '6282116200363') }}",
        "address": {
          "@type": "PostalAddress",
          "streetAddress": "{{ \App\Models\SiteSetting::get('address_sleman', 'Sleman, D.I. Yogyakarta') }}",
          "addressCountry": "ID"
        },
        "sameAs": [
          "https://layanan.destinara.id"
        ]
      },
      {
        "@type": "SiteNavigationElement",
        "@id": "{{ url('/') }}/#navigation",
        "name": "Daftar Layanan & Portal Destinara",
        "description": "Struktur navigasi layanan utama Destinara untuk sekolah, akademisi, dan mitra desa di seluruh Indonesia.",
        "hasPart": [
          {
            "@type": "WebPage",
            "name": "Portal Layanan Destinara",
            "description": "Pusat akun dan akses layanan pendaftaran kemitraan, program, dan akun pengelola.",
            "url": "https://layanan.destinara.id"
          },
          {
            "@type": "WebPage",
            "name": "Program Untuk Sekolah",
            "description": "Panduan resmi study tour, live-in edukatif, dan field trip berdokumen legal untuk institusi pendidikan.",
            "url": "{{ route('for-schools') }}"
          },
          {
            "@type": "WebPage",
            "name": "Layanan Untuk Peneliti",
            "description": "Fasilitasi riset lapangan kredibel, kliring etik adat (FPIC), dan akses data primer etnografi.",
            "url": "{{ route('for-researchers') }}"
          },
          {
            "@type": "WebPage",
            "name": "Kemitraan Mitra Desa",
            "description": "Panduan bergabung bagi pengelola desa wisata, homestay warga, dan balai adat nusantara.",
            "url": "{{ route('for-villages') }}"
          },
          {
            "@type": "WebPage",
            "name": "Katalog Destinasi Tapak",
            "description": "Inventaris dan direktori desa adat serta tapak pembelajaran terkurasi di seluruh Nusantara.",
            "url": "{{ route('destinations.index') }}"
          },
          {
            "@type": "WebPage",
            "name": "Cerita & Warta Lapangan",
            "description": "Catatan lapangan, monograf etnobotani, dan refleksi pedagogis dari garda depan komunitas.",
            "url": "{{ route('stories.index') }}"
          },
          {
            "@type": "WebPage",
            "name": "Tentang Destinara",
            "description": "Jejak cerita pendiri, visi pelestarian budaya, dan nilai dasar inisiatif Destinara.",
            "url": "{{ route('about') }}"
          },
          {
            "@type": "WebPage",
            "name": "Kontak & Konsultasi",
            "description": "Ruang musyawarah terbuka dan narahubung resmi kemitraan pendidikan tapak.",
            "url": "{{ route('contact.index') }}"
          }
        ]
      },
      {
        "@type": "ItemList",
        "@id": "{{ url('/') }}/#sitelinks-list",
        "name": "Layanan Utama Destinara",
        "itemListElement": [
          {
            "@type": "ListItem",
            "position": 1,
            "name": "Portal Layanan Destinara (Subdomain)",
            "url": "https://layanan.destinara.id"
          },
          {
            "@type": "ListItem",
            "position": 2,
            "name": "Untuk Sekolah — Program Edukasi & Field Trip",
            "url": "{{ route('for-schools') }}"
          },
          {
            "@type": "ListItem",
            "position": 3,
            "name": "Untuk Peneliti — Riset Lapangan Kredibel",
            "url": "{{ route('for-researchers') }}"
          },
          {
            "@type": "ListItem",
            "position": 4,
            "name": "Mitra Desa — Kemitraan Pengelola Destinasi",
            "url": "{{ route('for-villages') }}"
          },
          {
            "@type": "ListItem",
            "position": 5,
            "name": "Destinasi Tapak — Katalog Desa Terkurasi",
            "url": "{{ route('destinations.index') }}"
          },
          {
            "@type": "ListItem",
            "position": 6,
            "name": "Cerita Tapak — Monograf & Warta Budaya",
            "url": "{{ route('stories.index') }}"
          },
          {
            "@type": "ListItem",
            "position": 7,
            "name": "Tentang Kami — Visi & Rekam Jejak",
            "url": "{{ route('about') }}"
          },
          {
            "@type": "ListItem",
            "position": 8,
            "name": "Hubungi Kami — Konsultasi & Narahubung",
            "url": "{{ route('contact.index') }}"
          }
        ]
      }
    ]
  }
  </script>

  @stack('schema')

  <!-- Favicon Configuration -->
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}"/>
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}"/>
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}"/>
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}"/>
  <link rel="manifest" href="{{ asset('site.webmanifest') }}"/>
  <meta name="theme-color" content="#703a3a"/>

  <!-- Preconnect & Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..24,400,0..1,0" rel="stylesheet"/>

  <!-- Tailwind CDN & Configuration for Destinara Design System -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "rgb(var(--color-primary) / <alpha-value>)",
            "primary-container": "rgb(var(--color-primary-container) / <alpha-value>)",
            "on-primary": "rgb(var(--color-on-primary) / <alpha-value>)",
            "on-primary-container": "rgb(var(--color-on-primary-container) / <alpha-value>)",
            "primary-fixed": "rgb(var(--color-primary-fixed) / <alpha-value>)",
            "primary-fixed-dim": "rgb(var(--color-primary-fixed-dim) / <alpha-value>)",
            "secondary": "rgb(var(--color-secondary) / <alpha-value>)",
            "secondary-container": "rgb(var(--color-secondary-container) / <alpha-value>)",
            "on-secondary": "rgb(var(--color-on-secondary) / <alpha-value>)",
            "on-secondary-container": "rgb(var(--color-on-secondary-container) / <alpha-value>)",
            "secondary-fixed": "rgb(var(--color-secondary-fixed) / <alpha-value>)",
            "secondary-fixed-dim": "rgb(var(--color-secondary-fixed-dim) / <alpha-value>)",
            "tertiary": "rgb(var(--color-tertiary) / <alpha-value>)",
            "tertiary-container": "rgb(var(--color-tertiary-container) / <alpha-value>)",
            "on-tertiary": "rgb(var(--color-on-tertiary) / <alpha-value>)",
            "on-tertiary-container": "rgb(var(--color-on-tertiary-container) / <alpha-value>)",
            "tertiary-fixed": "rgb(var(--color-tertiary-fixed) / <alpha-value>)",
            "tertiary-fixed-dim": "rgb(var(--color-tertiary-fixed-dim) / <alpha-value>)",
            "surface": "rgb(var(--color-surface) / <alpha-value>)",
            "surface-dim": "rgb(var(--color-surface-dim) / <alpha-value>)",
            "surface-bright": "rgb(var(--color-surface-bright) / <alpha-value>)",
            "surface-container-lowest": "rgb(var(--color-surface-container-lowest) / <alpha-value>)",
            "surface-container-low": "rgb(var(--color-surface-container-low) / <alpha-value>)",
            "surface-container": "rgb(var(--color-surface-container) / <alpha-value>)",
            "surface-container-high": "rgb(var(--color-surface-container-high) / <alpha-value>)",
            "surface-container-highest": "rgb(var(--color-surface-container-highest) / <alpha-value>)",
            "on-surface": "rgb(var(--color-on-surface) / <alpha-value>)",
            "on-surface-variant": "rgb(var(--color-on-surface-variant) / <alpha-value>)",
            "inverse-surface": "rgb(var(--color-inverse-surface) / <alpha-value>)",
            "inverse-on-surface": "rgb(var(--color-inverse-on-surface) / <alpha-value>)",
            "outline": "rgb(var(--color-outline) / <alpha-value>)",
            "outline-variant": "rgb(var(--color-outline-variant) / <alpha-value>)",
            "background": "rgb(var(--color-background) / <alpha-value>)",
            "on-background": "rgb(var(--color-on-background) / <alpha-value>)"
          },
          borderRadius: {
            DEFAULT: "0.5rem",
            sm: "0.25rem",
            md: "0.5rem",
            lg: "0.75rem",
            xl: "1rem",
            "2xl": "1.25rem",
            "3xl": "1.75rem",
            "4xl": "2.25rem",
            full: "9999px"
          },
          boxShadow: {
            "soft": "0 4px 20px -2px rgba(43, 33, 30, 0.05)",
            "floating": "0 20px 45px -12px rgba(112, 58, 58, 0.16)",
            "card": "0 10px 30px -5px rgba(0, 0, 0, 0.06)",
            "card-hover": "0 20px 35px -8px rgba(112, 58, 58, 0.18)"
          },
          spacing: {
            "space-2xs": "0.25rem",
            "space-xs": "0.5rem",
            "space-sm": "0.75rem",
            "space-md": "1rem",
            "space-lg": "1.5rem",
            "space-xl": "2rem",
            "space-2xl": "3rem",
            "space-3xl": "4.5rem",
            "space-4xl": "6.5rem",
            "gutter-desktop": "2rem",
            "gutter-mobile": "1.25rem"
          },
          fontFamily: {
            sans: ["Plus Jakarta Sans", "Work Sans", "system-ui", "sans-serif"],
            "display-hero": ["Plus Jakarta Sans", "sans-serif"],
            "headline-lg": ["Plus Jakarta Sans", "sans-serif"],
            "headline-md": ["Plus Jakarta Sans", "sans-serif"],
            "headline-sm": ["Plus Jakarta Sans", "sans-serif"],
            "caption-fieldnote": ["Plus Jakarta Sans", "sans-serif"],
            "body-lead": ["Plus Jakarta Sans", "sans-serif"],
            "body-default": ["Plus Jakarta Sans", "sans-serif"],
            "body-sm": ["Plus Jakarta Sans", "sans-serif"],
            "label-action": ["Plus Jakarta Sans", "sans-serif"],
            "label-tag": ["Plus Jakarta Sans", "sans-serif"]
          },
          fontSize: {
            "display-hero": ["48px", { lineHeight: "56px", letterSpacing: "-0.03em", fontWeight: "700" }],
            "headline-lg": ["36px", { lineHeight: "44px", letterSpacing: "-0.02em", fontWeight: "700" }],
            "headline-md": ["26px", { lineHeight: "34px", fontWeight: "700" }],
            "headline-sm": ["20px", { lineHeight: "28px", fontWeight: "600" }],
            "body-lead": ["18px", { lineHeight: "28px", fontWeight: "400" }],
            "body-default": ["15px", { lineHeight: "24px", fontWeight: "400" }],
            "body-sm": ["14px", { lineHeight: "22px", fontWeight: "400" }],
            "caption-fieldnote": ["13px", { lineHeight: "20px", fontWeight: "500" }],
            "label-action": ["14px", { lineHeight: "20px", letterSpacing: "0.01em", fontWeight: "600" }],
            "label-tag": ["12px", { lineHeight: "18px", letterSpacing: "0.02em", fontWeight: "600" }]
          }
        }
      }
    };
  </script>

  <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-surface font-body-default text-body-default text-on-surface">

  <!-- ==================== HEADER (POMAII ARCHITECTURE: TRANSPARENT OVER HERO, SOLID ON SCROLL) ==================== -->
  <header id="mainHeader" class="fixed top-0 inset-x-0 z-50 transition-all duration-300 {{ request()->routeIs('home') ? 'is-home-header header-transparent' : 'bg-white/95 dark:bg-[#181211]/95 backdrop-blur-md shadow-xs border-b border-gray-100 dark:border-white/10' }}">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
      
      <!-- Left: Logo & Slogan (Pomaii Brand Lockup with Destinara Identity) -->
      <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0" aria-label="Destinara Beranda">
        <img src="{{ asset('assets/img/logo-mark-tight.png') }}" alt="Destinara Logo" class="h-10 w-auto object-contain transition-transform group-hover:scale-105">
        <div class="flex flex-col">
          <span class="header-brand-title text-xl sm:text-2xl font-black text-[#1A1A1A] dark:text-white tracking-tight leading-none transition-colors">DESTINARA</span>
          <span class="header-brand-slogan text-[10px] text-gray-500 dark:text-gray-400 font-medium tracking-wide mt-1 leading-none transition-colors">{{ __('site.brand_tagline') }}</span>
        </div>
      </a>

      <!-- Center: Destinara Navigation Links (Pomaii Clean Spacing & Interactive Hover Underline) -->
      <nav class="hidden lg:flex items-center gap-5 xl:gap-7" aria-label="Navigasi Utama">
        <a href="{{ route('home') }}" 
           class="header-nav-link group text-sm font-semibold transition-colors relative py-1 {{ request()->routeIs('home') ? 'active-link text-[#703A3A] font-bold' : 'text-gray-800 dark:text-gray-200 hover:text-[#703A3A]' }}">
          <span>{{ __('site.nav.home') }}</span>
          <span class="absolute -bottom-1 left-0 right-0 h-[2px] bg-[#703A3A] rounded-full transition-all duration-300 origin-left {{ request()->routeIs('home') ? 'scale-x-100 opacity-100' : 'scale-x-0 opacity-0 group-hover:scale-x-100 group-hover:opacity-100' }}"></span>
        </a>

        <a href="{{ route('about') }}" 
           class="header-nav-link group text-sm font-medium transition-colors relative py-1 {{ request()->routeIs('about') ? 'active-link text-[#703A3A] font-bold' : 'text-gray-800 dark:text-gray-200 hover:text-[#703A3A]' }}">
          <span>{{ __('site.nav.about') }}</span>
          <span class="absolute -bottom-1 left-0 right-0 h-[2px] bg-[#703A3A] rounded-full transition-all duration-300 origin-left {{ request()->routeIs('about') ? 'scale-x-100 opacity-100' : 'scale-x-0 opacity-0 group-hover:scale-x-100 group-hover:opacity-100' }}"></span>
        </a>

        <a href="{{ route('for-schools') }}" 
           class="header-nav-link group text-sm font-medium transition-colors relative py-1 {{ request()->routeIs('for-schools') ? 'active-link text-[#703A3A] font-bold' : 'text-gray-800 dark:text-gray-200 hover:text-[#703A3A]' }}">
          <span>{{ __('site.nav.for_schools') }}</span>
          <span class="absolute -bottom-1 left-0 right-0 h-[2px] bg-[#703A3A] rounded-full transition-all duration-300 origin-left {{ request()->routeIs('for-schools') ? 'scale-x-100 opacity-100' : 'scale-x-0 opacity-0 group-hover:scale-x-100 group-hover:opacity-100' }}"></span>
        </a>

        <a href="{{ route('for-researchers') }}" 
           class="header-nav-link group text-sm font-medium transition-colors relative py-1 {{ request()->routeIs('for-researchers') ? 'active-link text-[#703A3A] font-bold' : 'text-gray-800 dark:text-gray-200 hover:text-[#703A3A]' }}">
          <span>{{ __('site.nav.for_researchers') }}</span>
          <span class="absolute -bottom-1 left-0 right-0 h-[2px] bg-[#703A3A] rounded-full transition-all duration-300 origin-left {{ request()->routeIs('for-researchers') ? 'scale-x-100 opacity-100' : 'scale-x-0 opacity-0 group-hover:scale-x-100 group-hover:opacity-100' }}"></span>
        </a>

        <a href="{{ route('for-villages') }}" 
           class="header-nav-link group text-sm font-medium transition-colors relative py-1 {{ request()->routeIs('for-villages') ? 'active-link text-[#703A3A] font-bold' : 'text-gray-800 dark:text-gray-200 hover:text-[#703A3A]' }}">
          <span>{{ __('site.nav.for_villages') }}</span>
          <span class="absolute -bottom-1 left-0 right-0 h-[2px] bg-[#703A3A] rounded-full transition-all duration-300 origin-left {{ request()->routeIs('for-villages') ? 'scale-x-100 opacity-100' : 'scale-x-0 opacity-0 group-hover:scale-x-100 group-hover:opacity-100' }}"></span>
        </a>

        <a href="{{ route('destinations.index') }}" 
           class="header-nav-link group text-sm font-medium transition-colors relative py-1 {{ request()->routeIs('destinations.*') ? 'active-link text-[#703A3A] font-bold' : 'text-gray-800 dark:text-gray-200 hover:text-[#703A3A]' }}">
          <span>{{ __('site.nav.destinations') }}</span>
          <span class="absolute -bottom-1 left-0 right-0 h-[2px] bg-[#703A3A] rounded-full transition-all duration-300 origin-left {{ request()->routeIs('destinations.*') ? 'scale-x-100 opacity-100' : 'scale-x-0 opacity-0 group-hover:scale-x-100 group-hover:opacity-100' }}"></span>
        </a>

        <a href="{{ route('stories.index') }}" 
           class="header-nav-link group text-sm font-medium transition-colors relative py-1 {{ request()->routeIs('stories.*') ? 'active-link text-[#703A3A] font-bold' : 'text-gray-800 dark:text-gray-200 hover:text-[#703A3A]' }}">
          <span>{{ __('site.nav.stories') }}</span>
          <span class="absolute -bottom-1 left-0 right-0 h-[2px] bg-[#703A3A] rounded-full transition-all duration-300 origin-left {{ request()->routeIs('stories.*') ? 'scale-x-100 opacity-100' : 'scale-x-0 opacity-0 group-hover:scale-x-100 group-hover:opacity-100' }}"></span>
        </a>

        <a href="{{ route('contact.index') }}" 
           class="header-nav-link group text-sm font-medium transition-colors relative py-1 {{ request()->routeIs('contact.index') ? 'active-link text-[#703A3A] font-bold' : 'text-gray-800 dark:text-gray-200 hover:text-[#703A3A]' }}">
          <span>{{ __('site.nav.contact') }}</span>
          <span class="absolute -bottom-1 left-0 right-0 h-[2px] bg-[#703A3A] rounded-full transition-all duration-300 origin-left {{ request()->routeIs('contact.index') ? 'scale-x-100 opacity-100' : 'scale-x-0 opacity-0 group-hover:scale-x-100 group-hover:opacity-100' }}"></span>
        </a>
      </nav>

      <!-- Right: Desktop Language Switcher + 3 Pomaii Outline Circle Icons -->
      <div class="flex items-center gap-2 sm:gap-3 shrink-0">

        <!-- Language Switcher Dropdown (Desktop & Tablet) -->
        <div class="relative group" id="desktopLangDropdown">
          <button type="button" 
                  id="desktopLangBtn"
                  class="header-circle-btn h-10 px-3 rounded-full border border-gray-200/90 dark:border-white/15 bg-white/80 dark:bg-[#1E1B1B]/80 backdrop-blur-xs flex items-center gap-1.5 text-xs font-bold text-gray-700 dark:text-gray-200 hover:text-[#703A3A] hover:border-[#703A3A] transition-all cursor-pointer shadow-xs"
                  title="{{ __('site.nav.choose_language') }}">
            <span class="material-symbols-outlined text-[17px] text-[#703A3A]">translate</span>
            <span class="tracking-wide uppercase font-sans text-[11px] sm:text-xs">
              @if(app()->getLocale() === 'zh') 🇨🇳 ZH
              @elseif(app()->getLocale() === 'ja') 🇯🇵 JA
              @elseif(app()->getLocale() === 'de') 🇩🇪 DE
              @elseif(app()->getLocale() === 'fr') 🇫🇷 FR
              @elseif(app()->getLocale() === 'nl') 🇳🇱 NL
              @elseif(app()->getLocale() === 'en') 🇬🇧 EN
              @else 🇮🇩 ID
              @endif
            </span>
            <span class="material-symbols-outlined text-[15px] text-gray-400 group-hover:rotate-180 transition-transform">expand_more</span>
          </button>
          
          <!-- Dropdown Menu -->
          <div id="desktopLangMenu" class="absolute right-0 top-full mt-1.5 w-44 bg-white dark:bg-[#1E1716] rounded-2xl border border-gray-100 dark:border-white/10 shadow-xl p-1.5 z-50 hidden group-hover:block transition-all">
            <a href="{{ route('lang.switch', 'id') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-[#703A3A] transition-colors {{ app()->getLocale() === 'id' ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : '' }}">
              <span class="flex items-center gap-2"><span>🇮🇩</span><span>Indonesia</span></span>
              @if(app()->getLocale() === 'id') <span class="material-symbols-outlined text-sm text-[#703A3A]">check</span> @endif
            </a>
            <a href="{{ route('lang.switch', 'en') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-[#703A3A] transition-colors {{ app()->getLocale() === 'en' ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : '' }}">
              <span class="flex items-center gap-2"><span>🇬🇧</span><span>English</span></span>
              @if(app()->getLocale() === 'en') <span class="material-symbols-outlined text-sm text-[#703A3A]">check</span> @endif
            </a>
            <a href="{{ route('lang.switch', 'zh') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-[#703A3A] transition-colors {{ app()->getLocale() === 'zh' ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : '' }}">
              <span class="flex items-center gap-2"><span>🇨🇳</span><span>中文</span></span>
              @if(app()->getLocale() === 'zh') <span class="material-symbols-outlined text-sm text-[#703A3A]">check</span> @endif
            </a>
            <a href="{{ route('lang.switch', 'ja') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-[#703A3A] transition-colors {{ app()->getLocale() === 'ja' ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : '' }}">
              <span class="flex items-center gap-2"><span>🇯🇵</span><span>日本語</span></span>
              @if(app()->getLocale() === 'ja') <span class="material-symbols-outlined text-sm text-[#703A3A]">check</span> @endif
            </a>
            <a href="{{ route('lang.switch', 'de') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-[#703A3A] transition-colors {{ app()->getLocale() === 'de' ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : '' }}">
              <span class="flex items-center gap-2"><span>🇩🇪</span><span>Deutsch</span></span>
              @if(app()->getLocale() === 'de') <span class="material-symbols-outlined text-sm text-[#703A3A]">check</span> @endif
            </a>
            <a href="{{ route('lang.switch', 'fr') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-[#703A3A] transition-colors {{ app()->getLocale() === 'fr' ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : '' }}">
              <span class="flex items-center gap-2"><span>🇫🇷</span><span>Français</span></span>
              @if(app()->getLocale() === 'fr') <span class="material-symbols-outlined text-sm text-[#703A3A]">check</span> @endif
            </a>
            <a href="{{ route('lang.switch', 'nl') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-[#703A3A] transition-colors {{ app()->getLocale() === 'nl' ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : '' }}">
              <span class="flex items-center gap-2"><span>🇳🇱</span><span>Nederlands</span></span>
              @if(app()->getLocale() === 'nl') <span class="material-symbols-outlined text-sm text-[#703A3A]">check</span> @endif
            </a>
          </div>
        </div>

        <!-- Icon 1: Search -->
        <a href="{{ route('destinations.index') }}" 
           title="{{ __('site.common.search_title') ?? 'Cari Destinasi' }}"
           class="header-circle-btn w-10 h-10 rounded-full border border-gray-200/90 dark:border-white/15 bg-white/80 dark:bg-[#1E1B1B]/80 backdrop-blur-xs flex items-center justify-center text-gray-700 dark:text-gray-200 hover:text-[#703A3A] hover:border-[#703A3A] hover:bg-gray-50 dark:hover:bg-white/5 transition-all cursor-pointer shadow-xs">
          <span class="material-symbols-outlined text-[19px]">search</span>
        </a>

        <!-- Icon 2: Wishlist / Saved -->
        <a href="{{ route('destinations.index') }}" 
           title="Tapak Tersimpan"
           class="header-circle-btn w-10 h-10 rounded-full border border-gray-200/90 dark:border-white/15 bg-white/80 dark:bg-[#1E1B1B]/80 backdrop-blur-xs flex items-center justify-center text-gray-700 dark:text-gray-200 hover:text-[#703A3A] hover:border-[#703A3A] hover:bg-gray-50 dark:hover:bg-white/5 transition-all cursor-pointer shadow-xs">
          <span class="material-symbols-outlined text-[19px]">favorite_border</span>
        </a>

        <!-- Icon 3: Menu Drawer -->
        <button type="button" 
                id="headerDrawerBtn"
                aria-label="{{ __('site.nav.open_menu') }}"
                title="Menu & Akses"
                class="header-circle-btn w-10 h-10 rounded-full border border-gray-200/90 dark:border-white/15 bg-white/80 dark:bg-[#1E1B1B]/80 backdrop-blur-xs flex items-center justify-center text-gray-700 dark:text-gray-200 hover:text-[#703A3A] hover:border-[#703A3A] hover:bg-gray-50 dark:hover:bg-white/5 transition-all cursor-pointer shadow-xs">
          <span class="material-symbols-outlined text-[20px]">menu</span>
        </button>

      </div>

    </div>
  </header>

  <!-- Drawer Backdrop Overlay -->
  <div id="mobileMenuOverlay" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 hidden opacity-0 transition-opacity duration-300"></div>

  <!-- Slide-out Menu Drawer (Desktop & Mobile) -->
  <div id="mobileMenuDrawer" class="fixed inset-y-0 right-0 z-50 bg-white dark:bg-[#181211] shadow-2xl flex flex-col justify-between p-6 sm:p-8 overflow-y-auto" aria-modal="true" role="dialog">
    <div>
      <!-- Header with Brand & Close Button -->
      <div class="flex items-center justify-between pb-5 mb-5 border-b border-outline-variant/30">
        <div class="flex items-center gap-3">
          <img class="destinara-logo h-8 sm:h-9 w-auto object-contain" src="{{ asset('assets/img/logo-horizontal.png') }}" alt="Destinara Logo"/>
        </div>
        <button id="mobileMenuCloseBtn" aria-label="{{ __('site.nav.close_menu') }}" class="w-10 h-10 rounded-full border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 hover:bg-gray-100 text-gray-600 dark:text-gray-300 hover:text-[#703A3A] flex items-center justify-center transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <!-- Language Switcher Strip in Drawer -->
      <div class="mb-4">
        <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10 flex flex-col gap-2.5">
          <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white px-0.5">
            <span class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[18px] text-[#703A3A]">translate</span>
              <span>{{ __('site.nav.language') }}</span>
            </span>
            <span class="text-[11px] font-normal text-gray-400 font-sans">{{ __('site.nav.choose_language') }}</span>
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-1.5">
            <a href="{{ route('lang.switch', 'id') }}" class="py-2 px-2.5 text-center text-xs font-semibold rounded-xl transition-all {{ app()->getLocale() === 'id' ? 'bg-[#703A3A] text-white font-bold shadow-xs' : 'bg-white dark:bg-[#1E1716] text-gray-700 dark:text-gray-200 border border-gray-200/60 dark:border-white/10 hover:border-[#703A3A]' }}">
              🇮🇩 Indonesia
            </a>
            <a href="{{ route('lang.switch', 'en') }}" class="py-2 px-2.5 text-center text-xs font-semibold rounded-xl transition-all {{ app()->getLocale() === 'en' ? 'bg-[#703A3A] text-white font-bold shadow-xs' : 'bg-white dark:bg-[#1E1716] text-gray-700 dark:text-gray-200 border border-gray-200/60 dark:border-white/10 hover:border-[#703A3A]' }}">
              🇬🇧 English
            </a>
            <a href="{{ route('lang.switch', 'zh') }}" class="py-2 px-2.5 text-center text-xs font-semibold rounded-xl transition-all {{ app()->getLocale() === 'zh' ? 'bg-[#703A3A] text-white font-bold shadow-xs' : 'bg-white dark:bg-[#1E1716] text-gray-700 dark:text-gray-200 border border-gray-200/60 dark:border-white/10 hover:border-[#703A3A]' }}">
              🇨🇳 中文
            </a>
            <a href="{{ route('lang.switch', 'ja') }}" class="py-2 px-2.5 text-center text-xs font-semibold rounded-xl transition-all {{ app()->getLocale() === 'ja' ? 'bg-[#703A3A] text-white font-bold shadow-xs' : 'bg-white dark:bg-[#1E1716] text-gray-700 dark:text-gray-200 border border-gray-200/60 dark:border-white/10 hover:border-[#703A3A]' }}">
              🇯🇵 日本語
            </a>
            <a href="{{ route('lang.switch', 'de') }}" class="py-2 px-2.5 text-center text-xs font-semibold rounded-xl transition-all {{ app()->getLocale() === 'de' ? 'bg-[#703A3A] text-white font-bold shadow-xs' : 'bg-white dark:bg-[#1E1716] text-gray-700 dark:text-gray-200 border border-gray-200/60 dark:border-white/10 hover:border-[#703A3A]' }}">
              🇩🇪 Deutsch
            </a>
            <a href="{{ route('lang.switch', 'fr') }}" class="py-2 px-2.5 text-center text-xs font-semibold rounded-xl transition-all {{ app()->getLocale() === 'fr' ? 'bg-[#703A3A] text-white font-bold shadow-xs' : 'bg-white dark:bg-[#1E1716] text-gray-700 dark:text-gray-200 border border-gray-200/60 dark:border-white/10 hover:border-[#703A3A]' }}">
              🇫🇷 Français
            </a>
            <a href="{{ route('lang.switch', 'nl') }}" class="py-2 px-2.5 text-center text-xs font-semibold rounded-xl transition-all {{ app()->getLocale() === 'nl' ? 'bg-[#703A3A] text-white font-bold shadow-xs' : 'bg-white dark:bg-[#1E1716] text-gray-700 dark:text-gray-200 border border-gray-200/60 dark:border-white/10 hover:border-[#703A3A]' }}">
              🇳🇱 Nederlands
            </a>
          </div>
        </div>
      </div>

      <!-- Theme Toggle Bar in Drawer -->
      <div class="mb-4">
        <button id="drawerThemeToggleBtn" 
                type="button" 
                aria-label="Ganti Tema Tampilan" 
                class="theme-toggle-btn w-full py-2.5 px-4 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 hover:bg-gray-100 text-gray-700 dark:text-gray-200 flex items-center justify-between transition-colors">
          <div class="flex items-center gap-2">
            <span class="theme-icon-light theme-toggle-icon material-symbols-outlined text-[20px] text-amber-600 dark:hidden">light_mode</span>
            <span class="theme-icon-dark theme-toggle-icon material-symbols-outlined text-[20px] text-amber-200 hidden dark:inline-flex">dark_mode</span>
            <span class="text-xs font-semibold uppercase tracking-wider">
              <span class="inline dark:hidden">{{ __('site.nav.theme_light_desc') }}</span>
              <span class="hidden dark:inline">{{ __('site.nav.theme_dark_desc') }}</span>
            </span>
          </div>
          <span class="text-[11px] font-mono text-gray-400 font-medium">Ubah</span>
        </button>
      </div>

      <!-- Portal Layanan Quick Buttons -->
      <div class="grid grid-cols-2 gap-2.5 mb-5 pb-4 border-b border-gray-100 dark:border-white/10">
        <a href="{{ config('services.core_system.url') }}/login" target="_blank" rel="noopener noreferrer" 
           class="py-2.5 px-3 rounded-full border border-gray-200 dark:border-white/10 hover:border-[#703A3A] text-xs font-bold text-gray-700 dark:text-gray-200 flex items-center justify-center gap-1.5 transition-colors">
          <span class="material-symbols-outlined text-[16px]">login</span>
          <span>{{ __('site.nav.login') }}</span>
        </a>
        <a href="{{ config('services.core_system.url') }}/register" target="_blank" rel="noopener noreferrer" 
           class="py-2.5 px-3 rounded-full bg-[#703A3A] hover:bg-[#561D1E] text-white text-xs font-bold flex items-center justify-center transition-colors shadow-xs">
          <span>{{ __('site.nav.register') }}</span>
        </a>
      </div>

      <!-- Navigation Links List in Drawer -->
      <nav class="space-y-1">
        <a href="{{ route('home') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl text-sm font-semibold transition-all {{ request()->routeIs('home') ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5' }}">
          <span>{{ __('site.nav.home') }}</span>
          <span class="material-symbols-outlined text-[18px]">chevron_right</span>
        </a>
        <a href="{{ route('about') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl text-sm font-semibold transition-all {{ request()->routeIs('about') ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5' }}">
          <span>{{ __('site.nav.about') }}</span>
          <span class="material-symbols-outlined text-[18px]">chevron_right</span>
        </a>
        <a href="{{ route('for-schools') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl text-sm font-semibold transition-all {{ request()->routeIs('for-schools') ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5' }}">
          <span>{{ __('site.nav.for_schools_full') }}</span>
          <span class="material-symbols-outlined text-[18px]">chevron_right</span>
        </a>
        <a href="{{ route('for-researchers') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl text-sm font-semibold transition-all {{ request()->routeIs('for-researchers') ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5' }}">
          <span>{{ __('site.nav.for_researchers_full') }}</span>
          <span class="material-symbols-outlined text-[18px]">chevron_right</span>
        </a>
        <a href="{{ route('for-villages') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl text-sm font-semibold transition-all {{ request()->routeIs('for-villages') ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5' }}">
          <span>{{ __('site.nav.for_villages_full') }}</span>
          <span class="material-symbols-outlined text-[18px]">chevron_right</span>
        </a>
        <a href="{{ route('destinations.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl text-sm font-semibold transition-all {{ request()->routeIs('destinations.*') ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5' }}">
          <span>{{ __('site.nav.destinations') }}</span>
          <span class="material-symbols-outlined text-[18px]">chevron_right</span>
        </a>
        <a href="{{ route('stories.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl text-sm font-semibold transition-all {{ request()->routeIs('stories.*') ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5' }}">
          <span>{{ __('site.nav.stories_full') }}</span>
          <span class="material-symbols-outlined text-[18px]">chevron_right</span>
        </a>
        <a href="{{ route('contact.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl text-sm font-semibold transition-all {{ request()->routeIs('contact.index') ? 'bg-[#703A3A]/10 text-[#703A3A] font-bold' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5' }}">
          <span>{{ __('site.nav.contact_full') }}</span>
          <span class="material-symbols-outlined text-[18px]">chevron_right</span>
        </a>
      </nav>
    </div>

    <!-- Footer Action inside Drawer with Legal Links -->
    <div class="mt-8 pt-5 border-t border-gray-100 dark:border-white/10 space-y-3">
      <a href="{{ route('destinations.index') }}" class="w-full bg-[#703A3A] hover:bg-[#561D1E] text-white py-3 px-5 rounded-full text-xs font-bold text-center block shadow-xs transition-colors">
        <span>{{ __('site.nav.explore_destinations') }}</span>
      </a>
      <a href="{{ route('contact.index') }}" class="w-full border border-gray-200 dark:border-white/10 hover:border-[#703A3A] text-gray-700 dark:text-gray-200 py-3 px-5 rounded-full text-xs font-bold text-center block transition-colors">
        <span>{{ __('site.nav.consult_program') }}</span>
      </a>
      
      <!-- Syarat & Ketentuan, Kebijakan Privasi in Drawer -->
      <div class="flex items-center justify-center gap-3 pt-2 text-[11px] text-gray-500 dark:text-gray-400">
        <a href="{{ route('legal.terms') }}" class="hover:text-[#703A3A] transition-colors font-medium">{{ __('site.footer.terms') }}</a>
        <span>•</span>
        <a href="{{ route('legal.privacy') }}" class="hover:text-[#703A3A] transition-colors font-medium">{{ __('site.footer.privacy') }}</a>
        <span>•</span>
        <a href="{{ route('legal.privacy.en') }}" class="hover:text-[#703A3A] transition-colors font-medium">{{ __('site.footer.privacy_en') }}</a>
      </div>

      <div class="text-center text-xs italic text-gray-400 pt-1">
        {{ __('site.nav.field_pedagogy') }}
      </div>
    </div>
  </div>

  <!-- ==================== MAIN CONTENT ==================== -->
  @yield('content')

  <!-- ==================== FOOTER (DESTINARA OFFICIAL 4-COLUMN ARCHITECTURE) ==================== -->
  <footer class="w-full bg-[#FAF9F6] dark:bg-[#140E0D] py-14 lg:py-18 mt-16 border-t border-gray-200/60 dark:border-white/10 text-gray-600 dark:text-gray-300 transition-colors">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Top Brand Strip -->
      <div class="pb-10 mb-10 border-b border-gray-200/60 dark:border-white/10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
          <img src="{{ asset('assets/img/logo-mark-tight.png') }}" alt="Destinara" class="h-10 w-auto object-contain">
          <div>
            <span class="text-2xl font-black text-[#1A1A1A] dark:text-white tracking-tight block leading-none">DESTINARA</span>
            <span class="text-[10px] text-gray-500 dark:text-gray-400 font-medium tracking-wide mt-1 block">{{ __('site.brand_tagline') }}</span>
          </div>
        </a>
        <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
          <span class="w-2 h-2 rounded-full bg-[#51634b]"></span>
          <span>Inisiatif Pendidikan Lapangan &amp; Riset Komunitas Terkurasi</span>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12 pb-12 border-b border-gray-200/60 dark:border-white/10">
        
        <!-- Kolom 1: Perusahaan -->
        <div class="flex flex-col gap-3">
          <h4 class="text-xs font-bold uppercase tracking-wider text-gray-900 dark:text-white">{{ __('site.footer.company') }}</h4>
          <ul class="flex flex-col gap-2.5 text-xs text-gray-600 dark:text-gray-300">
            <li>
              <a href="{{ route('about') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.about_destinara') }}</a>
            </li>
            <li>
              <a href="{{ route('about') }}#filosofi" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.philosophy') }}</a>
            </li>
            <li>
              <a href="{{ route('about') }}#rekam-jejak" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.track_record') }}</a>
            </li>
            <li>
              <a href="{{ route('destinations.index') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.selected_sanctuaries') }}</a>
            </li>
            <li>
              <a href="{{ route('legal.terms') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.terms') }}</a>
            </li>
            <li>
              <a href="{{ route('legal.privacy') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.privacy') }}</a>
            </li>
            <li>
              <a href="{{ route('legal.privacy.en') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.privacy_en') }}</a>
            </li>
          </ul>
        </div>

        <!-- Kolom 2: Untuk Pengguna -->
        <div class="flex flex-col gap-3">
          <h4 class="text-xs font-bold uppercase tracking-wider text-gray-900 dark:text-white">{{ __('site.footer.for_users') }}</h4>
          <ul class="flex flex-col gap-2.5 text-xs text-gray-600 dark:text-gray-300">
            <li>
              <a href="{{ route('for-schools') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.school_programs') }}</a>
            </li>
            <li>
              <a href="{{ route('for-researchers') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.research_collab') }}</a>
            </li>
            <li>
              <a href="{{ route('for-villages') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.village_partnership') }}</a>
            </li>
            <li>
              <a href="{{ route('about') }}#fpic" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.fpic_ethics') }}</a>
            </li>
          </ul>
        </div>

        <!-- Kolom 3: Publikasi & Warta -->
        <div class="flex flex-col gap-3">
          <h4 class="text-xs font-bold uppercase tracking-wider text-gray-900 dark:text-white">{{ __('site.footer.publications') }}</h4>
          <ul class="flex flex-col gap-2.5 text-xs text-gray-600 dark:text-gray-300">
            <li>
              <a href="{{ route('stories.index') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.latest_stories') }}</a>
            </li>
            <li>
              <a href="{{ route('stories.show', 'zat-pewarna-alami-sikka') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.monograph_sikka') }}</a>
            </li>
            <li>
              <a href="{{ route('stories.index') }}#newsletter-form" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.newsletter') }}</a>
            </li>
            <li>
              <a href="{{ route('for-schools') }}#silabus" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">{{ __('site.footer.syllabus_guide') }}</a>
            </li>
          </ul>
        </div>

        <!-- Kolom 4: Sekretariat & Narahubung -->
        <div class="flex flex-col gap-3">
          <h4 class="text-xs font-bold uppercase tracking-wider text-gray-900 dark:text-white">{{ __('site.footer.secretariat') }}</h4>
          <div class="flex flex-col gap-2 text-xs text-gray-600 dark:text-gray-300">
            <p>{{ __('site.footer.sleman_address') }}</p>
            <p>{{ __('site.footer.menteng_address') }}</p>
            <div class="flex flex-col gap-1.5 pt-2">
              <span class="text-gray-900 dark:text-white font-semibold text-[11px] uppercase tracking-wider">{{ __('site.footer.whatsapp_contacts') }}</span>
              <a href="https://wa.me/6282116200363?text={{ urlencode(__('site.modal.maya_msg')) }}" target="_blank" rel="noopener noreferrer" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors font-mono">
                Maya: +62 821-1620-0363
              </a>
              <a href="https://wa.me/6285894860696?text={{ urlencode(__('site.modal.azki_msg')) }}" target="_blank" rel="noopener noreferrer" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors font-mono">
                Azki: +62 858-9486-0696
              </a>
              <a href="https://wa.me/6285774410978?text={{ urlencode(__('site.modal.ryan_msg')) }}" target="_blank" rel="noopener noreferrer" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors font-mono">
                Ryan: +62 857-7441-0978
              </a>
            </div>
            <div class="flex flex-col gap-1 pt-2">
              <span class="text-gray-900 dark:text-white font-semibold text-[11px] uppercase tracking-wider">{{ __('site.footer.official_emails') }}</span>
              <a href="mailto:{{ \App\Models\SiteSetting::get('contact_email_partnership', 'partnership@destinara.id') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">
                {{ \App\Models\SiteSetting::get('contact_email_partnership', 'partnership@destinara.id') }}
              </a>
              <a href="mailto:{{ \App\Models\SiteSetting::get('contact_email_hello', 'hello@destinara.id') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors">
                {{ \App\Models\SiteSetting::get('contact_email_hello', 'hello@destinara.id') }}
              </a>
            </div>
          </div>
        </div>

      </div>

      <!-- Bottom Bar -->
      <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500 dark:text-gray-400 text-center sm:text-left">
        <p>&copy; {{ date('Y') }} {{ \App\Models\SiteSetting::get('company_legal_name', 'PT DESTINARA CHAKRAWAL ARTHA') }}. {{ __('site.footer.copyright') }}</p>
        <div class="flex items-center justify-center gap-3 text-xs">
          <a href="{{ route('legal.terms') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors font-medium">{{ __('site.footer.terms') }}</a>
          <span>•</span>
          <a href="{{ route('legal.privacy') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors font-medium">{{ __('site.footer.privacy') }}</a>
          <span>•</span>
          <a href="{{ route('legal.privacy.en') }}" class="hover:text-[#703A3A] dark:hover:text-[#E8999B] transition-colors font-medium">{{ __('site.footer.privacy_en') }}</a>
        </div>
        <p class="italic text-[#703A3A] dark:text-[#E8999B]">{{ __('site.footer.motto') }}</p>
      </div>
    </div>
  </footer>

  <!-- ==================== MOBILE STICKY UTILITY BAR ==================== -->
  <div class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 dark:bg-[#181211]/95 backdrop-blur-md border-t border-gray-200/60 dark:border-white/10 px-4 py-2.5 shadow-[0_-4px_20px_rgba(0,0,0,0.06)] mobile-sticky-action-bar">
    <div class="max-w-md mx-auto flex items-center gap-2">
      <button type="button" 
         onclick="document.getElementById('mobileWhatsAppModal').classList.remove('hidden');" 
         class="flex-1 bg-[#51634b] hover:bg-[#3e4d39] text-white py-2.5 px-3 text-xs font-semibold rounded-full flex items-center justify-center gap-1.5 text-center cursor-pointer shadow-xs transition-all">
        <span class="material-symbols-outlined text-[17px]">chat</span>
        <span>WhatsApp</span>
      </button>
      <a href="{{ route('destinations.index') }}" 
         class="flex-1 bg-[#703A3A] hover:bg-[#561D1E] text-white py-2.5 px-3 text-xs font-semibold rounded-full flex items-center justify-center gap-1.5 text-center shadow-xs transition-all">
        <span class="material-symbols-outlined text-[17px]">travel_explore</span>
        <span>{{ __('site.common.explore_destinations') }}</span>
      </a>
    </div>
  </div>

  <!-- Mobile WhatsApp Contact Sheet Modal -->
  <div id="mobileWhatsAppModal" class="hidden fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-black/50 backdrop-blur-xs p-0 sm:p-4">
    <div class="bg-white dark:bg-[#1F1716] w-full max-w-md p-6 rounded-t-3xl sm:rounded-3xl border border-gray-100 dark:border-white/10 shadow-2xl flex flex-col gap-4">
      <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-white/10">
        <div>
          <span class="text-base font-bold text-[#1E1B1B] dark:text-white">{{ __('site.modal.wa_title') }}</span>
          <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('site.modal.wa_subtitle') }}</p>
        </div>
        <button type="button" onclick="document.getElementById('mobileWhatsAppModal').classList.add('hidden');" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-white/10">
          <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
      </div>

      <div class="flex flex-col gap-2.5">
        <!-- Maya -->
        <a href="https://wa.me/6282116200363?text={{ urlencode(__('site.modal.maya_msg')) }}" target="_blank" rel="noopener noreferrer" class="p-3 bg-gray-50 dark:bg-white/5 hover:bg-[#703A3A]/5 rounded-2xl border border-transparent hover:border-[#703A3A]/20 flex items-center justify-between transition-colors">
          <div>
            <span class="font-bold text-sm text-[#1E1B1B] dark:text-white">{{ __('site.modal.maya_name') }}</span>
            <span class="text-[11px] text-[#51634b] block font-medium">{{ __('site.modal.maya_role') }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400 font-mono mt-0.5 block">+62 821-1620-0363</span>
          </div>
          <span class="material-symbols-outlined text-[#703A3A] text-[20px]">chat</span>
        </a>

        <!-- Azki -->
        <a href="https://wa.me/6285894860696?text={{ urlencode(__('site.modal.azki_msg')) }}" target="_blank" rel="noopener noreferrer" class="p-3 bg-gray-50 dark:bg-white/5 hover:bg-[#703A3A]/5 rounded-2xl border border-transparent hover:border-[#703A3A]/20 flex items-center justify-between transition-colors">
          <div>
            <span class="font-bold text-sm text-[#1E1B1B] dark:text-white">{{ __('site.modal.azki_name') }}</span>
            <span class="text-[11px] text-[#51634b] block font-medium">{{ __('site.modal.azki_role') }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400 font-mono mt-0.5 block">+62 858-9486-0696</span>
          </div>
          <span class="material-symbols-outlined text-[#703A3A] text-[20px]">chat</span>
        </a>

        <!-- Ryan -->
        <a href="https://wa.me/6285774410978?text={{ urlencode(__('site.modal.ryan_msg')) }}" target="_blank" rel="noopener noreferrer" class="p-3 bg-gray-50 dark:bg-white/5 hover:bg-[#703A3A]/5 rounded-2xl border border-transparent hover:border-[#703A3A]/20 flex items-center justify-between transition-colors">
          <div>
            <span class="font-bold text-sm text-[#1E1B1B] dark:text-white">{{ __('site.modal.ryan_name') }}</span>
            <span class="text-[11px] text-[#51634b] block font-medium">{{ __('site.modal.ryan_role') }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400 font-mono mt-0.5 block">+62 857-7441-0978</span>
          </div>
          <span class="material-symbols-outlined text-[#703A3A] text-[20px]">chat</span>
        </a>
      </div>

      <button type="button" onclick="document.getElementById('mobileWhatsAppModal').classList.add('hidden');" class="w-full py-2.5 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 rounded-full transition-colors text-center">
        <span>{{ __('site.modal.close') }}</span>
      </button>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/main.js') }}"></script>
  @stack('scripts')

  @if(session('success'))
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#703a3a',
        borderRadius: '8px'
      });
    </script>
  @endif

  @if(session('error'))
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Perhatian',
        text: "{{ session('error') }}",
        confirmButtonColor: '#703a3a',
        borderRadius: '8px'
      });
    </script>
  @endif
</body>
</html>