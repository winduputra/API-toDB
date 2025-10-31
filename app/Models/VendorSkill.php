<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorSkill extends Model
{
    use HasFactory;

    protected $fillable     = [
        'vendor_id',
        'name',
        'created_by',
    ];
}
