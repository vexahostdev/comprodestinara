<?php

use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageSectionController as AdminPageSectionController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\StatController as AdminStatController;
use App\Http\Controllers\Admin\StoryController as AdminStoryController;
use App\Http\Controllers\Admin\TeamMemberController as AdminTeamMemberController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalDocumentController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoryController;
use App\Models\Story;
use App\Services\CoreSystemClient;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// ==================== PENGALIHAN BAHASA (LANGUAGE SWITCHER) ====================
Route::get('/lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');

// ==================== HALAMAN PUBLIK ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/destinasi', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinasi/{slug}', [DestinationController::class, 'show'])->name('destinations.show');
Route::get('/untuk-sekolah', [PageController::class, 'forSchools'])->name('for-schools');
Route::get('/untuk-peneliti', [PageController::class, 'forResearchers'])->name('for-researchers');
Route::get('/mitra-desa', [PageController::class, 'forVillages'])->name('for-villages');
Route::get('/cerita', [StoryController::class, 'index'])->name('stories.index');
Route::get('/cerita/{slug}', [StoryController::class, 'show'])->name('stories.show');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.send')->middleware('throttle:10,1');

// Dokumen Resmi & Kebijakan Hukum (Inline Viewer PDF & Unduhan)
Route::get('/syarat-ketentuan', [LegalDocumentController::class, 'terms'])->name('legal.terms');
Route::get('/kebijakan-privasi', [LegalDocumentController::class, 'privacyId'])->name('legal.privacy');
Route::get('/privacy-policy', [LegalDocumentController::class, 'privacyEn'])->name('legal.privacy.en');
Route::get('/dokumen/legal/{type}/stream', [LegalDocumentController::class, 'stream'])->name('legal.stream');
Route::get('/dokumen/legal/{type}/download', [LegalDocumentController::class, 'download'])->name('legal.download');

// Fallback Route untuk melayani file gambar storage di hosting tanpa symlink (dengan validasi realpath aman)
Route::get('/storage/{path}', function (string $path) {
    $allowedBases = array_filter([
        realpath(storage_path('app/public')),
        realpath(public_path('storage')),
    ]);

    $candidates = [
        storage_path('app/public/'.$path),
        public_path('storage/'.$path),
    ];

    foreach ($candidates as $cand) {
        $real = realpath($cand);
        if ($real && ! is_dir($real)) {
            foreach ($allowedBases as $base) {
                if (str_starts_with($real, $base)) {
                    $mime = mime_content_type($real) ?: 'application/octet-stream';

                    return response()->file($real, ['Content-Type' => $mime]);
                }
            }
        }
    }

    abort(404);
})->where('path', '.*');

// Admin Cache Cleaner (hanya bisa diakses jika sudah login sebagai admin via POST)
Route::middleware(['auth', 'admin'])->post('/admin/clear-cache', function () {
    Artisan::call('optimize:clear');

    return redirect()->route('admin.dashboard')->with('success', 'Semua cache aplikasi (Route, Config, View) berhasil dibersihkan!');
})->name('admin.clear-cache');

