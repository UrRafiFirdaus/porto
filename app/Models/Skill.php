<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'proficiency' => 'integer',
        'sort_order' => 'integer',
    ];

    public function getLogoUrlAttribute(): ?string
    {
        if ($this->icon_image && file_exists(public_path($this->icon_image))) {
            return asset($this->icon_image);
        }
        return null;
    }
}
