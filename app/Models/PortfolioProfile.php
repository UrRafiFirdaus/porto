<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioProfile extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'available_for_work' => 'boolean',
    ];

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar_path && file_exists(public_path($this->avatar_path))) {
            return asset($this->avatar_path);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name ?: 'Admin') . '&size=256&background=4f46e5&color=fff&bold=true';
    }

    public function getCvUrlAttribute(): ?string
    {
        if ($this->cv_path && file_exists(public_path($this->cv_path))) {
            return asset($this->cv_path);
        }
        return null;
    }
}
