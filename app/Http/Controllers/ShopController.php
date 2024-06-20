<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\SelectedItems;

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
            $user = Auth::user(); // Assuming user is authenticated
            $carts = Cart::where('user_id', $user->id)->get();
            $admin = User::where('role', 'Admin')->get();
            $inventory = Inventory::with('reviews')
                ->orderBy('created_at', 'desc')
                ->take(6)->get();
            $category = Category::all();
            return view('shop.index', compact('category', 'inventory', 'admin', 'carts'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function shop(Request $request)
    {
        $query = $request->input('query');
        $categoryFilter = $request->input('category');
        $category = Category::all();

        $inventory = Inventory::with('reviews', 'category')
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where('product_name', 'LIKE', "%$query%")
                    ->orWhere('description', 'LIKE', "%$query%")
                    ->orWhere('information', 'LIKE', "%$query%");
            })
            ->when($categoryFilter, function ($queryBuilder) use ($categoryFilter) {
                $queryBuilder->where('category_id', $categoryFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('shop.products', compact('inventory', 'category', 'query', 'categoryFilter'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function details(string $id)
    {
        $category = Category::all();
        $product = Inventory::findOrFail($id);

        $reviews = $product->reviews()->with('users')->paginate(5);

        return view('shop.details', compact('product', 'category', 'reviews'));
    }

    public function checkout()
    {
        $category = Category::all();
        $user = Auth::user();

        $selectedItems = SelectedItems::with('inventory')
            ->where('user_id', $user->id)
            ->where('status', 'forCheckout')->get();

        $subtotal = $selectedItems->sum(function ($item) {
            return $item->inventory->price * $item->quantity;
        });

        $total = $subtotal;

        return view('shop.checkout', compact('category', 'selectedItems', 'subtotal', 'total', 'user'));
    }

    public function placeOrder(Request $request)
    {
        $user = Auth::user();

        $selectedItems = SelectedItems::with('inventory')
            ->where('user_id', $user->id)
            ->where('status', 'forCheckout')->get();

        foreach ($selectedItems as $item) {
            // Update the item status to 'forPackage'
            $item->update([
                'status' => 'forPackage'
            ]);

            // Check if the item's status is 'forPackage'
            if ($item->status === 'forPackage') {
                // Calculate the new inventory quantity
                $newQuantity = $item->inventory->quantity - $item->quantity;

                // Update the inventory quantity
                $item->inventory->update([
                    'quantity' => $newQuantity
                ]);
            }
        }

        return redirect()->route('shop.index')->with('success', 'Thank you for shopping, come buy again!');
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
        $user = Auth::user();
        $carts = Cart::with('inventory')->where('user_id', $user->id)->get();

        $subtotal = $carts->sum(function ($item) {
            return $item->inventory->price * $item->quantity;
        });

        $total = $subtotal;

        $category = Category::all();

        return view('shop.carts', compact('category', 'carts', 'subtotal', 'total'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
