<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SelectedItems;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'Admin') {
            $user = Auth::user();
            $carts = Cart::with('inventory')->where('user_id', $user->id)->get();
            $cartTotal = 0;

            return view('carts.index', compact('carts', 'cartTotal'));
        } else {
            return redirect()->route('error404');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function checkout(Request $request)
    {
        try {
            $user = Auth::user();

            $orderRetrievalType = $request->input('orderRetrievalType');

            if (!$orderRetrievalType) {
                return response()->json(['success' => false, 'message' => 'Please select order retrieval type before proceeding to checkout.']);
            }

            $items = Cart::where('user_id', $user->id)->get();

            if ($items->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No items found in the cart.']);
            }

            $referenceNo = rand(100000, 999999);

            foreach ($items as $item) {
                SelectedItems::create([
                    'referenceNo' => $referenceNo,
                    'user_id' => $user->id,
                    'item_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->inventory->price,
                    'order_retrieval' => $orderRetrievalType,
                    'status' => 'forCheckout'
                ]);

                $item->delete();
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Checkout Error: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'An error occurred during checkout.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $items = $request->input('items');

        foreach ($items as $inventory_id => $quantity) {
            $inventory = Inventory::find($inventory_id);

            if ($inventory) {
                // Ensure available quantity
                if ($quantity > $inventory->quantity) {
                    $quantity = $inventory->quantity;
                }

                $cartItem = Cart::where('user_id', $user->id)
                    ->where('product_id', $inventory_id)
                    ->first();

                if ($cartItem) {
                    // Update existing cart item
                    $newQuantity = $cartItem->quantity + $quantity;

                    // Limit the quantity to available inventory
                    if ($newQuantity > $inventory->quantity) {
                        $newQuantity = $inventory->quantity;
                    }

                    $cartItem->quantity = $newQuantity;
                    $cartItem->save();
                } else {
                    Cart::create([
                        'user_id' => $user->id,
                        'product_id' => $inventory_id,
                        'quantity' => $quantity,
                    ]);
                }
            }
        }

        return redirect()->back();
    }
    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $quantities = $request->input('quantities', []);
        foreach ($quantities as $cartId => $quantity) {
            $cart = Cart::find($cartId);

            if ($cart) {
                $inventory = $cart->inventory;
                if ($inventory) {
                    if ($quantity > $inventory->quantity) {
                        $quantity = $inventory->quantity;
                    }
                    $cart->quantity = $quantity;
                    $cart->save();
                }
            }
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $cart)
    {
        $user = Cart::findOrFail($cart);

        $user->delete();

        return response()->json(['success' => true]);
    }

    public function destroyAll(string $cart)
    {
        $user = Cart::findOrFail($cart);

        $user->delete();

        return redirect()->back();
    }
}
