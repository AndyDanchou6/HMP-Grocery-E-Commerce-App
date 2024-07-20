<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceFee;
use Illuminate\Support\Facades\Auth;

class ServiceFeeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role == 'Admin') {

            $serviceFeeQuery = ServiceFee::query();

            if ($request->has('search')) {
                $search = $request->input('search');
                $serviceFeeQuery->where('location', 'like', '%' . $search . '%')
                    ->orWhere('fee_name', 'like', '%' . $search . '%')
                    ->orWhere('fee', 'like', '%'. $search .'%');
            }



            $serviceFee = $serviceFeeQuery->orderBy('created_at', 'desc')->paginate(5);
            return view('serviceFee.index', compact('serviceFee'));
        } else {
            return view('error403');
        }
    }

    public function store(Request $request) {
        $existingFee = ServiceFee::where('location', $request->input('location'))
        ->first();

        if ($existingFee) {
            return redirect()->back()->with('error', 'Fee location exists. Please check your fees.');
        }

        $newFee = new ServiceFee();

        $newFee->fee_name = $request->input('fee_name');
        $newFee->location = $request->input('location');
        $newFee->fee = $request->input('fee');

        if (!$newFee->save()) {

            return redirect()->back()->with('error', 'Error adding new fee.');
        }

        return redirect()->back()->with('success', 'New fee added successfully.');
    }

    public function destroy(string $id)
    {
        $toBeDeleted = ServiceFee::findOrFail($id);

        $toBeDeleted->delete();

        return redirect()->route('serviceFee.index')->with('success', 'Deleted successfully');
    }

    public function update(Request $request, string $id) {
        $toBeUpdated = ServiceFee::findOrFail($id);

        if (!$toBeUpdated) {

            return redirect()->back()->with('error', 'Service fee does not exist!');
        }


        $alreadyExists = ServiceFee::where('fee_name', $request->input('fee_name'))
        ->where('location', $request->input('location'))
        ->first();
        
        if ($alreadyExists) {

            return redirect()->back()->with('error', 'Service fee already exists!');
        }

        $toBeUpdated->fee_name = $request->input('fee_name');
        $toBeUpdated->location = $request->input('location');
        $toBeUpdated->fee = $request->input('fee');

        if (!$toBeUpdated->save()) {

            return redirect()->back()->with('error', 'Error in deleting service fee.');
        }

        return redirect()->back()->with('success', 'Service fee updated.');
    }
}
