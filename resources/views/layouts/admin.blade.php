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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Work Sans', system-ui, sans-serif; }

        /* Admin Dark Mode Global Overrides */
        html.dark {
            color-scheme: dark;
        }
        html.dark body {
            background-color: #111315 !important;
            color: #ECEDEF !important;
        }
        html.dark main {
            background-color: #111315 !important;
        }
        html.dark header.bg-white {
            background-color: #1A1D21 !important;
            border-color: #2C3036 !important;
            color: #ECEDEF !important;
        }
        html.dark .bg-white {
            background-color: #1A1D21 !important;
            color: #ECEDEF !important;
        }
        html.dark .border-gray-200,
        html.dark .border-gray-100,
        html.dark .border-gray-300 {
            border-color: #2C3036 !important;
        }
        html.dark .divide-gray-100 > :not([hidden]) ~ :not([hidden]),
        html.dark .divide-gray-200 > :not([hidden]) ~ :not([hidden]) {
            border-color: #2C3036 !important;
        }
        html.dark .text-gray-900,
        html.dark .text-gray-800,
        html.dark .text-gray-700 {
            color: #ECEDEF !important;
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
            background-color: #1A1D21 !important;
        }
        html.dark .hover\:bg-gray-50:hover,
        html.dark .hover\:bg-gray-100:hover {
            background-color: #2C3036 !important;
        }
        html.dark input,
        html.dark select,
        html.dark textarea {
            background-color: #202429 !important;
            color: #ECEDEF !important;
            border-color: #3A3F46 !important;
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
            background-color: #1A1D21 !important;
            color: #ECEDEF !important;
        }
        html.dark table thead {
            background-color: #1A1D21 !important;
        }
        html.dark table th {
            color: #C4C8CE !important;
            border-color: #2C3036 !important;
        }
        html.dark table td {
            border-color: #2C3036 !important;
        }
        html.dark .shadow-sm {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.4) !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/dark-fallback.css') }}"/>
</head>
<body class="bg-gray-100 antialiased font-normal text-gray-700 text-xs transition-colors duration-200" x-data="{ sidebarOpen: false, deskOpen: (() => { try { return localStorage.getItem('destinara-admin-sidebar') !== '0' } catch (e) { return true } })() }"
      x-init="$watch('deskOpen', v => { try { localStorage.setItem('destinara-admin-sidebar', v ? '1' : '0') } catch (e) {} })">

