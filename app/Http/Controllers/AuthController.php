<?php

namespace App\Http\Controllers;

use App\Models\SelectedItems;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings;

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


            $settings = Settings::whereIn('setting_key', ['phone'])
                ->pluck('setting_value', 'setting_key');

            return view('customer_home', compact('user', 'totalOrders', 'admin', 'settings'));
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
