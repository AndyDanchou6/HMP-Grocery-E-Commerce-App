<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        if (empty(Auth::user()->role)) {
            return redirect()->route('error404');
        } else {
            $categories = Category::all(); // or retrieve data as needed
            return view('categories.index', compact('categories'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $category = new Category();

        $category->category_name = $request->input('category_name');
        $category->description = $request->input('description');

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Added successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 
        $category = Category::findOrFail($id);

        $category->category_name = $request->input('category_name');
        $category->description = $request->input('description');

        $category->save();

        return redirect()->route('categories.index')->with('update', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->route('categories.index')->with('error', 'Deleted successfully');
    }
}
