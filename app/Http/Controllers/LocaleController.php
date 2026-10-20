<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LocaleController extends Controller
{
    /**
     * Supported application locales.
     */
    public const SUPPORTED_LOCALES = ['id', 'en', 'zh', 'ja', 'de', 'fr', 'nl'];

    /**
     * Switch application locale.
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        if (! in_array($locale, self::SUPPORTED_LOCALES, true)) {
            $locale = config('app.fallback_locale', 'id');
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        // Simpan preferensi bahasa dalam cookie selama 1 tahun (525600 menit)
        Cookie::queue('destinara_locale', $locale, 525600);

        return redirect()->back();
    }
}
