<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::guard('admin')->check()){
            $header = "admin";
        }
        else if(Auth::guard('user')->check()){
            $header = "customer";
        }
        else{
            $header = "guest";
        }

        return view('beranda',compact('header'));
    }
}
