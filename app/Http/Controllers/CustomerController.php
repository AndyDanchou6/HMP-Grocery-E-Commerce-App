<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Models\SelectedItems;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function orders(Request $request)
    {
        if (Auth::user()->role == 'Customer') {

            $search = $request->input('search');

            $userId = Auth::id();

            $selectedItems = SelectedItems::where('selected_items.status', '!=', 'forCheckout')
                ->where('selected_items.user_id', $userId)
                ->with('user')
                ->with('inventory')
                ->orderByRaw("FIELD(status, 'delivered', 'pickedUp') ASC")
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
                        'role' => $item->user->role,
                        'email' => $item->user->email,
                        'phone' => $item->phone,
                        'fb_link' => $item->fb_link,
                        'address' => $item->address,
                        'order_retrieval' => $item->order_retrieval,
                        'quantity' => $item->quantity,
                        'service_fee' => $item->service_fee,
                        'status' => $item->status,
                        'courier_id' => $courier ? $courier->name : 'Unknown',
                        'payment_type' => $item->payment_type,
                        'payment_condition' => $item->payment_condition,
                        'proof_of_delivery' => $item->proof_of_delivery ? asset('storage/' . $item->proof_of_delivery) : null,
                        'payment_proof' => $item->payment_proof ? asset('storage/' . $item->payment_proof) : null,
                        'delivery_date' => $item->delivery_date,
                        'reasonForDenial' => $item->reasonForDenial,
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

            return view('customers.orders', [
                'userByReference' => $paginatedItems,
                'admin' => $admin
            ]);
        } else {
            return redirect()->route('error');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function forPendingOrders(Request $request)
    {
        if (Auth::user()->role == 'Customer') {
            $userId = $request->user()->id;

            $selectedItems = SelectedItems::where('status', 'forPackage')
                ->where('user_id', $userId)
                ->with('user')
                ->with('inventory')
                ->orderBy('created_at', 'desc')
                ->get();

            $userByReference = [];

            foreach ($selectedItems as $item) {
                if (!isset($userByReference[$item->referenceNo])) {
                    $courier = User::find($item->courier_id);
                    $userByReference[$item->referenceNo] = [
                        'id' => $item->user->id,
                        'referenceNo' => $item->referenceNo,
                        'name' => $item->user->name,
                        'role' => $item->user->role,
                        'email' => $item->user->email,
                        'phone' => $item->phone,
                        'fb_link' => $item->fb_link,
                        'address' => $item->address,
                        'order_retrieval' => $item->order_retrieval,
                        'quantity' => $item->quantity,
                        'service_fee' => $item->service_fee,
                        'status' => $item->status,
                        'courier_id' => $courier ? $courier->name : 'Unknown',
                        'payment_type' => $item->payment_type,
                        'payment_condition' => $item->payment_condition,
                        'proof_of_delivery' => $item->proof_of_delivery ? asset('storage/' . $item->proof_of_delivery) : null,
                        'payment_proof' => $item->payment_proof ? asset('storage/' . $item->payment_proof) : null,
                        'delivery_date' => $item->delivery_date,
                        'reasonForDenial' => $item->reasonForDenial,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                        'items' => []
                    ];
                }
                $userByReference[$item->referenceNo]['items'][] = $item;
            }


            return view('customers.pending_orders', compact('userByReference'));
        } else {
            return redirect()->route('error');
        }
    }

    public function forUnpaidOrders(Request $request)
    {
        if (Auth::user()->role == 'Customer') {
            $userId = $request->user()->id;

            $selectedItems = SelectedItems::where('status', '!=', 'forCheckout')
                ->where('payment_condition', NULL)
                ->where('user_id', $userId)
                ->with('user')
                ->with('inventory')
                ->orderBy('created_at', 'desc')
                ->get();

            $userByReference = [];

            foreach ($selectedItems as $item) {
                if (!isset($userByReference[$item->referenceNo])) {
                    $courier = User::find($item->courier_id);
                    $userByReference[$item->referenceNo] = [
                        'id' => $item->user->id,
                        'referenceNo' => $item->referenceNo,
                        'name' => $item->user->name,
                        'role' => $item->user->role,
                        'email' => $item->user->email,
                        'phone' => $item->phone,
                        'fb_link' => $item->fb_link,
                        'address' => $item->address,
                        'order_retrieval' => $item->order_retrieval,
                        'quantity' => $item->quantity,
                        'service_fee' => $item->service_fee,
                        'status' => $item->status,
                        'courier_id' => $courier ? $courier->name : 'Unknown',
                        'payment_type' => $item->payment_type,
                        'payment_condition' => $item->payment_condition,
                        'proof_of_delivery' => $item->proof_of_delivery ? asset('storage/' . $item->proof_of_delivery) : null,
                        'payment_proof' => $item->payment_proof ? asset('storage/' . $item->payment_proof) : null,
                        'delivery_date' => $item->delivery_date,
                        'reasonForDenial' => $item->reasonForDenial,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                        'items' => []
                    ];
                }
                $userByReference[$item->referenceNo]['items'][] = $item;
            }
            $admin = User::where('role', 'Admin')->first();

            // dd($userByReference);
            return view('customers.unpaid_orders', compact('userByReference', 'admin'));
        } else {
            return redirect()->route('error');
        }
    }
    /**
     * Display the specified resource.
     */
    public function forDeliveryRetrieval(Request $request)
    {
        if (Auth::user()->role == 'Customer') {
            $userId = $request->user()->id;

            $selectedItems = SelectedItems::where('status', 'readyForRetrieval')
                ->where('order_retrieval', 'delivery')
                ->where('user_id', $userId)
                ->with('user')
                ->with('inventory')
                ->orderBy('created_at', 'desc')
                ->get();

            $userByReference = [];

            foreach ($selectedItems as $item) {
                if (!isset($userByReference[$item->referenceNo])) {
                    $courier = User::find($item->courier_id);
                    $userByReference[$item->referenceNo] = [
                        'id' => $item->user->id,
                        'referenceNo' => $item->referenceNo,
                        'name' => $item->user->name,
                        'role' => $item->user->role,
                        'email' => $item->user->email,
                        'item_id' => $item->inventory->product_name,
                        'price' => $item->inventory->price,
                        'phone' => $item->phone,
                        'fb_link' => $item->fb_link,
                        'address' => $item->address,
                        'order_retrieval' => $item->order_retrieval,
                        'quantity' => $item->quantity,
                        'service_fee' => $item->service_fee,
                        'status' => $item->status,
                        'courier_id' => $courier ? $courier->name : 'Unknown',
                        'payment_type' => $item->payment_type,
                        'payment_condition' => $item->payment_condition,
                        'proof_of_delivery' => $item->proof_of_delivery ? asset('storage/' . $item->proof_of_delivery) : null,
                        'payment_proof' => $item->payment_proof ? asset('storage/' . $item->payment_proof) : null,
                        'delivery_date' => $item->delivery_date,
                        'reasonForDenial' => $item->reasonForDenial,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                        'items' => []
                    ];
                }
                $userByReference[$item->referenceNo]['items'][] = $item;
            }

            return view('customers.delivery_retrieval', compact('userByReference'));
        } else {
            return redirect()->route('error');
        }
    }

    public function forPickupRetrieval(Request $request)
    {
        if (Auth::user()->role == 'Customer') {

            $userId = $request->user()->id;

            $selectedItems = SelectedItems::where('status', 'readyForRetrieval')
                ->where('order_retrieval', 'pickup')
                ->where('user_id', $userId)
                ->with('user')
                ->with('inventory')
                ->orderBy('created_at', 'desc')
                ->get();

            $userByReference = [];

            foreach ($selectedItems as $item) {
                if (!isset($userByReference[$item->referenceNo])) {
                    $courier = User::find($item->courier_id);
                    $userByReference[$item->referenceNo] = [
                        'id' => $item->user->id,
                        'referenceNo' => $item->referenceNo,
                        'name' => $item->user->name,
                        'role' => $item->user->role,
                        'email' => $item->user->email,
                        'item_id' => $item->inventory->product_name,
                        'price' => $item->inventory->price,
                        'phone' => $item->phone,
                        'fb_link' => $item->fb_link,
                        'address' => $item->address,
                        'order_retrieval' => $item->order_retrieval,
                        'quantity' => $item->quantity,
                        'service_fee' => $item->service_fee,
                        'status' => $item->status,
                        'courier_id' => $courier ? $courier->name : 'Unknown',
                        'payment_type' => $item->payment_type,
                        'payment_condition' => $item->payment_condition,
                        'proof_of_delivery' => $item->proof_of_delivery ? asset('storage/' . $item->proof_of_delivery) : null,
                        'payment_proof' => $item->payment_proof ? asset('storage/' . $item->payment_proof) : null,
                        'delivery_date' => $item->delivery_date,
                        'reasonForDenial' => $item->reasonForDenial,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                        'items' => []
                    ];
                }
                $userByReference[$item->referenceNo]['items'][] = $item;
            }


            return view('customers.pickup_retrieval', compact('userByReference'));
        } else {
            return redirect()->route('error');
        }
    }

    public function orderCount(Request $request)
    {
        $userId = $request->user()->id;

        $countPending = SelectedItems::where('status', 'forPackage')
            ->where('user_id', $userId)->distinct('referenceNo')
            ->count('referenceNo');
        // $countUnpaid = SelectedItems::
        $countDelivery = SelectedItems::where('status', 'readyForRetrieval')
            ->where('order_retrieval', 'delivery')->where('user_id', $userId)
            ->distinct('referenceNo')
            ->count('referenceNo');
        $countPickup = SelectedItems::where('status', 'readyForRetrieval')
            ->where('order_retrieval', 'pickup')->where('user_id', $userId)
            ->distinct('referenceNo')
            ->count('referenceNo');
        $countUnpaid = SelectedItems::where('status', '!=', 'forCheckout')
            ->where('payment_condition', '=', NULL)->where('user_id', $userId)
            ->distinct('referenceNo')
            ->count('referenceNo');


        return response()->json([
            'status' => 200,
            'count1' => $countPending,
            'count2' => $countDelivery,
            'count3' => $countPickup,
            'count4' => $countUnpaid
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }


    /**
     * Blade view for customers
     */
}
