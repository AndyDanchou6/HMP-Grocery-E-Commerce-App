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

        return view('home', compact('inventories', 'categories'));
    }
}
