<?php

namespace App\Models;

use App\Traits\LocalizableModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'target',
        'title',
        'subtitle',
        'description',
        'features',
        'image_path',
        'cta_text',
        'cta_url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    use LocalizableModel;

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('order', 'asc');
    }

    public function scopeForTarget(Builder $query, string $target): Builder
    {
        return $query->where('target', $target);
    }

    public function getTitleAttribute($value)
    {
        return $this->getLocalized('title');
    }

    public function getSubtitleAttribute($value)
    {
        return $this->getLocalized('subtitle');
    }

    public function getDescriptionAttribute($value)
    {
        return $this->getLocalized('description');
    }

    public function getFeaturesAttribute($value)
    {
        $localized = $this->getLocalized('features');
        if (is_array($localized)) {
            return $localized;
        }

        return $this->castAttribute('features', $value);
    }

    public function getCtaTextAttribute($value)
    {
        return $this->getLocalized('cta_text');
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image_path)) {
            return asset('assets/img/hd/sekolah-diskusi.jpg');
        }
        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            if (str_contains($this->image_path, 'googleusercontent.com') && ! str_contains($this->image_path, '=s') && ! str_contains($this->image_path, '=w')) {
                return $this->image_path.'=s0';
            }

            return $this->image_path;
        }
        if (str_starts_with($this->image_path, 'assets/')) {
            return asset($this->image_path);
        }

        return asset('storage/'.$this->image_path);
    }
}
