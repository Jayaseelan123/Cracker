<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    protected $fillable = ['name', 'email', 'message', 'status', 'read_at'];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function replies()
    {
        return $this->hasMany(ContactInquiryReply::class)->oldest();
    }
}
