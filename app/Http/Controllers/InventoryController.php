<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'Admin') {
            $inventoryQuery = Inventory::query();

            // Handle search functionality
            if ($request->has('search')) {
                $search = $request->input('search');

                $inventoryQuery->where(function ($query) use ($search) {
                    $query->where('product_name', 'like', '%' . $search . '%')
                        ->orWhere('price', 'like', '%' . $search . '%')
                        ->orWhere('variant', 'like', '%' . $search . '%')
                        ->orWhere('quantity', 'like', '%' . $search . '%');
                })->orWhereHas('category', function ($query) use ($search) {

                    $query->where('category_name', 'like', '%' . $search . '%');
                });
            }

            $categories = Category::pluck('category_name', 'id');

            $inventories = $inventoryQuery->orderByRaw("quantity > 10 ASC")->orderByRaw("product_name ASC")->paginate(10);

            return view('inventories.index', compact('inventories', 'categories'));
        } elseif (Auth::check()) {
            return redirect()->route('error404');
        } else {
            return redirect()->route('error404');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function addAsVariant(Request $request)
    {
        $subCategory = Inventory::where('id', $request->input('subCategory'))
            ->first();

        if (!$subCategory) {
            return response()->json([
                'status' => 404,
                'message' => 'Product does not exists.'
            ]);
        }

        $currentlyAdded = Inventory::where('id', $request->input('currentlyAdded'))->first();

        if (!$currentlyAdded) {
            return response()->json([
                'status' => 404,
                'message' => 'Product does not exists.'
            ]);
        }

        $currentlyAdded->product_name = $subCategory->product_name;
        $currentlyAdded->category_id = $subCategory->category_id;
        $currentlyAdded->variant = $request->input('variant');

        if (!$currentlyAdded->save()) {
            return response()->json([
                'status' => 500,
                'message' => 'Error updating product.'
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Product added as a variant.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'variant' => 'string|max:255|nullable',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'product_img' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $item = new Inventory();

        $item->product_name = $request->input('product_name');
        $item->price = $request->input('price');
        $item->quantity = $request->input('quantity');
        $item->category_id = $request->input('category_id');
        $item->variant = $request->input('variant');


        if ($request->hasFile('product_img')) {
            $avatarPath = $request->file('product_img')->store('products', 'public');
            $item->product_img = $avatarPath;
        }

        if (!$item->save()) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to add new product',
            ]);
        }

        $newlyAdded = Inventory::where('product_name', $request->input('product_name'))
            ->orderBy('created_at', 'desc')
            ->first();

        $sameProduct = Inventory::where('id', '!=', $newlyAdded->id)
            ->where('product_name', 'like', '%' . $request->input('product_name') . '%')
            ->get()
            ->groupBy('product_name');

        if (!$sameProduct->isEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'New product has match.',
                'matches' => $sameProduct,
                'addedProductId' => $newlyAdded->id,
                'addedVariant' => $newlyAdded->variant,
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'New product is good to go.',
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
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
            'variant' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // $productNameMatched = Inventory::where('product_name', $request->input('product_name'))
        //     ->where('id', '!=', $id)
        //     ->first();

        // if ($productNameMatched) {

        //     return redirect()->back()->with('error', 'Product has match');
        // }

        $item = Inventory::findOrFail($id);

        $item->product_name = $request->input('product_name');
        $item->price = $request->input('price');
        $item->category_id = $request->input('category_id');
        $item->quantity = $request->input('quantity');

        if ($request->input('variant') != null) {
            $item->variant = $request->input('variant');
        }

        if ($request->hasFile('product_img')) {
            $avatarPath = $request->file('product_img')->store('products', 'public');
            $item->product_img = $avatarPath;
        }

        if (!$item->save()) {
            return redirect()->back()->with('error', 'Update failed');
        }

        return redirect()->back()->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Inventory::findOrFail($id);

        if (Storage::disk('public')->exists($item->product_img)) {
            if (!Storage::disk('public')->delete($item->product_img)) {

                return redirect()->back()->with('error', 'Image not deleted!');
            }
        }

        if (!$item->delete()) {

            return redirect()->back()->with('error', 'Deletion failed!');
        }

        return redirect()->back()->with('success', 'Deleted successfully.');
    }

    public function criticalProducts(Request $request)
    {

        $inventories = Inventory::where('quantity', '<=', 10)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json(['inventories' => $inventories]);
        }

        return view('inventories.index', compact('inventories'));
    }

    public function availableStocks()
    {

        try {
            $products = Inventory::select('id', 'quantity')
                ->get();
            if ($products) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Available stocks fetched.',
                    'data' => $products,
                ]);
            }

            return response()->json(['status' => '404', 'message' => 'No products available.']);
        } catch (\Exception $e) {

            return response()->json(['error', 'message' => 'System error!']);
        }
    }

    public function test()
    {
        $productByName = Inventory::all()->groupBy('product_name');

        dd($productByName);
    }

    public function restock(Request $request, string $itemId)
    {

        $restockItem = Inventory::findOrFail($itemId);

        if (empty($restockItem)) {

            return redirect()->back()->with('error', 'Product not found!');
        }

        $restockItem->quantity += $request->quantity;
        if (!$restockItem->save()) {
            return redirect()->back()->with('error', 'Restocking failed!');
        }

        return redirect()->back()->with('success', 'Restocking successful');
    }
}
