<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'name',
        'name_en',
        'name_ta',
        'rate',
        'price',
        'content',
        'mrp',
        'discount_rate',
        'final_price',
        'min_order_value',
        'max_order_value',
        'stock',
        'status',
        'image',
        'image_path',
        'video',
        'video_url',
        'video_status',
        'category_id'
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the display image for the product (verifies file existence)
     */
    public function getDisplayImageAttribute()
    {
        $img = $this->image_path ?: $this->image ?: null;

        if ($img && file_exists(public_path('product_images/' . $img))) {
            return asset('product_images/' . $img);
        } elseif ($img && file_exists(public_path('images/' . $img))) {
            return asset('images/' . $img);
        }

        return 'https://placehold.co/150x150/e2e8f0/64748b?text=No\nImage';
    }

    /**
     * Get the image URL for the product (backwards compatibility)
     */
    public function getImageUrl()
    {
        return $this->display_image;
    }
}