<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Keep fillable in sync with the actual `orders` table columns
    protected $fillable = [
        'order_number', 'customer_name', 'customer_phone', 'customer_email',
        'customer_address', 'city', 'place', 'state', 'pincode',
        'total_amount', 'packing_charges', 'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
