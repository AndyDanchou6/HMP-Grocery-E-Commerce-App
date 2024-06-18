<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $carts = Cart::with('inventory')->where('user_id', $user->id)->get();
        $cartTotal = $carts->sum(function ($item) {
            return $item->inventory->price * $item->quantity;
        });

        return view('carts.index', compact('carts', 'cartTotal'));
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
        $user = Auth::user();
        $items = $request->input('items');

        foreach ($items as $product_id => $quantity) {

            $cartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $product_id)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Products added to cart successfully.');
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
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $cart)
    {
        $user = Cart::findOrFail($cart);

        $user->delete();

        return redirect()->route('carts.index')->with('success', 'Deleted successfully');
    }
}
