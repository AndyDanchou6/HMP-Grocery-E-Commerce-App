<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function index()
    {
        return view('home');
    }

    public function error()
    {
        return view('layouts.auth.error');
    }

    public function error404()
    {
        return view('layouts.auth.notFound');
    }
}
