<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::pluck('category_name', 'id');
        $inventories = Inventory::all();
        return view('inventories.index', compact('inventories', 'categories'));
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
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'product_img' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Adjust file type and size as per your needs
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $item = new Inventory();

        $item->product_name = $request->input('product_name');
        $item->price = $request->input('price');
        $item->quantity = $request->input('quantity');
        $item->category_id = $request->input('category_id');

        if ($request->hasFile('product_img')) {
            $avatarPath = $request->file('product_img')->store('products', 'public');
            $item->product_img = $avatarPath;
        }

        $item->save();

        return redirect()->route('inventories.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $item = Inventory::findOrFail($id);

        $item->product_name = $request->input('product_name');
        $item->price = $request->input('price');
        $item->quantity = $request->input('quantity');
        $item->category_id = $request->input('category_id');

        if ($request->hasFile('product_img')) {
            $avatarPath = $request->file('product_img')->store('products', 'public');
            $item->product_img = $avatarPath;
        }

        $item->save();

        return redirect()->route('inventories.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Inventory::findOrFail($id);
        $item->delete();

        return redirect()->route('inventories.index')->with('success', 'Product deleted successfully.');
    }
}
