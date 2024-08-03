<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'Admin') {
            $categoryQuery = Category::query();

            if ($request->has('search')) {
                $search = $request->input('search');
                $categoryQuery->where('category_name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            }

            $categories = $categoryQuery->paginate(10);
            return view('categories.index', compact('categories'));
        } elseif (Auth::check()) {
            return redirect()->route('error404');
        } else {
            return redirect()->route('error404');
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

        if ($request->hasFile('category_img')) {
            $avatarPath = $request->file('category_img')->store('products', 'public');
            $category->category_img = $avatarPath;
        }

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

        if ($request->hasFile('category_img')) {
            $avatarPath = $request->file('category_img')->store('products', 'public');
            $category->category_img = $avatarPath;
        }

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 
        $category = Category::findOrFail($id);

        if (Storage::disk('public')->exists($category->category_img)) {
            if (!Storage::disk('public')->delete($category->category_img)) {

                return redirect()->back()->with('error', 'Image not deleted!');
            }
        }

        if (!$category->delete()) {

            return redirect()->route('categories.index')->with('error', 'Deletion Failed!');
        }

        return redirect()->route('categories.index')->with('success', 'Deleted successfully');
    }
}
