<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request  = $request;
    }

    public function login()
{
    $this->validate($this->request, [
        'username' => ['required'],
        'password' => ['required'],
    ], [
        'username.required' => 'Username harus diisi',
        'password.required' => 'Password harus diisi',
    ]);

    $request = $this->request->only(['username', 'password']);

    $user = User::where('username', '=', trim($request['username']))->first();
    if (!$user) {
        return redirect(route('front'))->withErrors(['Username tidak ditemukan']);
    }

    if (Auth::attempt($request)) {
        $user = Auth::user();

        if ($user->role_id == 1) {
            return redirect()->route('non-tender.list'); // admin
        } else {
            return redirect()->route('home'); // user biasa ke halaman SIBaJA
        }
    }

    return redirect(route('front'))->withErrors(['Username dan password salah']);
}

    


    public function logout()
    {
        // Auth::guard()->logout();

        $this->request->session()->invalidate();

        $this->request->session()->regenerateToken();

        return redirect( route('front') );
    }
}
