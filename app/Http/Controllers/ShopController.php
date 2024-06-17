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
            $inventory = Inventory::all();
            $category = Category::all();
            return view('shop.index', compact('category', 'inventory', 'admin'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function shop(Request $request)
    {
        $category = Category::all();
        $query = Inventory::query();

        if ($request->has('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $inventory = $query->paginate(6);

        return view('shop.products', compact('category', 'inventory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function details(string $id)
    {
        $category = Category::all();
        $product = Inventory::findOrFail($id);

        return view('shop.details', compact('product', 'category'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

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