{{-- Tata letak "sidebar inset": sidebar menempel di latar, halaman = panel membulat di atasnya. --}}
<div class="flex h-screen overflow-hidden bg-[#1F2937] dark:bg-[#0B0C0E]">
    {{-- Sidebar --}}
    <aside class="fixed inset-y-0 left-0 z-50 w-72 shrink-0 bg-[#1F2937] dark:bg-[#0B0C0E] transform transition-[transform,margin] duration-300 lg:translate-x-0 lg:static lg:inset-0 flex flex-col justify-between"
           :class="(sidebarOpen ? 'translate-x-0' : '-translate-x-full') + (deskOpen ? '' : ' lg:-ml-72')">
        <div>
            <div class="flex items-center justify-between h-14 px-5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3" title="Destinara Admin">
                    <img src="{{ asset('assets/img/logo-mark-tight.png') }}" alt="Logo Destinara" class="h-8 w-auto object-contain drop-shadow-sm flex-shrink-0">
                    <div>
                        <span class="text-white font-bold text-sm tracking-wider uppercase">DESTINARA</span>
                        <span class="block text-[10px] text-white/50 tracking-normal">Panel Kurator &amp; Admin</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-white/60 hover:text-white">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>

            <nav class="mt-2 px-3.5 space-y-1">
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

                @foreach($navItems as $item)
                    @php $active = request()->routeIs($item['route']) || (isset($item['prefix']) && request()->routeIs($item['prefix'].'*')); @endphp
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center justify-between px-3 py-2 rounded-2xl text-xs transition-all
 {{ $active ? 'bg-[#1F2B45] text-white font-medium shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white font-normal' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[18px] flex-shrink-0 text-white/80">{{ $item['icon'] }}</span>
                            <span>{{ $item['label'] }}</span>
                        </div>
                        @if(!empty($item['badge']) && $item['badge'] > 0)
                            <span class="px-2 py-0.5 text-[10px] font-semibold bg-[#AFC0D8] text-[#1F2937] rounded-full">
                                {{ $item['badge'] }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="p-3 border-t border-white/10 space-y-1">
            <form method="POST" action="{{ route('admin.clear-cache') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-white/60 hover:text-white text-xs transition-colors w-full px-2 py-1 rounded hover:bg-white/5 text-left cursor-pointer">
                    <span class="material-symbols-outlined text-[16px]">cached</span>
                    <span>Bersihkan Cache</span>
                </button>
            </form>
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 text-white/60 hover:text-white text-xs transition-colors px-2 py-1 rounded hover:bg-white/5">
                <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                <span>Lihat Website</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-red-300 hover:text-red-100 text-xs transition-colors w-full px-2 py-1 rounded hover:bg-white/5 text-left">
                    <span class="material-symbols-outlined text-[16px]">logout</span>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Overlay --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden"></div>

    {{-- Main Container --}}
    <div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-white dark:bg-[#111315] lg:my-2 lg:mr-2 lg:rounded-2xl lg:border lg:border-white/10 lg:shadow-sm" :class="deskOpen ? '' : 'lg:ml-2'">
        <header class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-5 flex-shrink-0">
            <div class="flex items-center gap-3">
                <button type="button" @click="window.matchMedia('(min-width: 1024px)').matches ? (deskOpen = !deskOpen) : (sidebarOpen = true)"
                        title="Buka/tutup menu" aria-label="Buka/tutup menu"
                        class="p-1.5 -ml-1 rounded-xl text-gray-500 hover:text-gray-800 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/10 transition-colors">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"></rect>
                        <path stroke-linecap="round" stroke-width="2" d="M9 3v18"></path>
                    </svg>
                </button>
                <span class="h-4 w-px bg-gray-200 dark:bg-white/10" aria-hidden="true"></span>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center lg:hidden" title="Destinara Admin">
                    <img src="{{ asset('assets/img/logo-mark-tight.png') }}" alt="Logo Destinara" class="h-7 w-auto object-contain">
                </a>
                <h1 class="text-xs uppercase tracking-wider font-semibold text-gray-700">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3">
                <!-- Theme Toggle Button -->
                <button id="adminThemeToggleBtn" 
                        type="button" 
                        aria-label="Ganti Tema Tampilan" 
                        title="Ganti Mode Tampilan" 
                        class="theme-toggle-btn flex items-center gap-1.5 px-2.5 py-1.5 rounded-2xl border border-gray-200 dark:border-[#2C3036] bg-gray-50 hover:bg-gray-100 dark:bg-[#1A1D21] dark:hover:bg-[#2C3036] text-gray-700 dark:text-[#ECEDEF] transition-all cursor-pointer shadow-xs">
                    <span class="theme-icon-light material-symbols-outlined text-[18px] text-amber-600 dark:hidden">light_mode</span>
                    <span class="theme-icon-dark material-symbols-outlined text-[18px] text-amber-200 hidden dark:inline-flex">dark_mode</span>
                    <span class="text-xs font-semibold uppercase tracking-wider font-sans hidden sm:inline">
                        <span class="inline dark:hidden">Terang</span>
                        <span class="hidden dark:inline">Gelap</span>
                    </span>
                </button>

                <div class="text-right hidden sm:block">
                    <div class="text-xs font-medium text-gray-800 dark:text-[#ECEDEF]">{{ auth()->user()?->name ?? 'Admin Destinara' }}</div>
                    <div class="text-[10px] text-gray-400 dark:text-[#9EA3AA]">{{ auth()->user()?->email ?? 'admin@destinara.id' }}</div>
                </div>
                <div class="w-8 h-8 rounded-full bg-[#1F2B45] flex items-center justify-center text-white text-xs font-semibold shadow-sm">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'D', 0, 1)) }}
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-[#111315] p-6">
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
</div>

{{-- Script Sinkronisasi Tema Admin (Terhubung ke Beranda & Login) --}}
<script>
    (function() {
        const toggleBtn = document.getElementById('adminThemeToggleBtn');
        function isDarkMode() {
            return document.documentElement.classList.contains('dark');
        }
        function applyTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('destinara-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('destinara-theme', 'light');
            }
        }
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                applyTheme(isDarkMode() ? 'light' : 'dark');
            });
        }
        // Listen to cross-tab storage changes
        window.addEventListener('storage', function(e) {
            if (e.key === 'destinara-theme') {
                applyTheme(e.newValue);
            }
        });
    })();
</script>

</body>
</html>