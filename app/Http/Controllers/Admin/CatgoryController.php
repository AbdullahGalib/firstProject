<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CatgoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();

        return response()->json(['categories' => $categories], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'status'    => 'required'
        ]);

        $category = new Category();

        $category->name = $request->name;
        $category->slug = $request->name;
        $category->status = $request->status;

        $category->save();
    }

    public function destroy($id)
    {
        Category::find($id)->delete();
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return response()->json(['category' => $category], 200);
    }
    public function update(Request $request)
    {
        $request->validate([
            'name'      => 'required|unique:categories',
            'status'    => 'required'
        ]);
        $category = Category::find($request->id);


        $category->name = $request->name;
        $category->slug = $request->name;
        $category->status = $request->status;

        $category->save();
    }

    public function categoryItems(Request $request)
    {
        $sl = 0;
        foreach ($request->data as $id) {
            Category::find($id)->delete();
            $sl++;
        };
        $success = $sl > 0;
        return response()->json(['success' => $success, 'total' => $sl], 200);
    }

    public function changecategoryItems(Request $request)
    {
        $sl = 0;
        foreach ($request->data as $id) {
            $category = Category::find($id);
            $category->status = $request->status;
            $category->save();
            $sl++;
        };
        $success = $sl > 0;
        return response()->json(['success' => $success, 'total' => $sl], 200);
    }

    public function getActiveCcategoreis()
    {
        $categories = Category::where('status', 1)->get();
        return response()->json(['categories' => $categories], 200);
    }
}
