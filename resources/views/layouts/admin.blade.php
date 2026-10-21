<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Destinara Panel')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Anti-FOUC Theme Script: Synchronized with Public & Login Theme -->
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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..24,400,0..1,0" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#1F2B45',
                    }
                }
            }
        };
    </script>
    <script src="{{ asset('js/portal-shell.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Work Sans', system-ui, sans-serif; }

        /* Admin Dark Mode Global Overrides */
        html.dark {
            color-scheme: dark;
        }
        html.dark body {
            background-color: #141414 !important;
            color: #FAFAFA !important;
        }
        html.dark main {
            background-color: #141414 !important;
        }
        html.dark header.bg-white {
            background-color: #141414 !important;
            border-color: #262626 !important;
            color: #FAFAFA !important;
        }
        html.dark .bg-white {
            background-color: #141414 !important;
            color: #FAFAFA !important;
        }
        html.dark .border-gray-200,
        html.dark .border-gray-100,
        html.dark .border-gray-300 {
            border-color: #262626 !important;
        }
        html.dark .divide-gray-100 > :not([hidden]) ~ :not([hidden]),
        html.dark .divide-gray-200 > :not([hidden]) ~ :not([hidden]) {
            border-color: #262626 !important;
        }
        html.dark .text-gray-900,
        html.dark .text-gray-800,
        html.dark .text-gray-700 {
            color: #FAFAFA !important;
        }
        html.dark .text-gray-600,
        html.dark .text-gray-500 {
            color: #B4B9C0 !important;
        }
        html.dark .text-gray-400 {
            color: #9EA3AA !important;
        }
        html.dark .bg-gray-50,
        html.dark .bg-gray-100 {
            background-color: #141414 !important;
        }
        html.dark .hover\:bg-gray-50:hover,
        html.dark .hover\:bg-gray-100:hover {
            background-color: #262626 !important;
        }
        html.dark input,
        html.dark select,
        html.dark textarea {
            background-color: #171717 !important;
            color: #FAFAFA !important;
            border-color: #404040 !important;
        }
        html.dark input:focus,
        html.dark select:focus,
        html.dark textarea:focus {
            border-color: #AFC0D8 !important;
        }
        html.dark input::placeholder,
        html.dark textarea::placeholder {
            color: #6E747D !important;
        }
        html.dark select option {
            background-color: #141414 !important;
            color: #FAFAFA !important;
        }
        html.dark table thead {
            background-color: #141414 !important;
        }
        html.dark table th {
            color: #C4C8CE !important;
            border-color: #262626 !important;
        }
        html.dark table td {
            border-color: #262626 !important;
        }
        html.dark .shadow-sm {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.4) !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/dark-fallback.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/portal-shell.css') }}"/>
</head>
<body class="ps-shell antialiased text-xs" x-data="portalShell">
@php
    $unreadMessagesCount = \App\Models\ContactMessage::where('is_read', false)->count();
    $navItems = [
        ['route' => 'admin.dashboard', 'icon' => 'dashboard', 'label' => 'Dashboard'],
        ['route' => 'admin.pages.index', 'prefix' => 'admin.pages.', 'icon' => 'web', 'label' => 'Konten Halaman'],
        ['route' => 'admin.stories.index', 'prefix' => 'admin.stories.', 'icon' => 'auto_stories', 'label' => 'Cerita Lapangan'],
        ['route' => 'admin.programs.index', 'prefix' => 'admin.programs.', 'icon' => 'school', 'label' => 'Program & Layanan'],
        ['route' => 'admin.team.index', 'prefix' => 'admin.team.', 'icon' => 'groups', 'label' => 'Dewan Kurator'],
        ['route' => 'admin.stats.index', 'prefix' => 'admin.stats.', 'icon' => 'bar_chart', 'label' => 'Statistik Dampak'],
        ['route' => 'admin.testimonials.index', 'prefix' => 'admin.testimonials.', 'icon' => 'format_quote', 'label' => 'Catatan & Testimoni'],
        ['route' => 'admin.messages.index', 'prefix' => 'admin.messages.', 'icon' => 'mail', 'label' => 'Pesan Masuk', 'badge' => $unreadMessagesCount],
        ['route' => 'admin.settings.index', 'icon' => 'settings', 'label' => 'Pengaturan Web'],
    ];
@endphp

{{-- Tata letak "sidebar inset" ala POS Kasir: sidebar menyatu dengan latar, halaman = panel membulat di atasnya. --}}
<div x-show="mobileSidebarOpen" x-cloak x-transition.opacity.duration.200ms @click="mobileSidebarOpen = false" class="ps-backdrop" aria-hidden="true"></div>

