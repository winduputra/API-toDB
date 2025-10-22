<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrategicPackage extends Model
{
    use HasFactory;

    protected $fillable     = [
        'code',
        'created_by',
        'address',
        'implementation',
    ];

    public function tender() {
        return $this->belongsTo(Tender::class, 'code', 'kd_tender');
    }

    public function user() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
