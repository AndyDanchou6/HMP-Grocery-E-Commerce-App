<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Inventory;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // // Ensure user is authenticated
        if (Auth::check()) {
            // Fetch reviews where the authenticated user has rated products
            $reviews = Review::where('user_id', Auth::id())->with('inventory')->paginate(10);

            // Return the view with reviews data
            $products = Inventory::pluck('product_name', 'id');
            return view('reviews.index', compact('reviews', 'products'));
        } else {
            // Redirect to error page or login page if user is not authenticated
            return redirect()->route('error404');
        }
        // $products = Inventory::pluck('product_name', 'id');
        // $reviews = Review::paginate(4);

        // return view('reviews.index', compact('products', 'reviews'));
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
        $user = new Review();
        $user->user_id = auth()->user()->id;
        $user->product_id = $request->input('product_id');
        $user->rating = $request->input('rating');
        $user->comment = $request->input('comment');

        $user->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:inventories,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Review::findOrFail($id);

        $user->user_id = auth()->user()->id;
        $user->product_id = $request->input('product_id');
        $user->rating = $request->input('rating');
        $user->comment = $request->input('comment');

        $user->save();

        return redirect()->route('reviews.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Review::findOrFail($id);

        $user->delete();

        return redirect()->route('reviews.index')->with('success', 'Deleted successfully');
    }
}
