<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SelectedItems;
use App\Models\Inventory;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $inventories = Inventory::where('quantity', '<=', 10)->paginate(8);
        $categories = Category::pluck('category_name', 'id');

        $user = Auth::user();

        $deliveryRequest = SelectedItems::where('order_retrieval', 'delivery')
            ->where('courier_id', $user->id)
            ->where('status', 'readyForRetrieval')
            ->distinct('referenceNo')
            ->count('referenceNo');

        $delivered = SelectedItems::where('order_retrieval', 'delivery')
            ->where('courier_id', $user->id)
            ->where('status', 'delivered')
            ->distinct('referenceNo')
            ->count('referenceNo');


        return view('home', compact('inventories', 'categories', 'deliveryRequest', 'delivered'));
    }
}
