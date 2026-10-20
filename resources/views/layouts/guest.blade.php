<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#1F2B45"/>

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen antialiased text-gray-900">
        {{-- Latar: foto yang sama dengan hero beranda --}}
        <div class="fixed inset-0 -z-10" aria-hidden="true">
            <img src="{{ asset('assets/img/hd/hero-bg-waterfall.webp') }}" alt="" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/55"></div>
        </div>

        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-10">
            <a href="/" class="inline-flex items-center gap-3 text-white mb-6">
                <img src="{{ asset('assets/img/logo-mark-tight.png') }}" alt="Logo Destinara" class="w-10 h-10 object-contain brightness-110">
                <span class="text-xl font-extrabold tracking-tight">DESTINARA</span>
            </a>

            <div class="w-full sm:max-w-md px-6 py-6 sm:px-8 bg-white/95 backdrop-blur-xl border border-white/40 shadow-[0_24px_60px_rgba(0,0,0,0.35)] rounded-3xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
