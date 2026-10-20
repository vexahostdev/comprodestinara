<?php

namespace App\Models;

use App\Traits\LocalizableModel;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'name',
        'role',
        'affiliation',
        'bio',
        'location',
        'email',
        'phone',
        'photo',
        'linkedin',
        'instagram',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    use LocalizableModel;

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order')->orderBy('id');
    }

    public function getRoleAttribute($value)
    {
        return $this->getLocalized('role');
    }

    public function getAffiliationAttribute($value)
    {
        return $this->getLocalized('affiliation');
    }

    public function getBioAttribute($value)
    {
        return $this->getLocalized('bio');
    }

    public function getPhotoUrlAttribute(): string
    {
        if (empty($this->photo)) {
            return asset('assets/img/hd/team-ryan.jpg');
        }

        if (str_starts_with($this->photo, 'team/')) {
            return asset('storage/'.$this->photo);
        }

        if (str_starts_with($this->photo, 'assets/') || str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://')) {
            return asset($this->photo);
        }

        return asset($this->photo);
    }
}
