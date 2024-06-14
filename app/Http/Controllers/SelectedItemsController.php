<?php

namespace App\Http\Controllers;

use App\Models\SelectedItems;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelectedItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (empty(Auth::user()->role)) {
            return redirect()->route('error404');
        } else {
            $selectedItems = SelectedItems::all()->groupBy('referenceNo'); // or retrieve data as needed
            return view('selectedItems.index', compact('selectedItems'));
        }
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
    }

    /**
     * Display the specified resource.
     */
    public function show(SelectedItems $selectedItems)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SelectedItems $selectedItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SelectedItems $selectedItems)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SelectedItems $selectedItems)
    {
        //
    }
}
