<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NonTenderBapbast extends Model
{
    protected $table = 'non_tender_bapbast';

    protected $guarded = [];

    public $timestamps = true;

    public static function uniqueKeys($data)
    {
        return [
            'kd_lpse' => $data['kd_lpse'],
            'kd_nontender' => $data['kd_nontender'],
            'no_kontrak' => $data['no_kontrak'],
            'no_bast' => $data['no_bast'],
            'no_bap' => $data['no_bap'],
        ];
    }
}
