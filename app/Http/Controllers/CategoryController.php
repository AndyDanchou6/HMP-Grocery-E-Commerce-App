<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        //
        return view('categories.index');
    }

    public function getAllData()
    {
        $category = Category::orderBy('created_at', 'asc')->get();

        return response()->json($category);
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
        $category = new Category();

        $category->category_name = $request->input('category_name');
        $category->description = $request->input('description');

        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Added Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $Category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $Category)
    {
        //
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
        $category = Category::findOrFail($id);

        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully'
        ]);
    }

    public function getData(string $id)
    {
        $user = Category::findOrFail($id);

        return response()->json($user);
    }
}
