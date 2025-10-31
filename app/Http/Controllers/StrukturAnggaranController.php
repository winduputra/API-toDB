<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StrukturAnggaran;

class StrukturAnggaranController extends Controller
{
    public function index()
    {
        $data = StrukturAnggaran::where('kd_klpd', 'D264')
            ->where('nama_klpd', 'Provinsi Lampung')
            ->get();

        $totalPaket = $data->count();
        $totalPaguRup = $data->sum('belanja_pengadaan');

        return view('struktur_anggaran.index', compact('data', 'totalPaket', 'totalPaguRup'));
    }
}

