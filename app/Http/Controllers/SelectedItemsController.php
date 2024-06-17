<?php

namespace App\Http\Controllers;

use App\Models\SelectedItems;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelectedItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (empty(Auth::user()->role)) {
            return redirect()->route('error404');
        } else {
            $users = User::whereHas('selectedItems', function ($query) {
                $query->where('selected_items.status', 'for_package');
            })->with(['selectedItems' => function ($query) {
                $query->where('selected_items.status', 'for_package')
                    ->select('inventories.*', 'selected_items.referenceNo', 'selected_items.quantity');
            }])->get();

            return view('selectedItems.index', compact('users'));
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
    public function show(SelectedItems $selectedItems)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SelectedItems $selectedItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $item_id, string $referenceNo)
    {
        $selected = SelectedItems::where('referenceNo', $referenceNo)
            ->where('item_id', $item_id)->get();

        if ($selected->isEmpty()) {
            // Handle case where no records were found
            echo "No selected items found for referenceNo $referenceNo and item_id $item_id.";
        } else {
            // Process each selected item
            foreach ($selected as $item) {
                // Access properties of each item
                echo "Item ID: {$item->id}, Reference No: {$item->referenceNo}, Item ID: {$item->item_id}, Status: {$item->status}<br>";
            }
        }

        $selected->status = $request->input('status');

        $selected->save();

        return redirect()->route('selectedItems.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SelectedItems $selectedItems)
    {
        //
    }
}
