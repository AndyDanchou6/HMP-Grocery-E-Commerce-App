<?php

namespace App\Http\Controllers;

use App\Models\SelectedItems;
use App\Models\User;
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

    public function customerDashboard(Request $request)
    {
        if (Auth::user()->role == 'Customer') {
            $user = Auth::user();

            $totalOrders = SelectedItems::where('user_id', $user->id)->whereNotIn('status', ['forCheckout', 'denied'])->count();
            $admin = User::where('role', 'Admin')->first();
            return view('customer_home', compact('user', 'totalOrders', 'admin'));
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
