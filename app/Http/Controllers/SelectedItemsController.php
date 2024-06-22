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
        if (!Auth::check() || (Auth::user()->role == 'Customer' || Auth::user()->role == 'Courier')) {
            return redirect()->route('error404');
        } else {
            $users = User::whereHas('selectedItems', function ($query) {
                $query->where('selected_items.status', 'forPackage');
            })->with(['selectedItems' => function ($query) {
                $query->where('selected_items.status', 'forPackage')
                    ->select('inventories.*', 'selected_items.*');
            }])->get();

            $userByReference = [];

            foreach ($users as $user) {
                foreach ($user->selectedItems as $item) {

                    if (!isset($userByReference[$item->referenceNo])) {
                        $userByReference[$item->referenceNo] = [
                            'id' => $user->id,
                            'referenceNo' => $item->referenceNo,
                            'name' => $user->name,
                            'email' => $user->email,
                            'phone' => $item->phone,
                            'fb_link' => $item->fb_link,
                            'address' => $item->address,
                            'created_at' => $user->created_at,
                            'updated_at' => $user->updated_at,
                        ];

                        $userByReference[$item->referenceNo]['items'][] = $item;
                    } else {
                        $userByReference[$item->referenceNo]['items'][] = $item;
                    }
                }
            }
            // dd($userByReference);

            $couriers = User::where('role', 'Courier')->get();
            // dd($courier[0]->id);
            return view('selectedItems.forPackaging', compact('userByReference', 'couriers'));
        }
    }


    public function forDelivery()
    {
        if (!Auth::check() || !(Auth::user()->role == 'Admin')) {
            return redirect()->route('error404');
        } else {
            $users = User::whereHas('selectedItems', function ($query) {
                $query->where('selected_items.status', 'readyForRetrieval')
                    ->where('selected_items.order_retrieval', 'delivery');
            })->with(['selectedItems' => function ($query) {
                $query->where('selected_items.status', 'readyForRetrieval')
                    ->where('selected_items.order_retrieval', 'delivery')
                    ->select('inventories.*', 'selected_items.*');
            }])->get();

            $userByReference = [];

            foreach ($users as $user) {
                foreach ($user->selectedItems as $item) {

                    if (!isset($userByReference[$item->referenceNo])) {
                        $courier = User::find($item->courier_id);
                        $userByReference[$item->referenceNo] = [
                            'id' => $user->id,
                            'referenceNo' => $item->referenceNo,
                            'name' => $user->name,
                            'email' => $user->email,
                            'phone' => $item->phone,
                            'fb_link' => $item->fb_link,
                            'address' => $item->address,
                            'courier_id' => $courier ? $courier->name : 'Unknown',
                            'created_at' => $user->created_at,
                            'updated_at' => $user->updated_at,
                        ];

                        $userByReference[$item->referenceNo]['items'][] = $item;
                    } else {
                        $userByReference[$item->referenceNo]['items'][] = $item;
                    }
                }
            }

            return view('selectedItems.forDelivery', compact('userByReference'));
        }
    }

    public function forPickup()
    {
        if (!Auth::check() || (Auth::user()->role == 'Customer' || Auth::user()->role == 'Courier')) {
            return redirect()->route('error404');
        } else {
            $users = User::whereHas('selectedItems', function ($query) {
                $query->where('selected_items.status', 'readyForRetrieval')
                    ->where('selected_items.order_retrieval', 'pickup');
            })->with(['selectedItems' => function ($query) {
                $query->where('selected_items.status', 'readyForRetrieval')
                    ->where('selected_items.order_retrieval', 'pickup')
                    ->select('inventories.*', 'selected_items.referenceNo', 'selected_items.quantity', 'selected_items.order_retrieval');
            }])->get();

            $userByReference = [];

            foreach ($users as $user) {
                foreach ($user->selectedItems as $item) {

                    if (!isset($userByReference[$item->referenceNo])) {
                        $userByReference[$item->referenceNo] = [
                            'id' => $user->id,
                            'referenceNo' => $item->referenceNo,
                            'name' => $user->name,
                            'email' => $user->email,
                            'phone' => $user->phone,
                            'fb_link' => $user->fb_link,
                            'address' => $user->address,
                            'created_at' => $user->created_at,
                            'updated_at' => $user->updated_at,
                        ];

                        $userByReference[$item->referenceNo]['items'][] = $item;
                    } else {
                        $userByReference[$item->referenceNo]['items'][] = $item;
                    }
                }
            }

            return view('selectedItems.forPickup', compact('userByReference'));
        }
    }

    public function courierDashboard()
    {
        if (Auth::user()->role == 'Courier') {
            $courier = Auth::user();

            // Query to fetch users who have selected items assigned to the authenticated courier
            $users = User::whereHas('selectedItems', function ($query) use ($courier) {
                $query->where('selected_items.status', 'readyForRetrieval')
                    ->where('selected_items.order_retrieval', 'delivery')
                    ->where('selected_items.courier_id', $courier->id);
            })->with(['selectedItems' => function ($query) use ($courier) {
                $query->where('selected_items.status', 'readyForRetrieval')
                    ->where('selected_items.order_retrieval', 'delivery')
                    ->where('selected_items.courier_id', $courier->id)
                    ->select('selected_items.*', 'inventories.*');
            }])->get();

            $userByReference = [];

            foreach ($users as $user) {
                foreach ($user->selectedItems as $item) {
                    if (!isset($userByReference[$item->referenceNo])) {
                        $userByReference[$item->referenceNo] = [
                            'id' => $user->id,
                            'referenceNo' => $item->referenceNo,
                            'name' => $user->name,
                            'email' => $user->email,
                            'phone' => $item->phone,
                            'fb_link' => $item->fb_link,
                            'address' => $item->address,
                            'created_at' => $user->created_at,
                            'updated_at' => $user->updated_at,
                        ];

                        $userByReference[$item->referenceNo]['items'][] = $item;
                    } else {
                        $userByReference[$item->referenceNo]['items'][] = $item;
                    }
                }
            }

            // Fetch courier name
            $courierName = $courier->name;

            // Return the view with compacted data
            return view('selectedItems.forCouriers', compact('userByReference', 'courierName', 'courier'));
        } else {
            return redirect()->route('error404');
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
        if (!Auth::check() || !(Auth::user()->role != 'Admin' && Auth::user()->role == 'Delivery_Driver')) {
            return redirect()->route('error404');
        } else {
            $users = User::whereHas('selectedItems', function ($query) {
                $query->where('selected_items.status', 'forCheckout');
            })->with(['selectedItems' => function ($query) {
                $query->where('selected_items.status', 'forCheckout')
                    ->select('inventories.*', 'selected_items.referenceNo', 'selected_items.quantity', 'selected_items.order_retrieval', 'selected_items.status');
            }])->get();
        }


        // dd($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function orders(Request $request)
    {
        if (Auth::user()->role == 'Courier') {
            return redirect()->route('error404');
        } else {
            $user = Auth::user();

            $selectedItems = SelectedItems::where('user_id', $user->id)
                ->where('status', '!=', 'forCheckout')
                ->with('inventory')
                ->orderBy('created_at', 'desc')
                ->paginate(6);

            return view('selectedItems.orders', compact('selectedItems'));
        }
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
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'address' => 'required',
            'fb_link' => 'required'
        ]);

        SelectedItems::create([
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'fb_link' => $request->input('fb_link')
        ]);
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
        $selectedItems = SelectedItems::where('referenceNo', $referenceNo)->get();

        foreach ($selectedItems as $item) {
            if ($item->status == 'forPackage') {
                $item->status = 'readyForRetrieval';
            } elseif ($item->status == 'readyForRetrieval') {
                if ($item->order_retrieval == 'delivery') {
                    $item->status = 'delivered';
                } elseif ($item->order_retrieval == 'pickup') {
                    $item->status = 'pickedUp';
                }
            }

            if ($request->has('courier_id')) {
                $item->courier_id = $request->courier_id;
            }

            $item->save();
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