// SEO Sitemap Dinamis untuk Google Search Console & Google Images (mengambil slug dari Core API)
Route::get('/sitemap.xml', function (CoreSystemClient $coreClient) {
    $destinationsRes = $coreClient->getDestinations(['per_page' => 50]);
    $destinations = $destinationsRes['data'] ?? [];
    $stories = Story::where('is_active', true)->get();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">'."\n";

    // Static service and landing pages
    $pages = [
        ['url' => url('/'), 'priority' => '1.0', 'freq' => 'weekly', 'img' => asset('assets/img/hd/hero-home.jpg'), 'title' => 'Destinara — Menghidupkan Ruang Belajar Nyata di Tapak Nusantara'],
        ['url' => route('for-schools'), 'priority' => '0.9', 'freq' => 'weekly', 'img' => asset('assets/img/hd/hero-fieldwork.jpg'), 'title' => 'Program Untuk Sekolah Destinara'],
        ['url' => route('for-researchers'), 'priority' => '0.9', 'freq' => 'weekly', 'img' => asset('assets/img/hd/hero-about.jpg'), 'title' => 'Layanan Untuk Peneliti & Akademisi Destinara'],
        ['url' => route('for-villages'), 'priority' => '0.9', 'freq' => 'weekly', 'img' => asset('assets/img/hd/desa-serambi.jpg'), 'title' => 'Mitra Desa & Komunitas Adat Destinara'],
        ['url' => route('destinations.index'), 'priority' => '0.9', 'freq' => 'weekly', 'img' => asset('assets/img/hd/hero-fieldwork.jpg'), 'title' => 'Katalog Destinasi Tapak Terkurasi'],
        ['url' => route('stories.index'), 'priority' => '0.8', 'freq' => 'weekly', 'img' => asset('assets/img/hd/hero-about.jpg'), 'title' => 'Cerita & Monograf Lapangan Destinara'],
        ['url' => route('about'), 'priority' => '0.8', 'freq' => 'monthly', 'img' => asset('assets/img/hd/hero-about.jpg'), 'title' => 'Tentang Inisiatif Destinara'],
        ['url' => route('contact.index'), 'priority' => '0.8', 'freq' => 'monthly', 'img' => null, 'title' => null],
        ['url' => route('legal.terms'), 'priority' => '0.5', 'freq' => 'monthly', 'img' => null, 'title' => 'Syarat & Ketentuan Layanan Destinara'],
        ['url' => route('legal.privacy'), 'priority' => '0.5', 'freq' => 'monthly', 'img' => null, 'title' => 'Kebijakan Privasi & Perlindungan Data Destinara'],
    ];

    foreach ($pages as $p) {
        $xml .= "  <url>\n    <loc>{$p['url']}</loc>\n    <lastmod>".date('Y-m-d')."</lastmod>\n    <changefreq>{$p['freq']}</changefreq>\n    <priority>{$p['priority']}</priority>\n";
        if (! empty($p['img'])) {
            $imgEsc = htmlspecialchars($p['img'], ENT_XML1, 'UTF-8');
            $titleEsc = htmlspecialchars($p['title'], ENT_XML1, 'UTF-8');
            $xml .= "    <image:image>\n      <image:loc>{$imgEsc}</image:loc>\n      <image:title>{$titleEsc}</image:title>\n    </image:image>\n";
        }
        $xml .= "  </url>\n";
    }

    // Destinations from Core API
    foreach ($destinations as $d) {
        $slug = is_array($d) ? ($d['slug'] ?? '') : ($d->slug ?? '');
        $name = is_array($d) ? ($d['name'] ?? '') : ($d->name ?? '');
        $imgUrl = is_array($d) ? ($d['cover_url'] ?? asset('assets/img/hd/hero-fieldwork.jpg')) : ($d->cover_url ?? asset('assets/img/hd/hero-fieldwork.jpg'));
        $loc = route('destinations.show', $slug);
        $date = date('Y-m-d');
        $imgEsc = htmlspecialchars($imgUrl, ENT_XML1, 'UTF-8');
        $nameEsc = htmlspecialchars($name, ENT_XML1, 'UTF-8');
        $xml .= "  <url>\n    <loc>{$loc}</loc>\n    <lastmod>{$date}</lastmod>\n    <changefreq>monthly</changefreq>\n    <priority>0.8</priority>\n";
        $xml .= "    <image:image>\n      <image:loc>{$imgEsc}</image:loc>\n      <image:title>{$nameEsc}</image:title>\n    </image:image>\n";
        $xml .= "  </url>\n";
    }

    // Stories
    foreach ($stories as $s) {
        $loc = route('stories.show', $s->slug);
        $date = ($s->published_at ?? $s->updated_at)->format('Y-m-d');
        $imgUrl = $s->image_url ? (str_starts_with($s->image_url, 'http') ? $s->image_url : url($s->image_url)) : asset('assets/img/hd/hero-about.jpg');
        $imgEsc = htmlspecialchars($imgUrl, ENT_XML1, 'UTF-8');
        $titleEsc = htmlspecialchars($s->title, ENT_XML1, 'UTF-8');
        $xml .= "  <url>\n    <loc>{$loc}</loc>\n    <lastmod>{$date}</lastmod>\n    <changefreq>monthly</changefreq>\n    <priority>0.7</priority>\n";
        $xml .= "    <image:image>\n      <image:loc>{$imgEsc}</image:loc>\n      <image:title>{$titleEsc}</image:title>\n    </image:image>\n";
        $xml .= "  </url>\n";
    }

    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

// Auth Routes (Laravel Breeze)
require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================== PANEL ADMIN DESTINARA ====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('stories', AdminStoryController::class)->except(['show']);
    Route::resource('programs', AdminProgramController::class)->except(['show']);
    Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);
    Route::resource('stats', AdminStatController::class)->except(['show']);

    // Konten Halaman & Section (Full CMS)
    Route::get('pages', [AdminPageSectionController::class, 'index'])->name('pages.index');
    Route::get('pages/{page}/edit', [AdminPageSectionController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{page}', [AdminPageSectionController::class, 'update'])->name('pages.update');
    Route::post('pages/{page}/toggle', [AdminPageSectionController::class, 'toggle'])->name('pages.toggle');

    // Dewan Kurator & Tim Lapangan
    Route::resource('team', AdminTeamMemberController::class)->except(['show']);

    // Pesan Masuk (Inbox)
    Route::get('messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [AdminContactMessageController::class, 'show'])->name('messages.show');
    Route::post('messages/{message}/toggle-read', [AdminContactMessageController::class, 'toggleRead'])->name('messages.toggle-read');
    Route::post('messages/mark-all-read', [AdminContactMessageController::class, 'markAllRead'])->name('messages.mark-all-read');
    Route::delete('messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');

    // Pengaturan Website
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
});
