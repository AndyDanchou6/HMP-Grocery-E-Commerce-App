<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function error()
    {
        return view('layouts.auth.error');
    }

    public function error404()
    {
        return view('layouts.auth.notFound');
    }

    public function customerDashboard()
    {
        if (Auth::user()->role == 'Customer') {
            return view('customer_home');
        } else {
            return redirect()->route('error404');
        }
    }

    public function courierDashboard()
    {
        if (Auth::user()->role == 'Courier') {
            return view('courier_home');
        } else {
            return redirect()->route('error404');
        }
    }
}
