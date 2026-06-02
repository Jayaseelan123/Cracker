<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryZone extends Model
{
    protected $fillable = [
        'state_name',
        'cities',
        'all_cities',
        'min_order_amount',
        'packing_charges',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'cities'           => 'array',
        'all_cities'       => 'boolean',
        'is_active'        => 'boolean',
        'min_order_amount' => 'decimal:2',
        'packing_charges'  => 'decimal:2',
        'sort_order'       => 'integer',
    ];

    /**
     * Scope: only active zones.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Returns display string for cities.
     */
    public function getCitiesDisplayAttribute(): string
    {
        if ($this->all_cities) return 'All Cities';
        return $this->cities ? implode(', ', $this->cities) : '—';
    }
}
