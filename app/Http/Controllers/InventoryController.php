<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

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
        //
        $items = new Inventory();

        $items->product_name = $request->input('product_name');
        $items->price = $request->input('price');
        $items->quantity = $request->input('quantity');

        $items->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Added Successfully'
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
}
