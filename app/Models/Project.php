<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'tech_stack' => 'array',
        'is_private' => 'boolean',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail_path && file_exists(public_path($this->thumbnail_path))) {
            return asset($this->thumbnail_path);
        }
        return 'https://placehold.co/800x500/1e293b/818cf8?text=' . urlencode($this->title ?: 'Project+Preview');
    }
}
