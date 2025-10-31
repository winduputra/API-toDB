<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class BelaController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request  = $request;
    }

    public function formUpdate()
    {
        $setting    = Setting::where('setting_code', '=', 'bela')->first();
        if( !$setting ) {
            $setting    = Setting::create(['setting_code' => 'bela', 'setting_value' => '0']);
        }
        $bela   = $setting->setting_value;
        return view('bela.add', compact('bela'));
    }

    public function update()
    {
        $this->validate($this->request, [
            'bela' => ['required'],
        ]);

        $bela   = $this->request->bela;

        $setting    = Setting::where('setting_code', '=', 'bela')->first();
        $setting->update(['setting_value' => $bela]);

        return redirect( route('bela.update') );
    }
}
