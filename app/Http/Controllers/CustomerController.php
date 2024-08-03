<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Models\SelectedItems;
use App\Models\Inventory;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Settings;

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


                    if ($item->serviceFee) {
                        $userByReference[$item->referenceNo]['address'] = $item->serviceFee->location;
                    }
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

            $selectedItems = SelectedItems::whereNotIn('status', ['forCheckout', 'denied', 'cancelled'])
                ->whereNull('payment_condition')
                ->where('user_id', $userId)
                ->orderByRaw("FIELD(payment_type, 'G-cash') DESC")
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

            $settings = Settings::whereIn('setting_key', ['opening_time', 'closing_time', 'phone', 'address'])
                ->pluck('setting_value', 'setting_key');

            // dd($userByReference);
            return view('customers.unpaid_orders', compact('userByReference', 'settings'));
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
        $countUnpaid = SelectedItems::whereNotIn('status', ['forCheckout', 'denied', 'cancelled'])
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

    public function notificationUpdates()
    {
        if (Auth::user()->role == 'Customer') {
            $userId = Auth::id();
            $notifications = [];
            $deliveredReferences = [];
            $today = Carbon::now()->startOfDay();

            $selectedItems = SelectedItems::where('user_id', $userId)
                ->where('status', '!=', 'forCheckout')
                ->orderBy('updated_at', 'desc')
                ->get();

            foreach ($selectedItems as $item) {
                $reference = $item->referenceNo;
                $courier = User::find($item->courier_id);
                $courierName = $courier ? $courier->name : 'Unknown Courier';
                $date = Carbon::parse($item->delivery_date)->timezone('Asia/Manila')->format('F j, Y');
                $message = '';
                $type = 'info'; // Default type
                $isToday = $item->delivery_date ? Carbon::parse($item->delivery_date)->startOfDay()->equalTo($today) : false;

                if ($item->status == 'readyForRetrieval') {
                    if (!in_array($reference, $deliveredReferences)) {
                        if ($item->order_retrieval == 'delivery') {
                            if ($isToday) {
                                $message = "Ref #<strong>$reference</strong> is out for delivery today with Courier: <strong>$courierName</strong>.";
                                $type = 'infoDelivery';
                            } elseif ($item->delivery_date && $courierName != 'Unknown Courier') {
                                $message = "Ref #<strong>$reference</strong> is scheduled for delivery on <strong>$date</strong> with Courier: <strong>$courierName</strong>.";
                                $type = 'info';
                            } elseif ($item->delivery_date) {
                                $message = "Ref #<strong>$reference</strong> is scheduled for delivery on <strong>$date</strong>.";
                                $type = 'info';
                            } elseif ($courierName != 'Unknown Courier') {
                                $message = "Ref #<strong>$reference</strong> is assigned to Courier: <strong>$courierName</strong>.";
                                $type = 'info';
                            } else {
                                $message = "Ref #<strong>$reference</strong> has been moved to the delivery section";
                                $type = 'success';
                            }
                        }
                        $deliveredReferences[] = $reference;
                    }
                    if ($item->order_retrieval == 'pickup') {
                        if (!in_array($reference, $deliveredReferences)) {
                            $message = "Ref #<strong>$reference</strong> has been moved to the pickup section. You are now authorized to take it.";
                            $type = 'success';
                            $deliveredReferences[] = $reference;
                        }
                    }
                } elseif ($item->status == 'delivered') {
                    if (!in_array($reference, $deliveredReferences)) {
                        $message = "Ref #<strong>$reference</strong> has been successfully <strong>delivered</strong>" . ($item->payment_condition == 'paid' ? " and payment is confirmed." : ".");
                        $type = 'success';
                        $deliveredReferences[] = $reference;
                    }
                } elseif ($item->status == 'pickedUp') {
                    if (!in_array($reference, $deliveredReferences)) {
                        $message = "Ref #<strong>$reference</strong> has been successfully <strong>picked up</strong>" . ($item->payment_condition == 'paid' ? " and payment is confirmed." : ".");
                        $type = 'success';
                        $deliveredReferences[] = $reference;
                    }
                } elseif ($item->status == 'denied') {
                    $message = "Ref #<strong>$reference</strong> has been <strong>denied</strong>";
                    $type = 'error';
                }

                if ($message) {
                    $notifications[] = [
                        'message' => $message,
                        'type' => $type
                    ];
                }
            }

            $notifications = array_reverse(array_unique($notifications, SORT_REGULAR));

            return response()->json([
                'notifications' => $notifications
            ]);
        } else {
            return redirect()->route('error');
        }
    }

    public function cancelOrder(int $referenceNo)
    {
        $toCancelOrders = SelectedItems::where('referenceNo', $referenceNo)
            ->get();

        if (empty($toCancelOrders)) {

            return redirect()->back()->with('error', 'No order/s found.');
        }

        if ($toCancelOrders->first()->status == 'readyForRetrieval') {

            return redirect()->back()->with('error', 'Order is ready for retrieval. Please contact the owner.');
        }

        $returnStockFail = false;
        $cancelOrderFail = false;

        foreach ($toCancelOrders as $order) {

            $inventoryItem = Inventory::findOrFail($order->item_id);

            $inventoryItem->quantity += $order->quantity;
            $order->status = 'cancelled';

            if (!$inventoryItem->save()) {

                $returnStockFail = true;
            }

            if (!$order->save()) {

                $cancelOrderFail = true;
            }
        }

        if ($returnStockFail) {

            return redirect()->back()->with('error', 'Order quantity was not return to inventory.');
        } elseif ($cancelOrderFail) {

            return redirect()->back()->with('success', 'Some order/s was not cancelled successfully.');
        }

        return redirect()->back()->with('success', 'Orders cancelled successfully.');
        // dd($toCancelOrders);
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
