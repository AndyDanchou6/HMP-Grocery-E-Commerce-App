<?php

namespace App\Http\Controllers;

use App\Models\deliverySchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DeliveryScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'Admin') {
            $schedules = DeliverySchedule::orderBy('created_at', 'desc')->get();
            return view('schedules.index', compact('schedules'));
        } else {
            return view('error403');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(deliverySchedule $deliverySchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(deliverySchedule $deliverySchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, deliverySchedule $deliverySchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(deliverySchedule $deliverySchedule)
    {
        //
    }
}
