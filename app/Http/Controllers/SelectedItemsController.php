<?php

namespace App\Http\Controllers;

use App\Models\deliverySchedule;
use App\Models\SelectedItems;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class SelectedItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function forPackaging(Request $request)
    {
        $search = $request->input('search');

        $selectedItems = SelectedItems::where('status', 'forPackage')
            ->with('user')
            ->with('inventory')
            ->orderBy('created_at', 'asc');

        if ($search) {
            $selectedItems->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })->orWhere('referenceNo', 'like', "%{$search}%");
            });
        }

        $selectedItems = $selectedItems->get();

        $userByReference = [];

        foreach ($selectedItems as $item) {
            if (!isset($userByReference[$item->referenceNo])) {
                $userByReference[$item->referenceNo] = [
                    'id' => $item->id,
                    'user_id' => $item->user->id,
                    'referenceNo' => $item->referenceNo,
                    'name' => $item->user->name,
                    'email' => $item->user->email,
                    'phone' => $item->phone,
                    'fb_link' => $item->fb_link,
                    'address' => $item->address,
                    'order_retrieval' => $item->order_retrieval,
                    'quantity' => $item->quantity,
                    'courier_id' => $item->courier_id,
                    'payment_type' => $item->payment_type,
                    'payment_condition' => $item->payment_condition,
                    'proof_of_delivery' => $item->proof_of_delivery,
                    'delivery_date' => $item->delivery_date,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'items' => []
                ];
            }

            $userByReference[$item->referenceNo]['items'][] = $item->inventory;
        }

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($userByReference, ($currentPage - 1) * $perPage, $perPage, true);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($userByReference), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('selectedItems.forPackaging', [
            'forPackage' => $paginatedItems,
            'search' => $search,
        ]);

        // return view('selectedItems.forPackaging', compact('forPackage'));
        // dd($forPackage);
    }

    // public function forPackaging()
    // {
    //     if (!Auth::check() || (Auth::user()->role == 'Customer' || Auth::user()->role == 'Courier')) {
    //         return redirect()->route('error404');
    //     } else {
    //         // Fetch users and their selected items
    //         $users = User::whereHas('selectedItems', function ($query) {
    //             $query->where('selected_items.status', 'forPackage')
    //                 ->orderBy('selected_items.created_at', 'desc'); 
    //         })->with(['selectedItems' => function ($query) {
    //             $query->where('selected_items.status', 'forPackage')
    //                 ->select('inventories.*', 'selected_items.*')
    //                 ->orderBy('selected_items.created_at', 'desc'); 
    //         }])->orderBy('created_at', 'asc')->get();

    //         $userByReference = [];

    //         foreach ($users as $user) {
    //             foreach ($user->selectedItems as $item) {
    //                 if (!isset($userByReference[$item->referenceNo])) {
    //                     $userByReference[$item->referenceNo] = [
    //                         'id' => $user->id,
    //                         'referenceNo' => $item->referenceNo,
    //                         'name' => $user->name,
    //                         'email' => $user->email,
    //                         'phone' => $item->phone,
    //                         'fb_link' => $item->fb_link,
    //                         'address' => $item->address,
    //                         'order_retrieval' => $item->order_retrieval,
    //                         'payment_type' => $item->payment_type,
    //                         'created_at' => $user->created_at,
    //                         'updated_at' => $user->updated_at,
    //                         'items' => []
    //                     ];
    //                 }
    //                 $userByReference[$item->referenceNo]['items'][] = $item;
    //             }
    //         }

    //         // Sort the items array by created_at in ascending order
    //         foreach ($userByReference as &$reference) {
    //             usort($reference['items'], function ($a, $b) {
    //                 return strtotime($a->created_at) - strtotime($b->created_at);
    //             });
    //         }

    //         return view('selectedItems.forPackaging', compact('userByReference'));
    //     }
    // }

    public function forDelivery(Request $request)
    {
        // if (!Auth::check() || !(Auth::user()->role == 'Admin')) {
        //     return redirect()->route('error404');
        // } else {
        $search = $request->input('search');

        $selectedItems = SelectedItems::where('status', 'readyForRetrieval')
            ->where('order_retrieval', 'delivery')
            ->with('user')
            ->with('inventory')
            ->orderBy('delivery_date', 'asc');

        if ($search) {
            $selectedItems->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })->orWhere('referenceNo', 'like', "%{$search}%");
            });
        }

        $selectedItems = $selectedItems->get();

        $userByReference = [];

        foreach ($selectedItems as $item) {
            if (!isset($userByReference[$item->referenceNo])) {
                $userByReference[$item->referenceNo] = [
                    'id' => $item->id,
                    'user_id' => $item->user->id,
                    'referenceNo' => $item->referenceNo,
                    'name' => $item->user->name,
                    'email' => $item->user->email,
                    'phone' => $item->phone,
                    'fb_link' => $item->fb_link,
                    'address' => $item->address,
                    'order_retrieval' => $item->order_retrieval,
                    'quantity' => $item->quantity,
                    'courier_id' => $item->courier_id,
                    'service_fee' => $item->service_fee,
                    'payment_type' => $item->payment_type,
                    'payment_condition' => $item->payment_condition,
                    'proof_of_delivery' => $item->proof_of_delivery,
                    'delivery_date' => $item->delivery_date,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'items' => []
                ];
            }

            $userByReference[$item->referenceNo]['items'][] = $item->inventory;
        }

        $schedules = deliverySchedule::where('status', 'Active')->get();
        $couriers = User::where('role', 'Courier')->get();

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($userByReference, ($currentPage - 1) * $perPage, $perPage, true);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($userByReference), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('selectedItems.forDelivery', [
            'forDelivery' => $paginatedItems,
            'search' => $search,
            'couriers' => $couriers,
            'schedules' => $schedules
        ]);

        // }
    }

    public function forPickup(Request $request)
    {
        // if (!Auth::check() || (Auth::user()->role == 'Customer' || Auth::user()->role == 'Courier')) {
        //     return redirect()->route('error404');
        // } else {
        $search = $request->input('search');

        $selectedItems = SelectedItems::where('status', 'readyForRetrieval')
            ->where('order_retrieval', 'pickup')
            ->with('user')
            ->with('inventory');

        if ($search) {
            $selectedItems->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })->orWhere('referenceNo', 'like', "%{$search}%");
            });
        }

        $selectedItems = $selectedItems->get();

        $userByReference = [];

        foreach ($selectedItems as $item) {
            if (!isset($userByReference[$item->referenceNo])) {
                $userByReference[$item->referenceNo] = [
                    'id' => $item->id,
                    'user_id' => $item->user->id,
                    'referenceNo' => $item->referenceNo,
                    'name' => $item->user->name,
                    'email' => $item->user->email,
                    'phone' => $item->phone,
                    'fb_link' => $item->fb_link,
                    'address' => $item->address,
                    'order_retrieval' => $item->order_retrieval,
                    'quantity' => $item->quantity,
                    'courier_id' => $item->courier_id,
                    'payment_type' => $item->payment_type,
                    'payment_condition' => $item->payment_condition,
                    'proof_of_delivery' => $item->proof_of_delivery,
                    'delivery_date' => $item->delivery_date,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'items' => []
                ];
            }

            $userByReference[$item->referenceNo]['items'][] = $item->inventory;
        }

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($userByReference, ($currentPage - 1) * $perPage, $perPage, true);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($userByReference), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('selectedItems.forPickup', [
            'forPickup' => $paginatedItems,
            'search' => $search,
        ]);
        // }
    }
    public function show(Request $request)
    {
        if (Auth::user()->role == 'Admin') {
            $search = $request->input('search');

            $selectedItemsQuery = SelectedItems::where('status', '!=', 'forCheckout')
                ->whereIn('order_retrieval', ['delivery', 'pickup'])
                ->with('user')
                ->with('inventory');

            if ($search) {
                $selectedItemsQuery->where(function ($query) use ($search) {
                    $query->whereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })->orWhere('referenceNo', 'like', "%{$search}%")
                        ->orWhere('payment_condition', 'like', "%{$search}%");
                });
            }

            $selectedItems = $selectedItemsQuery->orderBy('created_at', 'desc')->get();

            $userByReference = [];

            foreach ($selectedItems as $item) {
                if (!isset($userByReference[$item->referenceNo])) {
                    $courier = User::find($item->courier_id);
                    $userByReference[$item->referenceNo] = [
                        'id' => $item->user->id,
                        'referenceNo' => $item->referenceNo,
                        'name' => $item->user->name,
                        'email' => $item->user->email,
                        'phone' => $item->phone,
                        'fb_link' => $item->fb_link,
                        'address' => $item->address,
                        'order_retrieval' => $item->order_retrieval,
                        'quantity' => $item->quantity,
                        'status' => $item->status,
                        'courier_id' => $courier ? $courier->name : 'Unknown',
                        'payment_type' => $item->payment_type,
                        'payment_condition' => $item->payment_condition,
                        'proof_of_delivery' => $item->proof_of_delivery ? asset('storage/' . $item->proof_of_delivery) : null,
                        'delivery_date' => $item->delivery_date,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                        'items' => []
                    ];
                }
                $userByReference[$item->referenceNo]['items'][] = $item;
            }

            $perPage = 10;
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
            $search = $request->input('search');

            $userId = Auth::id();

            $selectedItems = SelectedItems::where('selected_items.status', '!=', 'forCheckout')
                ->where('selected_items.user_id', $userId)
                ->with('user')
                ->with('inventory')
                ->orderBy('created_at', 'desc');


            if ($search) {
                $selectedItems->where(function ($query) use ($search) {
                    $query->whereHas('user', function ($query) use ($search) {
                        $query->where('referenceNo', 'like', "%{$search}%");
                    });
                });
            }

            $selectedItems = $selectedItems->get();

            $userByReference = [];

            foreach ($selectedItems as $item) {
                if (!isset($userByReference[$item->referenceNo])) {
                    $courier = User::find($item->courier_id);
                    $userByReference[$item->referenceNo] = [
                        'id' => $item->user->id,
                        'referenceNo' => $item->referenceNo,
                        'name' => $item->user->name,
                        'email' => $item->user->email,
                        'phone' => $item->phone,
                        'fb_link' => $item->fb_link,
                        'address' => $item->address,
                        'order_retrieval' => $item->order_retrieval,
                        'quantity' => $item->quantity,
                        'status' => $item->status,
                        'courier_id' => $courier ? $courier->name : 'Unknown',
                        'payment_type' => $item->payment_type,
                        'payment_condition' => $item->payment_condition,
                        'proof_of_delivery' => $item->proof_of_delivery ? asset('storage/' . $item->proof_of_delivery) : null,
                        'delivery_date' => $item->delivery_date,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                        'items' => []
                    ];
                }
                $userByReference[$item->referenceNo]['items'][] = $item;
            }

            $perPage = 10;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = array_slice($userByReference, ($currentPage - 1) * $perPage, $perPage, true);
            $paginatedItems = new LengthAwarePaginator($currentItems, count($userByReference), $perPage, $currentPage, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
            ]);

            $admin = User::where('role', 'Admin')->first();

            return view('selectedItems.orders', [
                'userByReference' => $paginatedItems,
                'admin' => $admin
            ]);
        }
    }

    // public function orders(Request $request)
    // {
    //     if (Auth::user()->role == 'Courier') {
    //         return redirect()->route('error404');
    //     }


    //     $userId = Auth::id();

    //     $selectedItems = SelectedItems::where('status', '!=', 'forCheckout')
    //     ->where('user_id', $userId)
    //         ->with(['user', 'inventory'])
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     $userByReference = [];

    //     foreach ($selectedItems as $item) {
    //         if (!isset($userByReference[$item->referenceNo])) {
    //             $courier = User::find($item->courier_id);
    //             $userByReference[$item->referenceNo] = [
    //                 'id' => $item->id,
    //                 'referenceNo' => $item->referenceNo,
    //                 'name' => $item->name,
    //                 'email' => $item->email,
    //                 'phone' => $item->phone,
    //                 'fb_link' => $item->fb_link,
    //                 'address' => $item->address,
    //                 'order_retrieval' => $item->order_retrieval,
    //                 'status' => $item->status,
    //                 'courier_id' => $courier ? $courier->name : 'Unknown',
    //                 'payment_type' => $item->payment_type,
    //                 'payment_condition' => $item->payment_condition,
    //                 'proof_of_delivery' => $item->proof_of_delivery ? asset('storage/' . $item->proof_of_delivery) : null,
    //                 'delivery_date' => $item->delivery_date,
    //                 'created_at' => $item->created_at,
    //                 'updated_at' => $item->updated_at,
    //                 'items' => []
    //             ];
    //         }
    //         $userByReference[$item->referenceNo]['items'][] = $item;
    //     }

    //     $perPage = 7;
    //     $currentPage = LengthAwarePaginator::resolveCurrentPage();
    //     $currentItems = array_slice($userByReference, ($currentPage - 1) * $perPage, $perPage, true);
    //     $paginatedItems = new LengthAwarePaginator($currentItems, count($userByReference), $perPage, $currentPage, [
    //         'path' => LengthAwarePaginator::resolveCurrentPath(),
    //     ]);

    //     $admin = User::where('role', 'Admin')->first();

    //     return view('selectedItems.orders', [
    //         'userByReference' => $paginatedItems,
    //         'admin' => $admin
    //     ]);
    // }

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
                    ->select('selected_items.*', 'inventories.*', 'selected_items.quantity');
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
                            'delivery_date' => $item->delivery_date,
                            'quantity' => $item->quantity,
                            'created_at' => $item->created_at,
                            'updated_at' => $item->updated_at,
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

                if ($request->has('order_retrieval')) {
                    $item->order_retrieval = $request->input('order_retrieval');
                }

                if ($request->has('payment_type')) {
                    $item->payment_type = $request->input('payment_type');
                }

                $item->status = 'readyForRetrieval';
                $item->payment_condition = $request->input('payment_condition');
            } elseif ($item->status == 'readyForRetrieval') {

                if ($item->order_retrieval == 'pickup' && $request->input('order_retrieval') == 'pickup') {

                    $pickedUp = $item->payment_type == $request->input('payment_type') && $item->payment_condition == $request->input('payment_condition');

                    if ($pickedUp) {
                        $item->status = 'pickedUp';
                    }
                }

                if ($request->input('order_retrieval') == 'pickup')

                    if ($request->input('payment_condition') == 'paid') {

                        $item->payment_condition = $request->input('payment_condition');
                    }

                if ($request->hasFile('proofOfDelivery') && $request->input('order_retrieval') == 'delivery') {
                    $avatarPath = $request->file('proofOfDelivery')->store('delivery', 'public');
                    $item->proof_of_delivery = $avatarPath;
                    $item->status = 'delivered';
                }

                if ($request->has('payment_type')) {

                    $item->payment_type = $request->input('payment_type');
                }

                if ($request->input('order_retrieval') == 'pickup' && $item->order_retrieval == 'delivery') {
                    $item->courier_id = Null;
                    $item->delivery_date = Null;
                    $item->service_fee = 0;
                }

                if ($request->has('delivery_schedule') && $request->input('order_retrieval') == 'delivery') {

                    $scheduleOfDelivery = deliverySchedule::where('id', $request->delivery_schedule)->first();

                    if (!$scheduleOfDelivery) {
                        return redirect()->back()->with('error', 'Schedule does not exists');
                    }
                    $numericValues = [
                        'Sunday' => 1,
                        'Monday' => 2,
                        'Tuesday' => 3,
                        'Wednesday' => 4,
                        'Thursday' => 5,
                        'Friday' => 6,
                        'Saturday' => 7
                    ];

                    $selectedSchedule = $numericValues[$scheduleOfDelivery->day];
                    $today = Carbon::now()->format('l');
                    $currentDay = $numericValues[$today];

                    $didNotMakeIt = strtotime(Carbon::now()->format('H:i:s')) > strtotime($scheduleOfDelivery->start_time);
                    $forNextWeek = $selectedSchedule < $currentDay;

                    $offset = '';

                    if ($forNextWeek || $didNotMakeIt) {
                        $less = count($numericValues) - $currentDay;
                        $offset = $selectedSchedule + $less;
                    } else {
                        $offset = $selectedSchedule - $currentDay;
                    }

                    $deliveryDate = Carbon::now()->addDays($offset);

                    $startTime = $scheduleOfDelivery->start_time;
                    list($startHour, $startMinute) = explode(':', $startTime);

                    $deliveryDate->setHour($startHour)
                        ->setMinute($startMinute)
                        ->setSecond(0);
                    $item->delivery_date = $deliveryDate;
                }

                if ($request->has('courier_id') && $request->input('order_retrieval') == 'delivery') {

                    $item->courier_id = $request->input('courier_id');
                }

                $item->order_retrieval = $request->input('order_retrieval');
            }

            if ($request->has('service_fee')) {
                if ($request->input('service_fee') != 0) {
                    $item->service_fee = $request->input('service_fee');
                }
            }

            $item->save();
        }

        return redirect()->back()->with('success', 'Order updated.');
        // dd($request);
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

    public function courierTask(Request $request)
    {
        $user = $request->user()->id;

        $deliveryRequest = SelectedItems::where('order_retrieval', 'delivery')
            ->where('courier_id', $user)
            ->where('status', 'readyForRetrieval')
            ->distinct('referenceNo')
            ->count('referenceNo');

        $delivered = SelectedItems::where('order_retrieval', 'delivery')
            ->where('courier_id', $user)
            ->where('status', 'delivered')
            ->distinct('referenceNo')
            ->count('referenceNo');

        return response()->json(['deliveryRequest' => $deliveryRequest, 'delivered' => $delivered]);
    }

    public function notification()
    {
        try {
            $latestItemIds = SelectedItems::where('status', 'forPackage')
                ->orderBy('created_at', 'desc')
                ->take(30)
                ->pluck('id')
                ->unique();

            if ($latestItemIds->isEmpty()) {
                return response()->json(['notification_message' => '']);
            }

            $latestReferenceNos = SelectedItems::whereIn('id', $latestItemIds)
                ->pluck('referenceNo')
                ->unique();

            $userNotifications = [];
            foreach ($latestReferenceNos as $referenceNo) {
                $selectedItems = SelectedItems::with('user')
                    ->where('referenceNo', $referenceNo)
                    ->get();

                $itemCount = $selectedItems->count();
                $userName = $selectedItems->first()->user->name ?? 'Customer';

                if ($itemCount > 0) {
                    $userNotifications[] = "$userName just bought {$itemCount} products.";
                }
            }

            $userNotifications = array_reverse($userNotifications);

            $latestNotifications = array_slice($userNotifications, 0, 15);

            return response()->json(['notification_message' => implode('. ', $latestNotifications)]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching notifications.', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateNotification(Request $request)
    {
        try {
            $referenceNo = $request->input('referenceNo');
            SelectedItems::where('referenceNo', $referenceNo)
                ->update(['status' => 'readyForRetrieval']);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating status.', 'message' => $e->getMessage()], 500);
        }
    }
}
