<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInquiryReply extends Model
{
    protected $fillable = ['contact_inquiry_id', 'message', 'is_admin'];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    public function inquiry()
    {
        return $this->belongsTo(ContactInquiry::class, 'contact_inquiry_id');
    }
}
