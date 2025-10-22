<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request  = $request;
    }

    public function index()
    {
        // return view('front.index');
        return view('auth.login');
    }

    public function report()
    {
        return view('dashboard.index');
    }
}
