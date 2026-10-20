@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
<div class="max-w-3xl mx-auto space-y-4">
    <h2 class="text-base font-semibold text-gray-800">Pengaturan Profil &amp; Narahubung Destinara</h2>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-5 text-xs">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <h3 class="font-bold text-gray-800 text-xs uppercase tracking-wider text-[#1F2B45] border-b pb-1">Identitas Inisiatif</h3>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Nama Brand</label>
                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Destinara' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Nama Legal Perusahaan (PT)</label>
                <input type="text" name="company_legal_name" value="{{ $settings['company_legal_name'] ?? 'PT DESTINARA CHAKRAWAL ARTHA' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Tagline Slogan</label>
                <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Deskripsi Ringkas (SEO)</label>
                <textarea name="site_description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">{{ $settings['site_description'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="space-y-4 pt-2">
            <h3 class="font-bold text-gray-800 text-xs uppercase tracking-wider text-[#1F2B45] border-b pb-1">Narahubung &amp; Kantor</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Surel Kemitraan &amp; Riset</label>
                    <input type="email" name="contact_email_partnership" value="{{ $settings['contact_email_partnership'] ?? 'partnership@destinara.id' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Surel Umum / Sapaan (Hello)</label>
                    <input type="email" name="contact_email_hello" value="{{ $settings['contact_email_hello'] ?? 'hello@destinara.id' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Surel Utama (Fallback)</label>
                    <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'hello@destinara.id' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Nomor WhatsApp Utama</label>
                    <input type="text" name="contact_whatsapp" value="{{ $settings['contact_whatsapp'] ?? '6282116200363' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
                </div>
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Alamat Sleman</label>
                <input type="text" name="address_sleman" value="{{ $settings['address_sleman'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Alamat Jakarta</label>
                <input type="text" name="address_jakarta" value="{{ $settings['address_jakarta'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>
        </div>

        <div class="space-y-4 pt-2">
            <h3 class="font-bold text-gray-800 text-xs uppercase tracking-wider text-[#1F2B45] border-b pb-1">Piagam Manifesto</h3>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Kutipan</label>
                <textarea name="manifesto_quote" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">{{ $settings['manifesto_quote'] ?? '' }}</textarea>
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Atribusi</label>
                <input type="text" name="manifesto_author" value="{{ $settings['manifesto_author'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>
        </div>

        <div class="space-y-4 pt-2">
            <div class="flex items-center justify-between border-b pb-1">
                <h3 class="font-bold text-gray-800 text-xs uppercase tracking-wider text-[#1F2B45]">
                    Optimasi SEO &amp; Integrasi Google Search Console
                </h3>
                <span class="text-[10px] text-green-700 font-semibold bg-green-50 px-2 py-0.5 rounded">Prioritas Google Ranking #1</span>
            </div>
            
            <div>
                <label class="block font-medium text-gray-700 mb-1">
                    Google Search Console Verification Token / Meta Tag
                </label>
                <input type="text" name="google_site_verification" value="{{ $settings['google_site_verification'] ?? '' }}" placeholder="Contoh: vL_31... atau tempel langsung tag <meta name='google-site-verification'...>" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45] font-mono text-[11px]">
                <p class="text-[11px] text-gray-500 mt-1">Masukkan kode verifikasi dari Google Search Console untuk membuktikan kepemilikan domain Anda ke Google.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Google Analytics 4 (GA4 ID)</label>
                    <input type="text" name="google_analytics_id" value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="Contoh: G-XXXXXXXXXX" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45] font-mono text-[11px]">
                    <p class="text-[11px] text-gray-500 mt-1">Lacak statistik pengunjung, tayangan pencarian Google, dan interaksi pengguna.</p>
                </div>
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Bing Webmaster Tools Token (Opsional)</label>
                    <input type="text" name="bing_site_verification" value="{{ $settings['bing_site_verification'] ?? '' }}" placeholder="Contoh: 8E92B1C..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45] font-mono text-[11px]">
                    <p class="text-[11px] text-gray-500 mt-1">Verifikasi situs di mesin pencari Microsoft Bing &amp; Yahoo.</p>
                </div>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Kata Kunci Utama Global (Default Meta Keywords)</label>
                <input type="text" name="seo_default_keywords" value="{{ $settings['seo_default_keywords'] ?? 'destinara, wisata edukasi, study tour resmi, riset antropologi, kemitraan desa, layanan destinara, live in desa nusantara' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
                <p class="text-[11px] text-gray-500 mt-1">Pisahkan setiap kata kunci dengan tanda koma (,).</p>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-[#1F2B45] hover:bg-[#16203A] text-white font-medium rounded-2xl shadow-sm">
                Simpan Semua Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
