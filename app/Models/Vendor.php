<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable     = [
        "kd_penyedia",
        "nama_penyedia",
        "npwp_penyedia",
        "director",
        "address",
        "financial_ability",
        "evaluation",
    ];

    public function tenders() {
        return $this->hasMany(Tender::class, 'kd_penyedia', 'kd_penyedia');
    }

    public function nonTenders() {
        return $this->hasMany(NonTender::class, 'kd_penyedia', 'kd_penyedia');
    }

    public function skills() {
        return $this->hasMany(VendorSkill::class, 'vendor_id');
    }

    public function educations() {
        return $this->hasMany(VendorEducation::class, 'vendor_id');
    }
}
