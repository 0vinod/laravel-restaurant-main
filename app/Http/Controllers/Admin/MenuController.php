<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Category;
use App\Http\Requests\MenuRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;
use App\Http\Controllers\Traits\ImageHandlerTrait;
use App\Http\Controllers\Traits\AdminViewSharedDataTrait;
use App\Imports\MenuImport;
use App\Models\MenuType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class MenuController extends Controller
{
    use AdminViewSharedDataTrait;
    use ImageHandlerTrait;


    public function __construct()
    {
        $this->shareAdminViewData();
    }

    public function menuDashboard()
    {
        $menuType = MenuType::all();
        return view('admin.menu_dashboard', compact('menuType'));
    }

    public function index(MenuType $menuType)
    {
        $categories = Category::with('menus')->get();
        return view('admin.menus', compact('categories', 'menuType'));
    }

    public function store(MenuRequest $request, MenuType $menuType)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $this->handleImageUpload($validated['image'], "menus");
        }
        $validated['menu_type_id'] = $menuType->id;
        Menu::create($validated);

        return back()->with('success', 'Menu created successfully!');
    }


    public function update(MenuRequest $request, MenuType $menuType, $id)
    {
        $menu = Menu::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image
            $imagePath = storage_path('app/public/' . ltrim($menu->image, '/'));
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Handle new image upload
            $validated['image'] = $this->handleImageUpload($validated['image'], "menus");
        }

        $menu->update($validated);

        return back()->with('success', 'Menu updated successfully!');
    }




    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $imagePath = storage_path('app/public/' . ltrim($menu->image, '/'));


        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file
        }


        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully!');
    }

    public function menusByCategory($id)
    {

        $category = Category::with('menus')->find($id);
        $categoryName = $category->name;
        $menus = $category?->menus ?? collect();

        return view('partials.menu_item', compact('categoryName', 'menus'))->render();
    }

    public function getMenuType($id)
    {
        try {
            $menuType = MenuType::findOrFail($id);
            return response()->json($menuType);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Menu type not found'], 404);
        }
    }

    // Store or update menu type using AJAX
    public function menuTypeStoreOrUpdate(Request $request)
    {
        try {
            $isUpdate = $request->filled('id');

            $rules = [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => $isUpdate ? 'nullable|image|max:2048' : 'required|image|max:2048'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            $menuType = $isUpdate ? MenuType::findOrFail($request->id) : new MenuType;

            if ($request->hasFile('image')) {
                // Remove old image if updating
                if ($isUpdate && !empty($menuType->image)) {
                    $oldImagePath = storage_path('app/public/' . ltrim($menuType->image, '/'));
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Handle new image upload
                $data['image'] = $this->handleImageUpload($request->file('image'), "menus");
            }

            // Save the menu type
            $menuType->fill($data)->save();

            $message = $isUpdate ? 'Menu updated successfully!' : 'Menu added successfully!';

            return response()->json([
                'success' => true,
                'message' => $message,
                'menu' => $menuType
            ]);
        } catch (\Exception $e) {
            logger('Menu type save error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error saving menu type: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete menu type using AJAX
    public function menuTypeDelete($id)
    {
        try {
            $menuType = MenuType::findOrFail($id);

            // Delete the image file if it exists
            if (!empty($menuType->image)) {
                $imagePath = storage_path('app/public/' . ltrim($menuType->image, '/'));
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $menuType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Menu deleted successfully!'
            ]);
        } catch (\Exception $e) {
            logger('Menu type delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting menu type'
            ], 500);
        }
    }

    public function menuImport()
    {
        return view('admin.import_menu.menu_import');
    }
    public function downloadSample()
    {
        $filePath = public_path('templates/menu_template.xlsx');
        return response()->download($filePath, 'menu_template.xlsx');
    }

    public function uploadView()
    {
        return view('admin.import_menu.import_menu_upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'menu_file' => 'required|file|mimes:xlsx',
        ]);

        $file = $request->file('menu_file');
        $filename = 'menu_' . time() . '.' . $file->getClientOriginalExtension();
        $filepath = $file->storeAs('uploads/menus', $filename, 'public');

        // Use full path for Laravel Excel to locate the file
        Excel::import(new MenuImport(), storage_path("app/public/{$filepath}"));

        return redirect()->route('import.menu.review')->with('success', 'File uploaded successfully!');
    }

    public function review()
    {
        $menu =  Menu::with('category')->where('is_imported', 1)->get();

        return view('admin.import_menu.menu_review', compact('menu'));
    }
    public function approveImport()
    {
        Menu::where('is_imported', 1)->update(['import_approve' => 1]);

        return redirect()->route('admin.menus.dashboard');
    }
}
