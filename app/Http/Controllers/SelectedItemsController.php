<?php

namespace App\Http\Controllers;

use App\Models\SelectedItems;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class SelectedItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function forPackaging()
    // {
    //     $users = SelectedItems::where('status', 'forPackage')
    //         ->with([
    //             'user' => function ($query) {
    //                 $query->select('users.*'); // Select specific fields from users table
    //             },
    //             'inventory' => function ($query) {
    //                 $query->select('inventories.*'); // Select specific fields from inventories table
    //             }
    //         ])
    //         ->orderBy('created_at', 'asc')
    //         // ->select('selected_items.referenceNo', 'inventories.*', 'users.*')
    //         ->get()
    //         ->groupBy('referenceNo');

    //     $couriers = User::where('role', 'Courier')->get();

    //     $userByReference = [];

    //     foreach ($users as $referenceKey => $itemsByReference) {

    //         // $temp[] = $itemsByReference;
    //         foreach ($itemsByReference as $item) {

    //             // $temp[$item->referenceNo] = $item->referenceNo;
    //             $userByReference[$item->referenceNo]['userInfo'] = [];

    //             $userByReference[$item->referenceNo]['items'][] = $item;

    //             if (!$userByReference[$item->referenceNo]['userInfo']) {
    //                 $userByReference[$item->referenceNo]['userInfo'] = [
    //                     'id' => $item->user->id,
    //                     'referenceNo' => $item->referenceNo,
    //                     'name' => $item->user->name,
    //                     'email' => $item->user->email,
    //                     'phone' => $item->user->phone,
    //                     'fb_link' => $item->user->fb_link,
    //                     'address' => $item->user->address,
    //                     'created_at' => $item->user->created_at,
    //                     'updated_at' => $item->user->updated_at,
    //                 ];
    //             }
    //         }
    //     }

    //     // dd($temp);
    //     // return response()->json($userByReference);
    //     return view('selectedItems.forPackaging', compact('userByReference', 'couriers'));
    // }
    public function forPackaging()
    {
        if (!Auth::check() || (Auth::user()->role == 'Customer' || Auth::user()->role == 'Courier')) {
            return redirect()->route('error404');
        } else {
            // Fetch users and their selected items
            $users = User::whereHas('selectedItems', function ($query) {
                $query->where('selected_items.status', 'forPackage');
            })->with(['selectedItems' => function ($query) {
                $query->where('selected_items.status', 'forPackage')
                    ->select('inventories.*', 'selected_items.*');
            }])->orderBy('created_at', 'desc')->get();

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
                            'items' => []
                        ];
                    }
                    $userByReference[$item->referenceNo]['items'][] = $item;
                }
            }

            // Sort the items array by created_at in ascending order
            foreach ($userByReference as &$reference) {
                usort($reference['items'], function ($a, $b) {
                    return strtotime($a->created_at) - strtotime($b->created_at);
                });
            }

            $couriers = User::where('role', 'Courier')->get();

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
            }])->orderBy('created_at', 'desc')->get();

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
                            'payment_type' => $item->payment_type,
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
                    ->select('inventories.*', 'selected_items.*');
            }])->orderBy('created_at', 'desc')->get();

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
                            'payment_type' => $item->payment_type,
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

    public function show(Request $request)
    {
        if (Auth::user()->role == 'Admin') {
            $search = $request->input('search');

            $usersQuery = User::whereHas('selectedItems', function ($query) {
                $query->whereIn('selected_items.order_retrieval', ['delivery', 'pickup'])
                    ->where('status', '!=', 'forCheckout');
            });

            if ($search) {
                $usersQuery->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhereHas('selectedItems', function ($query) use ($search) {
                            $query->where('referenceNo', 'like', "%{$search}%");
                        });
                });
            }

            $users = $usersQuery->with(['selectedItems' => function ($query) {
                $query->whereIn('selected_items.order_retrieval', ['delivery', 'pickup'])
                    ->where('status', '!=', 'forCheckout')
                    ->select('inventories.*', 'selected_items.*');
            }])->orderBy('created_at', 'desc')->get();

            $userByReference = [];

            foreach ($users as $user) {
                foreach ($user->selectedItems as $item) {
                    if (!isset($userByReference[$item->referenceNo])) {
                        $courier = User::find($item->courier_id);
                        $userByReference[$item->referenceNo] = [
                            'id' => $user->id,
                            'referenceNo' => $item->referenceNo,
                            'item_id' => $item->item_id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'phone' => $item->phone,
                            'fb_link' => $item->fb_link,
                            'address' => $item->address,
                            'order_retrieval' => $item->order_retrieval,
                            'status' => $item->status,
                            'courier_id' => $courier ? $courier->name : 'Unknown',
                            'payment_type' => $item->payment_type,
                            'payment_condition' => $item->payment_condition,
                            'proof_of_delivery' => $item->proof_of_delivery ? asset('storage/' . $item->proof_of_delivery) : null,
                            'created_at' => $user->created_at,
                            'updated_at' => $user->updated_at,
                            'items' => []
                        ];
                    }
                    $userByReference[$item->referenceNo]['items'][] = $item;
                }
            }

            if ($search) {
                $userByReference = array_filter($userByReference, function ($user) use ($search) {
                    return stripos($user['referenceNo'], $search) !== false ||
                        stripos($user['name'], $search) !== false;
                });
            }

            $perPage = 5;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = array_slice($userByReference, ($currentPage - 1) * $perPage, $perPage, true);
            $paginatedItems = new LengthAwarePaginator($currentItems, count($userByReference), $perPage, $currentPage, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
            ]);

            return view('selectedItems.history', [
                'userByReference' => $paginatedItems,
                'search' => $search,
            ]);
        } else {
            return redirect()->route('error404');
        }
    }

    public function orders(Request $request)
    {
        if (Auth::user()->role == 'Courier') {
            return redirect()->route('error404');
        } else {
            $userId = Auth::id();

            $users = User::whereHas('selectedItems', function ($query) use ($userId) {
                $query->where('selected_items.status', '!=', 'forCheckout')
                    ->where('selected_items.user_id', $userId);
            })->with(['selectedItems' => function ($query) use ($userId) {
                $query->where('selected_items.status', '!=', 'forCheckout')
                    ->where('selected_items.user_id', $userId)
                    ->select('selected_items.*', 'inventories.*', 'selected_items.quantity');
            }])->orderBy('created_at', 'desc')->get();

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
                            'order_retrieval' => $item->order_retrieval,
                            'status' => $item->status,
                            'courier_id' => $courier ? $courier->name : 'Unknown',
                            'payment_type' => $item->payment_type,
                            'payment_condition' => $item->payment_condition,
                            'proof_of_delivery' => $item->proof_of_delivery ? asset('storage/' . $item->proof_of_delivery) : null,
                            'created_at' => $user->created_at,
                            'updated_at' => $user->updated_at,
                            'items' => []
                        ];
                    }
                    $userByReference[$item->referenceNo]['items'][] = $item;
                }
            }

            $perPage = 7;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = array_slice($userByReference, ($currentPage - 1) * $perPage, $perPage, true);
            $paginatedItems = new LengthAwarePaginator($currentItems, count($userByReference), $perPage, $currentPage, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
            ]);

            return view('selectedItems.orders', [
                'userByReference' => $paginatedItems,
            ]);
        }
    }

    public function courierDashboard()
    {
        if (Auth::user()->role == "Courier") {
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
            }])->orderBy('created_at', 'desc')->get();


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


    /**
     * Display the specified resource.
     */
    public function showMorning()
    {
        $specificDate = Carbon::create(2024, 6, 26);

        $morning = SelectedItems::whereDate('created_at', $specificDate)->get();

        // return response()->json([
        //     'data' => $morning
        // ]);      

        dd($morning);
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
                $item->payment_condition = $request->input('payment_condition');
            } elseif ($item->status == 'readyForRetrieval') {
                if ($item->order_retrieval == 'delivery') {

                    if ($item->payment_type == 'G-cash') {
                        $item->payment_condition = 'paid';
                    } else {
                        $item->payment_condition = $request->input('payment_condition');
                    }

                    $item->status = 'delivered';

                    if ($request->hasFile('proof_of_delivery')) {
                        $avatarPath = $request->file('proof_of_delivery')->store('delivery', 'public');
                        $item->proof_of_delivery = $avatarPath;
                    }
                } elseif ($item->order_retrieval == 'pickup') {
                    $item->status = 'pickedUp';

                    if ($item->payment_type == 'G-cash') {
                        $item->payment_condition = 'paid';
                    } else {
                        $item->payment_condition = $request->input('payment_condition');
                    }
                }
            }

            if ($request->has('courier_id')) {
                $item->courier_id = $request->courier_id;
            }

            $item->save();
        }

        return redirect()->back();
    }

    public function updatePaymentCondition(Request $request, string $referenceNo)
    {
        $selectedItems = SelectedItems::where('referenceNo', $referenceNo)->get();

        foreach ($selectedItems as $item) {
            if ($request->has('payment_condition')) {
                $item->payment_condition = $request->input('payment_condition');
            }

            $item->save();
        }

        return redirect()->back()->with('success', 'Paid Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SelectedItems $selectedItems)
    {
        //
    }

    public function packageCount()
    {
        $item1 = SelectedItems::where('status', 'forPackage')->get();
        $item2 = SelectedItems::where('status', 'readyForRetrieval')
            ->where('order_retrieval', 'delivery')
            ->get();
        $item3 = SelectedItems::where('status', 'readyForRetrieval')
            ->where('order_retrieval', 'pickup')
            ->get();

        $count1 = $item1->pluck('referenceNo')->unique()->count();
        $count2 = $item2->pluck('referenceNo')->unique()->count();
        $count3 = $item3->pluck('referenceNo')->unique()->count();

        return response()->json(['count1' => $count1, 'count2' => $count2, 'count3' => $count3]);
    }
}
