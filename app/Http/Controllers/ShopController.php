<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\SelectedItems;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use App\Models\ServiceFee;
use App\Models\Settings;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (empty(auth()->user()->role)) {
            return redirect()->route('error404');
        } else {
            $user = Auth::user();
            $carts = Cart::where('user_id', $user->id)->get();
            $admin = User::where('role', 'Admin')->get();
            $inventory = Inventory::orderBy('created_at', 'desc')
                ->get()
                ->groupBy('product_name');

            $category = Category::all();

            $settings = Settings::whereIn('setting_key', ['opening_time', 'closing_time', 'phone', 'address', 'fb_page', 'fb_link'])
                ->pluck('setting_value', 'setting_key');

            $openingTime = $settings->has('opening_time') ? Carbon::parse($settings['opening_time'])->format('h:i A') : 'N/A';
            $closingTime = $settings->has('closing_time') ? Carbon::parse($settings['closing_time'])->format('h:i A') : 'N/A';

            return view('shop.index', compact('category', 'inventory', 'admin', 'carts', 'settings', 'openingTime', 'closingTime'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function shop(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('error404');
        } else {
            $query = $request->input('query');
            $categoryFilter = $request->input('subCategory');
            $category_filter = $request->input('category');
            $category = Category::all();

            $inventory = Inventory::with('category')
                ->when($query, function ($queryBuilder) use ($query) {
                    $queryBuilder->where('product_name', 'LIKE', "%$query%")
                        ->orWhereHas('category', function ($categoryQuery) use ($query) {
                            $categoryQuery->where('category_name', 'LIKE', "%$query%");
                        });
                })
                ->when($categoryFilter, function ($queryBuilder) use ($categoryFilter) {
                    $queryBuilder->where('product_name', $categoryFilter);
                })
                ->when($category_filter, function ($queryBuilder) use ($category_filter) {
                    $queryBuilder->where('category_id', $category_filter);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $subCategory = Inventory::orderBy('created_at', 'desc')
                ->get()
                ->groupBy('product_name');


            $settings = Settings::whereIn('setting_key', ['opening_time', 'closing_time', 'phone', 'address', 'fb_page', 'fb_link'])
                ->pluck('setting_value', 'setting_key');

            $openingTime = $settings->has('opening_time') ? Carbon::parse($settings['opening_time'])->format('h:i A') : 'N/A';
            $closingTime = $settings->has('closing_time') ? Carbon::parse($settings['closing_time'])->format('h:i A') : 'N/A';

            return view('shop.products', compact('inventory', 'subCategory', 'category', 'query', 'categoryFilter', 'category_filter', 'settings', 'openingTime', 'closingTime'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('error404');
        }

        $category = Category::all();
        $user = Auth::user();
        $serviceFee = ServiceFee::all();

        $selectedItems = SelectedItems::with('inventory')
            ->where('user_id', $user->id)
            ->where('status', 'forCheckout')
            ->get();


        if ($selectedItems->isEmpty()) {
            abort(404);
        }

        $orderType = $selectedItems->first();
        $orderType = $orderType->order_retrieval;

        $subtotal = $selectedItems->sum(function ($item) {
            return $item->inventory->price * $item->quantity;
        });

        $total = $subtotal;

        $settings = Settings::whereIn('setting_key', ['opening_time', 'closing_time', 'phone', 'address', 'fb_page', 'fb_link'])
            ->pluck('setting_value', 'setting_key');

        $openingTime = $settings->has('opening_time') ? Carbon::parse($settings['opening_time'])->format('h:i A') : 'N/A';
        $closingTime = $settings->has('closing_time') ? Carbon::parse($settings['closing_time'])->format('h:i A') : 'N/A';

        return view('shop.checkout', compact('category', 'selectedItems', 'subtotal', 'total', 'user', 'orderType', 'serviceFee', 'settings', 'openingTime', 'closingTime'));
    }

    public function placeOrder(Request $request)
    {
        $user = Auth::user();

        try {
            $selectedItems = SelectedItems::with('inventory')
                ->where('user_id', $user->id)
                ->where('status', 'forCheckout')
                ->get();

            $sampleData = $selectedItems->first();

            if ($sampleData->order_retrieval === 'delivery') {
                if (!$request->has('service_fee_id') || $request->input('service_fee_id') == 'null') {

                    return redirect()->back()->with('error', 'No Delivery Location Selected.');
                }
            }

            foreach ($selectedItems as $item) {
                if ($item->order_retrieval === 'delivery' || $item->order_retrieval === 'pickup') {
                    $item->update([
                        'status' => 'forPackage',
                        'phone' => $request->input('phone'),
                        'service_fee_id' => $request->input('service_fee_id'),
                        'fb_link' => $request->input('fb_link'),
                        'payment_type' => $request->input('payment_type')
                    ]);
                }

                $newQuantity = $item->inventory->quantity - $item->quantity;
                $item->inventory->update([
                    'quantity' => $newQuantity
                ]);
            }

            return redirect()->route('shop.index')->with('message', 'Thank you for shopping, Check your items in dashboard!');
        } catch (\Exception $e) {
            Log::error('Place Order Error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred during order placement.');
        }
    }

    public function cancelCheckout(Request $request)
    {
        $user = Auth::user();

        try {
            $selectedItems = SelectedItems::where('user_id', $user->id)
                ->where('status', 'forCheckout')
                ->get();

            foreach ($selectedItems as $selectedItem) {
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $selectedItem->item_id,
                    'quantity' => $selectedItem->quantity
                ]);

                $selectedItem->delete();
            }

            return redirect()->route('shop.carts');
        } catch (\Exception $e) {
            Log::error('Cancel Checkout Error: ' . $e->getMessage());

            return redirect()->route('shop.carts');
        }
    }

    /**
     * Display the specified resource.
     */
    // public function search(Request $request)
    // {
    //     $query = $request->input('query');
    //     $categoryFilter = $request->input('category');
    //     $category = Category::all();

    //     $inventory = Inventory::with('reviews', 'category')
    //         ->when($query, function ($queryBuilder) use ($query) {
    //             $queryBuilder->where('product_name', 'LIKE', "%$query%")
    //                 ->orWhere('description', 'LIKE', "%$query%")
    //                 ->orWhere('information', 'LIKE', "%$query%");
    //         })
    //         ->when($categoryFilter, function ($queryBuilder) use ($categoryFilter) {
    //             $queryBuilder->where('category_id', $categoryFilter);
    //         })
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(9);

    //     return view('shop.products', compact('inventory', 'category', 'query', 'categoryFilter'));
    // }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function carts()
    {
        if (empty(Auth::user()->role)) {
            return redirect()->route('error404');
        }

        $user = Auth::user();
        $carts = Cart::with('inventory')->where('user_id', $user->id)->where('quantity', '!=', 0)->get();

        $subtotal = $carts->sum(function ($item) {
            return $item->inventory->price * $item->quantity;
        });

        $total = $subtotal;

        $category = Category::all();

        $forCheckoutStatus = SelectedItems::where('user_id', $user->id)
            ->where('status', 'forCheckout')
            ->exists();


        $settings = Settings::whereIn('setting_key', ['opening_time', 'closing_time', 'phone', 'address', 'fb_page', 'fb_link'])
            ->pluck('setting_value', 'setting_key');

        $openingTime = $settings->has('opening_time') ? Carbon::parse($settings['opening_time'])->format('h:i A') : 'N/A';
        $closingTime = $settings->has('closing_time') ? Carbon::parse($settings['closing_time'])->format('h:i A') : 'N/A';

        return view('shop.carts', compact('category', 'carts', 'subtotal', 'total', 'forCheckoutStatus', 'settings', 'openingTime', 'closingTime'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function countOrders()
    {
        $userId = Auth::id();
        $cartOrders = Cart::where('user_id', $userId)->select('product_id')
            ->count();
        $pendingOrders = SelectedItems::where('user_id', $userId)->where('status', 'forPackage')
            ->pluck('referenceNo')->unique()->count();

        return response()->json([
            'cartsCount' => $cartOrders,
            'pendingOrders' => $pendingOrders
        ]);
    }

    public function contacts()
    {
        $category = Category::all();

        $settings = Settings::whereIn('setting_key', ['opening_time', 'closing_time', 'phone', 'address', 'fb_page', 'fb_link', 'map_url'])
            ->pluck('setting_value', 'setting_key');

        $openingTime = $settings->has('opening_time') ? Carbon::parse($settings['opening_time'])->format('h:i A') : 'N/A';
        $closingTime = $settings->has('closing_time') ? Carbon::parse($settings['closing_time'])->format('h:i A') : 'N/A';

        return view('shop.contacts', compact('category', 'settings', 'openingTime', 'closingTime'));
    }
}