<aside class="ps-aside" :class="{ 'is-open': mobileSidebarOpen, 'is-rail': rail }" @keydown.escape.window="mobileSidebarOpen = false">
    <a href="{{ route('admin.dashboard') }}" class="ps-brand" title="Destinara Admin">
        <img src="{{ asset('assets/img/logo-mark-tight.png') }}" alt="Logo Destinara" class="ps-logo">
        <span x-show="!rail" class="flex min-w-0 flex-1 flex-col">
            <span class="ps-brand-name">DESTINARA</span>
            <span class="ps-brand-sub truncate">Panel Kurator &amp; Admin</span>
        </span>
    </a>

    <nav class="ps-nav" aria-label="Menu admin">
        <div x-show="!rail" class="ps-label">Konten Website</div>
        @foreach ($navItems as $item)
            @php $active = request()->routeIs($item['route']) || (isset($item['prefix']) && request()->routeIs($item['prefix'].'*')); @endphp
            <a href="{{ route($item['route']) }}" title="{{ $item['label'] }}" class="ps-link {{ $active ? 'is-active' : '' }}" @if ($active) aria-current="page" @endif>
                <span class="material-symbols-outlined">{{ $item['icon'] }}</span>
                <span x-show="!rail" class="truncate">{{ $item['label'] }}</span>
                @if (! empty($item['badge']))
                    <span x-show="!rail" class="ps-badge">{{ $item['badge'] }}</span>
                @endif
            </a>
        @endforeach

        <div x-show="!rail" class="ps-label">Lainnya</div>
        <a href="{{ route('home') }}" target="_blank" title="Lihat Website" class="ps-link">
            <span class="material-symbols-outlined">open_in_new</span>
            <span x-show="!rail" class="truncate">Lihat Website</span>
        </a>
        <form method="POST" action="{{ route('admin.clear-cache') }}">
            @csrf
            <button type="submit" title="Bersihkan Cache" class="ps-link w-full cursor-pointer">
                <span class="material-symbols-outlined">cached</span>
                <span x-show="!rail" class="truncate">Bersihkan Cache</span>
            </button>
        </form>
    </nav>

    <div class="ps-seg" role="group" aria-label="Tema tampilan">
        <button type="button" @click="setTheme('light')" :class="!dark && 'is-on'" title="Mode terang">
            <span class="material-symbols-outlined">light_mode</span>
            <span x-show="!rail">Terang</span>
        </button>
        <button type="button" @click="setTheme('dark')" :class="dark && 'is-on'" title="Mode gelap">
            <span class="material-symbols-outlined">dark_mode</span>
            <span x-show="!rail">Gelap</span>
        </button>
    </div>

    <div class="ps-user">
        <span class="ps-avatar">{{ strtoupper(substr(auth()->user()?->name ?? 'AD', 0, 2)) }}</span>
        <span x-show="!rail" class="grid min-w-0 flex-1">
            <span class="truncate text-sm font-medium">{{ auth()->user()?->name ?? 'Admin Destinara' }}</span>
            <span class="ps-sub truncate">{{ auth()->user()?->email ?? 'admin@destinara.id' }}</span>
        </span>
        <form x-show="!rail" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" title="Keluar" aria-label="Keluar" class="ps-icon-btn is-danger">
                <span class="material-symbols-outlined text-[18px]">logout</span>
            </button>
        </form>
    </div>
</aside>

<div class="ps-inset">
    <header class="ps-header">
        <button type="button" @click="toggleSidebar()" title="Buka/tutup menu" aria-label="Buka/tutup menu" class="ps-icon-btn -ml-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"></rect>
                <path stroke-linecap="round" stroke-width="2" d="M9 3v18"></path>
            </svg>
        </button>
        <span class="ps-divider" aria-hidden="true"></span>
        <div class="min-w-0 flex-1">
            <h1 class="ps-header-title truncate">@yield('title', 'Dashboard')</h1>
            <p class="ps-header-sub truncate">Panel Kurator &amp; Admin</p>
        </div>
        <a href="{{ route('home') }}" target="_blank" class="ps-btn hidden sm:inline-flex">
            <span class="material-symbols-outlined">open_in_new</span>
            <span>Lihat Website</span>
        </a>
    </header>

    <main class="flex-1 w-full p-4 sm:p-6 lg:p-8">
        @if(session('success'))
            <div class="mb-4 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-xs flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600 text-[18px]">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-lg text-xs flex items-center gap-2">
                <span class="material-symbols-outlined text-rose-600 text-[18px]">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-lg text-xs">
                <div class="font-medium mb-1">Mohon periksa kembali formulir:</div>
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>

{{-- Ikuti perubahan tema dari tab lain (beranda / login) --}}
<script>
    window.addEventListener('storage', function (e) {
        if (e.key === 'destinara-theme') document.documentElement.classList.toggle('dark', e.newValue === 'dark');
    });
</script>

</body>
</html>
