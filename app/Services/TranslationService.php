<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    /**
     * Supported target locales and their respective translation language codes.
     */
    protected array $localeMap = [
        'en' => 'en-GB',
        'zh' => 'zh-CN',
        'ja' => 'ja-JP',
        'de' => 'de-DE',
        'fr' => 'fr-FR',
        'nl' => 'nl-NL',
    ];

    /**
     * In-memory cache for translations loaded from disk.
     */
    protected array $diskCache = [];

    /**
     * Path to the translation store directory.
     */
    protected function getStoragePath(string $locale): string
    {
        $dir = storage_path('app/translations');
        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true, true);
        }

        return "{$dir}/{$locale}.json";
    }

    /**
     * Translate a single text string from Indonesian to a target locale.
     */
    public function translate(string $text, string $targetLocale, string $sourceLocale = 'id'): string
    {
        $text = trim($text);
        if (empty($text) || $targetLocale === 'id') {
            return $text;
        }

        $targetPair = $this->localeMap[$targetLocale] ?? $targetLocale;
        $sourcePair = $sourceLocale === 'id' ? 'id-ID' : $sourceLocale;
        $cacheKey = 'trans_'.md5("{$sourceLocale}_{$targetLocale}_{$text}");

        return Cache::remember($cacheKey, 60 * 60 * 24 * 30, function () use ($text, $sourcePair, $targetPair) {
            try {
                // If text contains paragraphs or is long, split by sentences/newlines to avoid API length limits
                if (mb_strlen($text) > 450) {
                    return $this->translateLongText($text, $sourcePair, $targetPair);
                }

                $response = Http::timeout(6)
                    ->get('https://api.mymemory.translated.net/get', [
                        'q' => $text,
                        'langpair' => "{$sourcePair}|{$targetPair}",
                    ]);

                if ($response->successful()) {
                    $json = $response->json();
                    $translated = $json['responseData']['translatedText'] ?? null;
                    if (! empty($translated) && ! str_starts_with($translated, 'MYMEMORY WARNING:')) {
                        return html_entity_decode($translated, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    }
                }
            } catch (\Throwable $e) {
                Log::warning("AutoTranslate error [{$sourcePair}->{$targetPair}]: ".$e->getMessage());
            }

            return $text;
        });
    }

    /**
     * Translate longer paragraphs safely by splitting on newlines.
     */
    protected function translateLongText(string $text, string $sourcePair, string $targetPair): string
    {
        $paragraphs = explode("\n", $text);
        $translatedParagraphs = [];

        foreach ($paragraphs as $para) {
            $trimmed = trim($para);
            if (empty($trimmed)) {
                $translatedParagraphs[] = '';

                continue;
            }

            try {
                $response = Http::timeout(6)
                    ->get('https://api.mymemory.translated.net/get', [
                        'q' => $trimmed,
                        'langpair' => "{$sourcePair}|{$targetPair}",
                    ]);

                if ($response->successful()) {
                    $json = $response->json();
                    $translated = $json['responseData']['translatedText'] ?? null;
                    if (! empty($translated) && ! str_starts_with($translated, 'MYMEMORY WARNING:')) {
                        $translatedParagraphs[] = html_entity_decode($translated, ENT_QUOTES | ENT_HTML5, 'UTF-8');

                        continue;
                    }
                }
            } catch (\Throwable $e) {
                // continue with fallback
            }

            $translatedParagraphs[] = $trimmed;
        }

        return implode("\n", $translatedParagraphs);
    }

    /**
     * Translate an Eloquent model's attributes to all supported foreign languages and save them.
     */
    public function translateModel(Model $model, array $fields, ?array $targetLocales = null): void
    {
        $locales = $targetLocales ?: array_keys($this->localeMap);
        $modelBasename = class_basename($model);

        foreach ($locales as $locale) {
            $translations = $this->loadLocaleStore($locale);
            $modified = false;

            foreach ($fields as $field) {
                $originalValue = $model->getAttribute($field);
                if (empty($originalValue) || ! is_string($originalValue)) {
                    continue;
                }

                $key = $this->resolveModelKey($modelBasename, $model, $field);
                if ($key) {
                    $translated = $this->translate($originalValue, $locale, 'id');
                    if ($translated !== $originalValue) {
                        $translations[$key] = $translated;
                        $modified = true;
                    }
                }
            }

            if ($modified) {
                $this->saveLocaleStore($locale, $translations);
            }
        }
    }

    /**
     * Retrieve a stored translation by key and locale.
     */
    public function getStoredTranslation(string $key, string $locale): ?string
    {
        if ($locale === 'id') {
            return null;
        }

        $translations = $this->loadLocaleStore($locale);

        return $translations[$key] ?? null;
    }

    /**
     * Load translations from persistent disk JSON for a given locale.
     */
    protected function loadLocaleStore(string $locale): array
    {
        if (isset($this->diskCache[$locale])) {
            return $this->diskCache[$locale];
        }

        $path = $this->getStoragePath($locale);
        if (File::exists($path)) {
            $data = json_decode(File::get($path), true);
            $this->diskCache[$locale] = is_array($data) ? $data : [];
        } else {
            $this->diskCache[$locale] = [];
        }

        return $this->diskCache[$locale];
    }

    /**
     * Save translations to persistent disk JSON for a given locale.
     */
    protected function saveLocaleStore(string $locale, array $translations): void
    {
        $this->diskCache[$locale] = $translations;
        $path = $this->getStoragePath($locale);
        File::put($path, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Build the translation key for a model.
     */
    protected function resolveModelKey(string $basename, Model $model, string $field): ?string
    {
        return match ($basename) {
            'Destination' => "destinations.{$model->slug}.{$field}",
            'Story' => "stories.{$model->slug}.{$field}",
            'Program' => "programs.{$model->id}.{$field}",
            'Testimonial' => "testimonials.{$model->id}.{$field}",
            'Stat' => "stats.{$model->id}.{$field}",
            'TeamMember' => "team.{$model->id}.{$field}",
            'PageSection' => "sections.{$model->page_slug}.{$model->section_key}.{$field}",
            default => null,
        };
    }
}
