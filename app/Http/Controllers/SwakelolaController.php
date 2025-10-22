<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Swakelola;

class SwakelolaController extends Controller
{
    public function index()
    {
        $data = Swakelola::where('kd_klpd', 'D264')
            ->where('nama_klpd', 'Provinsi Lampung')
            ->get();

        $totalPaket = $data->count();
        $totalPaguRup = $data->sum('pagu');

        return view('swakelola.index', compact('data', 'totalPaket', 'totalPaguRup'));
    }
}
