<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('inventories.index');
    }

    public function getAllData()
    {
        $items = Inventory::orderBy('created_at', 'asc')->get();

        return response()->json($items);
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $items = new Inventory();

        $items->product_name = $request->input('product_name');
        $items->price = $request->input('price');
        $items->quantity = $request->input('quantity');
        $items->category_id = $request->input('category_id');

        if ($request->hasFile('product_img')) {
            $avatarPath = $request->file('product_img')->store('products', 'public');
            $items->product_img = $avatarPath;
        }

        $items->save();

        return response()->json([
            'status' => true,
            'message' => 'Added Successfully',
        ]);
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
        // 
        $items = Inventory::findOrFail($id);

        $items->product_name = $request->input('product_name');
        $items->price = $request->input('price');
        $items->quantity = $request->input('quantity');

        $items->save();

        return response()->json([
            'status' => true,
            'message' => 'Updated Successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 
        $items = Inventory::findOrFail($id);

        $items->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully'
        ]);
    }

    public function getData(string $id)
    {
        $user = Inventory::findOrFail($id);

        return response()->json($user);
    }
}
