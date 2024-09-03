<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all(); // Fetch all categories
        return view('listcategories')->with('all_category',$categories);
    }

     // Show posts by category
     public function show($id)
     {
         $category = Category::with('posts.user', 'posts.mediaFiles')->findOrFail($id);
         return view('categoriesshow', compact('category'));
     }

    public function edit($id)
    {
        $category = Category::findOrFail($id); // Find the category by ID or fail
        return view('categoriesedit', compact('category'));
    }
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->validate([
            'name' => 'required|string|max:255',
        ]));

        return redirect()->route('listcategories')->with('success', 'Category updated successfully.');
    }
    public function create()
    {
        return view('categories');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->back()->with('success', 'Category added successfully!');
    }
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('listcategories')->with('success', 'Category deleted successfully.');
    }
}
