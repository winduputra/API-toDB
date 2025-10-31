<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyedia;

class PenyediaController extends Controller
{
    public function index()
    {
        $data = Penyedia::where('kd_klpd', 'D264')
            ->where('nama_klpd', 'Provinsi Lampung')
            ->get();

        $totalPaket = $data->count();
        $totalPaguRup = $data->sum('pagu');

        return view('penyedia.index', compact('data', 'totalPaket', 'totalPaguRup'));
    }
}
