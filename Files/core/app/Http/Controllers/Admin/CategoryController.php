<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function index() {
        $pageTitle  = 'Categories';
        $categories = Category::searchable(['name'])->withCount('services')->orderBy('name')->paginate(getPaginate());
        return view('admin.categories.index', compact('pageTitle', 'categories'));
    }

    public function store(Request $request) {
        $id = $request->id ?? 0;

        $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
        ]);

        if ($id) {
            $category = Category::findOrFail($id);
            $message  = "Category updated successfully";
        } else {
            $category = new Category();
            $message  = "Category added successfully";
        }
        $category->name = $request->name;
        $category->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function status($id) {
        return Category::changeStatus($id);
    }
}
