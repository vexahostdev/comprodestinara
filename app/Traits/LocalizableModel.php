<?php

namespace App\Traits;

use App\Services\TranslationService;
use Illuminate\Support\Facades\Lang;

trait LocalizableModel
{
    /**
     * Boot the trait and register saved event listener for automatic translation.
     */
    public static function bootLocalizableModel(): void
    {
        static::saved(function ($model) {
            // Jalankan auto-translate HANYA saat admin menyimpan perubahan data via web (bukan console/seeding/testing)
            if (request()->is('admin*') && ! app()->runningInConsole() && ! app()->runningUnitTests()) {
                try {
                    $model->autoTranslate();
                } catch (\Throwable $e) {
                    // Fail-safe: jika jaringan hosting bermasalah, proses simpan admin tetap sukses 100%
                }
            }
        });
    }

    /**
     * Get a localized attribute value if current locale is not Indonesian.
     */
    public function getLocalized(string $attribute, ?string $translationKey = null)
    {
        $original = $this->attributes[$attribute] ?? null;

        // Jangan terjemahkan jika berada di panel admin
        if (request()->is('admin*')) {
            return $original;
        }

        $locale = app()->getLocale();
        if ($locale === 'id' || empty($original)) {
            return $original;
        }

        $key = $translationKey ?: $this->resolveTranslationKey($attribute);

        // 1. Cek terjemahan kurasi manual di katalog lang/{locale}/
        if ($key && Lang::has($key)) {
            $translated = __($key);
            if (! empty($translated)) {
                return $translated;
            }
        }

        // 2. Cek terjemahan otomatis yang tersimpan di persistent store (JSON/Cache)
        if ($key) {
            $service = app(TranslationService::class);
            $stored = $service->getStoredTranslation($key, $locale);
            if (! empty($stored)) {
                return $stored;
            }

            // 3. Auto-translate on-the-fly jika belum ada dan simpan hasilnya (hanya di web request produksi/lokal)
            if (! app()->runningUnitTests() && ! app()->runningInConsole() && is_string($original) && mb_strlen($original) > 0) {
                $autoTranslated = $service->translate($original, $locale, 'id');
                if ($autoTranslated && $autoTranslated !== $original) {
                    return $autoTranslated;
                }
            }
        }

        return $original;
    }

    /**
     * Auto-translate this model's attributes to all target foreign languages.
     */
    public function autoTranslate(?array $fields = null): void
    {
        $targetFields = $fields ?: $this->getTranslatableFields();
        if (! empty($targetFields)) {
            app(TranslationService::class)->translateModel($this, $targetFields);
        }
    }

    /**
     * Get list of fields suitable for auto-translation.
     */
    public function getTranslatableFields(): array
    {
        return match (class_basename($this)) {
            'Destination' => ['name', 'excerpt', 'narrative', 'ecological_context', 'research_focus', 'administrative_location', 'landscape_category', 'curriculum_focus', 'cultural_protocol'],
            'Story' => ['title', 'excerpt', 'content', 'elder_quote', 'elder_name', 'elder_title'],
            'Program' => ['name', 'description', 'duration_days', 'target_audience'],
            'Testimonial' => ['quote', 'author_role', 'author_school'],
            'Stat' => ['label'],
            'TeamMember' => ['name', 'role', 'bio'],
            'PageSection' => ['title', 'subtitle', 'body'],
            default => [],
        };
    }

    /**
     * Resolve default translation key based on model class.
     */
    protected function resolveTranslationKey(string $attribute): ?string
    {
        return match (class_basename($this)) {
            'PageSection' => "sections.{$this->page_slug}.{$this->section_key}.{$attribute}",
            'Destination' => "destinations.{$this->slug}.{$attribute}",
            'Program' => "programs.{$this->id}.{$attribute}",
            'Story' => "stories.{$this->slug}.{$attribute}",
            'Testimonial' => "testimonials.{$this->id}.{$attribute}",
            'Stat' => "stats.{$this->id}.{$attribute}",
            'TeamMember' => "team.{$this->id}.{$attribute}",
            default => null,
        };
    }
}
