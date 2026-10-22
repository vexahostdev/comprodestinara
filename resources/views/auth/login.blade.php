<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('site.auth.login_title') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta name="theme-color" content="#1F2B45"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..24,400,0..1,0" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        .auth-input { width: 100%; font-size: .8125rem; padding: .8rem 1rem; border-radius: .75rem; color: #fff;
            background: rgba(255,255,255,.10); border: 1px solid rgba(255,255,255,.35); transition: all .2s ease; }
        .auth-input::placeholder { color: rgba(255,255,255,.6); }
        .auth-input:focus { outline: none; border-color: #fff; background: rgba(255,255,255,.16); box-shadow: 0 0 0 3px rgba(255,255,255,.18); }
        .auth-input.has-icon { padding-left: 2.6rem; }
        .auth-input:-webkit-autofill { -webkit-text-fill-color: #fff; transition: background-color 9999s ease-in-out 0s; }
    </style>
</head>
<body class="min-h-screen antialiased text-white bg-[#111827]">

    {{-- Latar: foto yang sama dengan hero beranda --}}
    <div class="fixed inset-0 -z-10" aria-hidden="true">
        <img src="{{ asset('assets/img/hd/hero-bg-waterfall.webp') }}" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/45 to-black/25"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-black/30"></div>
    </div>

    {{-- Pemilih bahasa --}}
    @php
        $locales = ['id' => '🇮🇩 Indonesia', 'en' => '🇬🇧 English', 'zh' => '🇨🇳 中文', 'ja' => '🇯🇵 日本語', 'de' => '🇩🇪 Deutsch', 'fr' => '🇫🇷 Français', 'nl' => '🇳🇱 Nederlands'];
        $current = app()->getLocale();
    @endphp
    <div class="absolute top-5 right-5 z-20" id="loginLangDropdownContainer">
        <button type="button" id="loginLangDropdownBtn" aria-expanded="false" aria-label="{{ __('site.nav.language') }}"
                class="flex items-center gap-1.5 px-3 py-2 rounded-2xl border border-white/30 bg-white/10 backdrop-blur-md text-white hover:bg-white/20 transition-all text-xs font-semibold uppercase tracking-wider cursor-pointer">
            <span class="material-symbols-outlined text-[16px]">translate</span>
            <span>{{ strtoupper($current) }}</span>
            <span class="material-symbols-outlined text-[14px]">expand_more</span>
        </button>
        <div id="loginLangDropdownMenu" class="hidden absolute right-0 mt-2 w-40 rounded-2xl bg-white border border-gray-200 shadow-xl py-1.5 text-gray-700">
            @foreach ($locales as $code => $label)
                <a href="{{ route('lang.switch', $code) }}" class="flex items-center justify-between px-3 py-1.5 text-xs hover:bg-gray-100 {{ $current === $code ? 'font-bold text-[#1F2B45]' : '' }}">
                    <span>{{ $label }}</span>
                    @if ($current === $code)<span class="material-symbols-outlined text-xs">check</span>@endif
                </a>
            @endforeach
        </div>
    </div>

    <main class="min-h-screen max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-12 grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">

        {{-- Kiri: brand & headline --}}
        <section class="space-y-5">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group" title="Destinara">
                <img src="{{ asset('assets/img/logo-mark-tight.png') }}" alt="Logo Destinara" class="w-10 h-10 object-contain brightness-110 group-hover:scale-105 transition-transform">
                <span class="text-xl font-extrabold tracking-tight">DESTINARA</span>
            </a>
            <div class="space-y-3">
                <p class="text-sm font-bold tracking-[0.25em] uppercase text-white/85">{{ __('site.auth.panel_title') }}</p>
                <h1 class="text-3xl sm:text-5xl font-extrabold leading-[1.05] tracking-tight max-w-xl drop-shadow-[0_2px_20px_rgba(0,0,0,0.45)]">
                    {{ __('site.auth.hero_title') }}
                </h1>
                <p class="hidden sm:block text-sm text-white/75 leading-relaxed max-w-md">{{ __('site.auth.hero_desc') }}</p>
            </div>
            <div class="hidden sm:flex gap-8 pt-2">
                <div><div class="text-2xl font-bold">14+</div><div class="text-white/60 text-xs mt-0.5">{{ __('site.auth.stat_destinations') }}</div></div>
                <div><div class="text-2xl font-bold">1.200+</div><div class="text-white/60 text-xs mt-0.5">{{ __('site.auth.stat_researchers') }}</div></div>
                <div><div class="text-2xl font-bold">100%</div><div class="text-white/60 text-xs mt-0.5">{{ __('site.auth.stat_ethics') }}</div></div>
            </div>
        </section>

        {{-- Kanan: kartu kaca --}}
        <section class="w-full max-w-md lg:justify-self-end">
            <div class="bg-white/10 backdrop-blur-xl border border-white/25 rounded-3xl p-6 sm:p-8 shadow-[0_24px_60px_rgba(0,0,0,0.35)] space-y-5">
                <div class="text-center space-y-1">
                    <h2 class="text-2xl font-extrabold tracking-tight">{{ __('site.auth.login_heading') }}</h2>
                    <p class="text-xs text-white/75">{{ __('site.auth.login_subheading') }}</p>
                </div>

                @if (session('status'))
                    <div class="p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="p-3 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-semibold text-white/90 mb-1.5">{{ __('site.auth.email_label') }}</label>
                        <div class="relative">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                   placeholder="{{ __('site.auth.email_placeholder') }}" class="auth-input has-icon">
                            <span class="material-symbols-outlined absolute left-3 top-3 text-lg text-white/70">mail</span>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold text-white/90 mb-1.5">{{ __('site.auth.password_label') }}</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                   placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" class="auth-input has-icon pr-11">
                            <span class="material-symbols-outlined absolute left-3 top-3 text-lg text-white/70">lock</span>
                            <button type="button" id="togglePassword" class="absolute right-3 top-2.5 text-white/70 hover:text-white transition-colors" aria-label="Tampilkan kata sandi">
                                <span class="material-symbols-outlined text-lg">visibility</span>
                            </button>
                        </div>
                    </div>

                    <label class="flex items-center gap-2 cursor-pointer text-xs text-white/85">
                        <input type="checkbox" name="remember" class="rounded border-white/40 bg-white/10 text-[#1F2B45] focus:ring-white/40">
                        <span>{{ __('site.auth.remember_me') }}</span>
                    </label>

                    <button type="submit" class="w-full py-3.5 px-6 rounded-2xl bg-[#1F2B45] hover:bg-[#2E3D5C] text-white font-bold text-sm shadow-lg transition-all cursor-pointer">
                        {{ __('site.auth.submit_button') }}
                    </button>
                </form>

                <div class="text-center pt-1">
                    <a href="{{ route('home') }}" class="text-xs text-white/70 hover:text-white transition-colors">&larr; {{ __('site.auth.back_to_home') }}</a>
                </div>
            </div>
        </section>
    </main>

    <script>
        (function () {
            const pwd = document.getElementById('password');
            const toggle = document.getElementById('togglePassword');
            toggle.addEventListener('click', function () {
                const show = pwd.type === 'password';
                pwd.type = show ? 'text' : 'password';
                toggle.firstElementChild.textContent = show ? 'visibility_off' : 'visibility';
            });

            const langBtn = document.getElementById('loginLangDropdownBtn');
            const langMenu = document.getElementById('loginLangDropdownMenu');
            langBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                langMenu.classList.toggle('hidden');
                langBtn.setAttribute('aria-expanded', String(!langMenu.classList.contains('hidden')));
            });
            document.addEventListener('click', function (e) {
                if (!langBtn.contains(e.target) && !langMenu.contains(e.target)) langMenu.classList.add('hidden');
            });
        })();
    </script>
</body>
</html>
