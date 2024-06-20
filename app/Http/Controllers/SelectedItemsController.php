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
    public function forPackaging()
    {
        if (empty(Auth::user()->role)) {
            return redirect()->route('error404');
        } else {
            $users = User::whereHas('selectedItems', function ($query) {
                $query->where('selected_items.status', 'forPackage');
            })->with(['selectedItems' => function ($query) {
                $query->where('selected_items.status', 'forPackage')
                    ->select('inventories.*', 'selected_items.referenceNo', 'selected_items.quantity', 'selected_items.order_retrieval');
            }])->get();

            return view('selectedItems.forPackaging', compact('users'));
        }
    }

    public function forDelivery()
    {
        if (empty(Auth::user()->role)) {
            return redirect()->route('error404');
        } else {
            $users = User::whereHas('selectedItems', function ($query) {
                $query->where('selected_items.status', 'readyForRetrieval')
                    ->where('selected_items.order_retrieval', 'delivery');
            })->with(['selectedItems' => function ($query) {
                $query->where('selected_items.status', 'readyForRetrieval')
                    ->where('selected_items.order_retrieval', 'delivery')
                    ->select('inventories.*', 'selected_items.referenceNo', 'selected_items.quantity');
            }])->get();

            return view('selectedItems.forDelivery', compact('users'));
        }
    }

    public function forPickup()
    {
        if (empty(Auth::user()->role)) {
            return redirect()->route('error404');
        } else {
            $users = User::whereHas('selectedItems', function ($query) {
                $query->where('selected_items.status', 'readyForRetrieval')
                    ->where('selected_items.order_retrieval', 'pickup');
            })->with(['selectedItems' => function ($query) {
                $query->where('selected_items.status', 'readyForRetrieval')
                    ->where('selected_items.order_retrieval', 'pickup')
                    ->select('inventories.*', 'selected_items.referenceNo', 'selected_items.quantity');
            }])->get();

            return view('selectedItems.forPickup', compact('users'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function forCheckout()
    {
        // if (empty(Auth::user()->role)) {
        //     return redirect()->route('error404');
        // } else {
        //     $users = User::whereHas('selectedItems', function ($query) {
        //         $query->where('selected_items.status', 'forPackage');
        //     })->with(['selectedItems' => function ($query) {
        //         $query->where('selected_items.status', 'forPackage')
        //             ->select('inventories.*', 'selected_items.referenceNo', 'selected_items.quantity', 'selected_items.order_retrieval');
        //     }])->get();

        //     return view('selectedItems.forPackaging', compact('users'));
        // }

        $users = User::whereHas('selectedItems', function ($query) {
            $query->where('selected_items.status', 'forCheckout');
        })->with(['selectedItems' => function ($query) {
            $query->where('selected_items.status', 'forCheckout')
                ->select('inventories.*', 'selected_items.referenceNo', 'selected_items.quantity', 'selected_items.order_retrieval', 'selected_items.status');
        }])->get();

        dd($users);
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
    public function show()
    {
        // $history = SelectedItems::where('status', 'delivered')
        // ->orWhere('status', 'pickedUp')
        // ->select('selected_items.*')
        // ->get();

        // $transactions = User::whereHas('selectedItems', function ($query) {
        //     $query->where('selected_items.status', 'delivered')
        //         ->orWhere('selected_items.status', 'pickedUp');
        // })->with('selectedItems', function ($query) {
        //     $query->where('selected_items.status', 'delivered')
        //         ->orWhere('selected_items.status', 'pickedUp')
        //         ->select('inventories.*', 'selected_items.referenceNo', 'selected_items.quantity', 'selected_items.order_retrieval');
        // })->get();

        $transactions = User::whereHas('selectedItems', function ($query) {
            $query->where('selected_items.referenceNo', 110000);
        })->with('selectedItems', function ($query) {
            $query->where('selected_items.referenceNo', 110000)
                ->select('inventories.*', 'selected_items.referenceNo', 'selected_items.quantity');
        })->get();

        dd($transactions);
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
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    public function updateStatus(Request $request, string $referenceNo)
    {
        $selectedItems  = SelectedItems::where('referenceNo', $referenceNo)->get();

        foreach ($selectedItems as $item) {

            if ($item->status == 'forPackage') {
                $item->status = 'readyForRetrieval';
                $item->save();
            } elseif ($item->status == 'readyForRetrieval') {
                if ($item->order_retrieval == 'delivery') {
                    $item->status = 'delivered';
                    $item->save();
                } elseif ($item->order_retrieval == 'pickup') {
                    $item->status = 'pickedUp';
                    $item->save();
                }
            }
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SelectedItems $selectedItems)
    {
        //
    }
}
