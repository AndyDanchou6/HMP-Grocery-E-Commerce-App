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
    public function index(Request $request)
    {
        if (Auth::user()->role == 'Admin') {

            $scheduleQuery = deliverySchedule::query();

            if ($request->has('search')) {
                $search = $request->input('search');
                $scheduleQuery->where('day', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            }



            $schedules = $scheduleQuery->orderBy('created_at', 'desc')->paginate(5);
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
        $startTime = strtotime($request->input('start_time'));
        $endTime = strtotime($request->input('end_time'));
        $existing = deliverySchedule::where('day', $request->input('day'))->get();

        if ($endTime <= $startTime) {
            return redirect()->back()->with('error', 'Invalid Schedule.');
        }

        if ($existing) {
            foreach ($existing as $day) {
                if ($startTime < strtotime($day->start_time) && strtotime($day->start_time) < $endTime) {
                    // echo 'overlap1';
                    return redirect()->back()->with('error', 'Schedule overlaps with ' . $day->day . ' schedule');
                } elseif ($startTime > strtotime($day->start_time) && $startTime < strtotime($day->end_time)) {
                    // echo 'overlap2';
                    return redirect()->back()->with('error', 'Schedule overlaps with ' . $day->day . ' schedule');
                }
            }
        }

        $schedule = new deliverySchedule();

        $schedule->day = $request->input('day');
        $schedule->start_time = $request->input('start_time');
        $schedule->end_time = $request->input('end_time');

        if ($schedule->save()) {
            return redirect()->back()->with('success', 'Schedule added successfully');
        } else {
            return redirect()->back()->with('error', 'Schedule cannot be added.');
        } // dd($request->input('day'));
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
    public function update(Request $request, string $id)
    {
        $toBeUpdated = deliverySchedule::findOrFail($id);

        if (!$toBeUpdated) {

            return redirect()->back()->with('error', 'Schedule does not Exists!');
        }

        $startTime = strtotime($request->input('start_time'));
        $endTime = strtotime($request->input('end_time'));
        $existing = deliverySchedule::where('day', $request->input('day'))->get();

        if ($endTime <= $startTime) {
            return redirect()->back()->with('error', 'Invalid Schedule.');
        }

        if ($existing) {
            foreach ($existing as $day) {
                if ($startTime < strtotime($day->start_time) && strtotime($day->start_time) < $endTime) {
                    // echo 'overlap1';
                    return redirect()->back()->with('error', 'Schedule overlaps with ' . $day->day . ' schedule');
                } elseif ($startTime > strtotime($day->start_time) && $startTime < strtotime($day->end_time)) {
                    // echo 'overlap2';
                    return redirect()->back()->with('error', 'Schedule overlaps with ' . $day->day . ' schedule');
                }
            }
        }

        $toBeUpdated->start_time = $request->input('start_time');

        $toBeUpdated->end_time = $request->input('end_time');

        $toBeUpdated->day = $request->input('day');

        $toBeUpdated->status = $request->input('status');

        $updated = $toBeUpdated->save();

        if (!$updated) {
            return redirect()->back()->with('error', 'An error occurred while updating schedule.');
        }

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully');

        // dd($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $toBeDeleted = deliverySchedule::findOrFail($id);

        $toBeDeleted->delete();

        return redirect()->route('schedules.index')->with('success', 'Deleted successfully');
    }
}
