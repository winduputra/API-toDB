<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\Vendor;
use App\Models\VendorSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request  = $request;        
    }

    public function index()
    {
        $perPage    = $this->request->per_page;
        if( !$perPage ) {
            $perPage    = 50;
        }
        $data   = Vendor::orderBy('nama_penyedia', 'ASC')->paginate($perPage);

        return view('vendor.index', compact('data'));
    }

    public function show($code)
    {
        $vendor     = Vendor::where('kd_penyedia', '=', $code)->first();

        return view('vendor.show', compact('vendor'));
    }

    public function download()
    {

    }

    public function update($code)
    {
        $vendor     = Vendor::where('kd_penyedia', '=', $code)->first();

        if( !$vendor ) {
            return redirect( route('vendor.list') );
        }

        $payloads   = $this->request->only(['address', 'director', 'financial_ability', 'evaluation']);

        $vendor->update($payloads);

        return redirect( route('vendor.show', ['code' => $code]) );
    }

    public function addSkill($code)
    {
        $vendor     = Vendor::where('kd_penyedia', '=', $code)->first();
        if( !$vendor ) {
            return response()->json(['message' => 'Tidak ditemukan'], 404);
        }

        $auth   = Auth::user();
        $payloads   = $this->request->only(['name']);
        $payloads['created_by'] = $auth->id;
        $payloads['vendor_id']  = $vendor->id;

        $vendorSkill    = VendorSkill::create($payloads);

        return response()->json(['data' => $vendorSkill]);
    }

    public function removeSkill($id)
    {
        $skill  = VendorSkill::find($id);
        if( $skill ) {
            $skill->delete();
        }

        return response()->json(['message' => 'Berhasil menghapus data']);
    }
}
