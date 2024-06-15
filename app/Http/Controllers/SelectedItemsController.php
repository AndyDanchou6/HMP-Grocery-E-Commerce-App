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
                // Add a condition on the pivot table (selected_items)
                $query->where('selected_items.status', 'purchased');
            })->with(['selectedItems' => function ($query) {
                // Include the pivot data (reference_number) with the condition applied
                $query->where('selected_items.status', 'purchased')
                    ->select('inventories.*', 'selected_items.referenceNo');
            }])->get();

            $purchaser = [];

            foreach ($users as $user) {
                $userDetails = [
                    'id' => $user->id,
                    'username' => $user->name,
                    'address' => $user->address,
                    'phone' => $user->phone,
                    'fb_link' => $user->fb_link,
                    'referenceNo' => '',
                    'grossTotal' => 0,
                    'items' => []
                ];

                $tempStore = [];

                foreach ($user->selectedItems as $item) {
                    if (!isset($tempStore[$item->id])) {
                        $tempStore[$item->id] = [
                            'item' => $item,
                            'count' => 1,
                            'total' => $item->price
                        ];
                    } else {
                        $tempStore[$item->id]['count']++;
                        $tempStore[$item->id]['total'] += $item->price;
                    }
                    if (empty($userDetails['referenceNo'])) {
                        $userDetails['referenceNo'] = $item->referenceNo;
                    }

                    $userDetails['grossTotal'] += $item->price;
                }

                // Assign items to user details
                $userDetails['items'] = array_values($tempStore); // Reset keys to numeric indices

                // Add user details to purchaser array
                $purchaser[] = $userDetails;
            }

            return view('selectedItems.index', compact('purchaser'));
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
    public function update(Request $request, string $id)
    {
        $selected = SelectedItems::findOrFail($id);

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
