<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported application locales.
     */
    protected array $supportedLocales = ['id', 'en', 'zh', 'ja', 'de', 'fr', 'nl'];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = null;

        // 1. Cek dari session
        if ($request->hasSession() && session()->has('locale')) {
            $sessionLocale = session('locale');
            if (in_array($sessionLocale, $this->supportedLocales, true)) {
                $locale = $sessionLocale;
            }
        }

        // 2. Cek dari cookie jika session belum diset
        if (! $locale && $request->hasCookie('destinara_locale')) {
            $cookieLocale = $request->cookie('destinara_locale');
            if (in_array($cookieLocale, $this->supportedLocales, true)) {
                $locale = $cookieLocale;
                if ($request->hasSession()) {
                    session(['locale' => $locale]);
                }
            }
        }

        // 3. Cek preferensi bahasa browser (Accept-Language)
        if (! $locale) {
            $acceptLanguage = $request->server('HTTP_ACCEPT_LANGUAGE', '');
            if ($acceptLanguage) {
                // Cari match dengan bahasa yang didukung
                if (preg_match('/^(zh|zh-CN|zh-SG|zh-TW|zh-HK)/i', $acceptLanguage) || str_contains(strtolower($acceptLanguage), 'zh')) {
                    $locale = 'zh';
                } elseif (preg_match('/^(ja|ja-JP)/i', $acceptLanguage) || str_contains(strtolower($acceptLanguage), 'ja')) {
                    $locale = 'ja';
                } elseif (preg_match('/^(de|de-DE|de-AT|de-CH)/i', $acceptLanguage) || str_contains(strtolower($acceptLanguage), 'de')) {
                    $locale = 'de';
                } elseif (preg_match('/^(fr|fr-FR|fr-BE|fr-CA|fr-CH)/i', $acceptLanguage) || str_contains(strtolower($acceptLanguage), 'fr')) {
                    $locale = 'fr';
                } elseif (preg_match('/^(nl|nl-NL|nl-BE)/i', $acceptLanguage) || str_contains(strtolower($acceptLanguage), 'nl')) {
                    $locale = 'nl';
                } elseif (preg_match('/^(en|en-US|en-GB|en-AU)/i', $acceptLanguage) || str_contains(strtolower($acceptLanguage), 'en')) {
                    $locale = 'en';
                }
            }
        }

        // 4. Default ke Bahasa Indonesia
        if (! $locale || ! in_array($locale, $this->supportedLocales, true)) {
            $locale = config('app.fallback_locale', 'id');
        }

        app()->setLocale($locale);

        // Sinkronisasi Carbon locale
        $carbonLocale = match ($locale) {
            'zh' => 'zh_CN',
            'ja' => 'ja_JP',
            'de' => 'de_DE',
            'fr' => 'fr_FR',
            'nl' => 'nl_NL',
            'en' => 'en',
            default => 'id',
        };
        Carbon::setLocale($carbonLocale);

        return $next($request);
    }
}
