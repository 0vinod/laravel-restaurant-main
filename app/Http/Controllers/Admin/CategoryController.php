<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Traits\AdminViewSharedDataTrait;
use App\Models\Menu;
use App\Models\MenuType;

class CategoryController extends Controller
{
    use AdminViewSharedDataTrait;

    public function __construct()
    {
        $this->shareAdminViewData();
        
    }
    
   
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }

    public function store(CategoryRequest $request, MenuType $menuType)
    {
        Category::create([
            'name' => $request->name,
            'descrption' => $request->descrption,
            'menu_type_id' => $menuType->id,
            ]);
        return redirect()->back()->with('success', 'Category created successfully.');
    }
    

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update(['name' => $request->name]);
        return redirect()->back()->with('success', 'Category updated successfully.');
    }
    

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }


}
