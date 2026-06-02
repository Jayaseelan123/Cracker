<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    protected $fillable = [
        'company_name',
        'address',
        'logo',
        'contact_number',
        'whatsapp_number',
        'bank_ac_no',
        'bank_ac_name',
        'bank_ac_type',
        'bank_name',
        'bank_ifsc',
    ];
}
