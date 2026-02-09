<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku','name','name_en','name_ta','rate','price','mrp','discount_rate','final_price',
        'min_order_value','max_order_value','stock','status','image','image_path','category_id'
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the image URL for the product
     */
    public function getImageUrl()
    {
        $imagePath = $this->image_path ?: $this->image ?: null;
        if ($imagePath) {
            return asset('product_images/' . $imagePath);
        }
        return asset('images/placeholder.png');
    }
}