<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'SuperAdmin') {
            $user = User::count();

            return view('superAdminHome', compact('user'));
        } else {
            return redirect()->route('error');
        }
    }
}
