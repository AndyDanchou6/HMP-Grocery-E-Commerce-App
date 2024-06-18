<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\User;

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
            $admin = User::where('role', 'Admin')->get();
            $inventory = Inventory::with('reviews')
                ->orderBy('created_at', 'desc')
                ->take(6)->get();
            $category = Category::all();
            return view('shop.index', compact('category', 'inventory', 'admin'));
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

        return view('shop.checkout', compact('category'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
