<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsSection extends Model
{
    protected $fillable = [
        'title_en',
        'title_ta',
        'content_en',
        'content_ta',
        'section_type',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope: active items of a given type, ordered.
     */
    public function scopeOfType($query, string $type = 'terms')
    {
        return $query->where('section_type', $type)
                     ->where('is_active', true)
                     ->orderBy('sort_order');
    }
}
