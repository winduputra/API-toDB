<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorEducation extends Model
{
    use HasFactory;

    protected $fillable     = [
        'vendor_id',
        'name',
        'amount',
        'created_by',
    ];
}
