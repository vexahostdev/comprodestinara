<?php

namespace App\Models;

use App\Traits\LocalizableModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'archive_no',
        'read_time',
        'author_name',
        'author_role',
        'excerpt',
        'content',
        'image_path',
        'published_at',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    use LocalizableModel;

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderByDesc('published_at');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function getTitleAttribute($value)
    {
        return $this->getLocalized('title');
    }

    public function getExcerptAttribute($value)
    {
        return $this->getLocalized('excerpt');
    }

    public function getContentAttribute($value)
    {
        return $this->getLocalized('content');
    }

    public function getCategoryAttribute($value)
    {
        return $this->getLocalized('category');
    }

    public function getAuthorRoleAttribute($value)
    {
        return $this->getLocalized('author_role');
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image_path)) {
            return asset('assets/img/hd/story-sikka.jpg');
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
