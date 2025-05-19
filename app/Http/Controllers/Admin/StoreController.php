<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\AdminViewSharedDataTrait;
use App\Http\Controllers\Traits\ImageHandlerTrait;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\StoreOpeningHour;
use App\Models\StoreTable;
use App\Models\StoreUser;

class StoreController extends Controller
{
    use AdminViewSharedDataTrait;
    use ImageHandlerTrait;

    public function __construct()
    {
        $this->shareAdminViewData();
    }

    public function index()
    {
        $stores = Store::with(['storeOpeningHours', 'storeTables', 'storeUsers'])->get();


        return view('admin.store.index', compact('stores'));
    }

    public function storeCreateOrUpdate(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);


        $store = isset($request->store_id) ? Store::findOrFail($request->store_id) : new Store();
        $store->name = $request->name;
        $store->address = $request->address;
        $store->phone = $request->phone;

        if ($request->hasFile('logo')) {
            $store->logo = $request->file('logo')->store('stores', 'public');
        }

        $store->save();

        // Fetch stores with related tables to show in UI
        $stores = Store::with('storeTables')->get();

        $html = view('admin.store.partials.multiple_table', compact('stores'))->render();

        return response()->json([
            'success' => true,
            'store' => $store,
            'tables' => $html
        ]);
    }


    public function editStore($id)
    {
        $store = Store::findOrFail($id);

        return response()->json([
            'success' => true,
            'store' => $store
        ]);
    }


    public function deleteStore(Request $request)
    {
        $request->validate(['id' => 'required|exists:stores,id']);
        Store::destroy($request->id);
        return response()->json(['success' => true]);
    }

    public function storeTableCreateOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'table_names' => 'required|array',
            'table_names.*' => 'required|string|max:255'
        ]);

        $records = [];
        foreach ($validated['table_names'] as $name) {
            $records[] = [
                'store_id' => $validated['store_id'],
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($request->table_id) {
            StoreTable::where('id', $request->table_id)->update($records[0]);

            return response()->json([
                'success' => true,
                'message' => 'Table successfully updated.',
            ]);
        } else {

            // Step 1: Delete all existing tables for the store
            StoreTable::where('store_id', $validated['store_id'])->delete();

            // Step 3: Insert all new tables
            StoreTable::insert($records);
        }


        $stores = Store::with('storeTables')->get();

        $html = view('admin.store.partials.multiple_table', compact('stores'))->render();

        return response()->json([
            'success' => true,
            'message' => 'All tables successfully Saved.',
            'tables' => $html
        ]);
    }

    public function storeTableDelete(Request $request)
    {
        $table = StoreTable::find($request->table_id);
        if ($table) {
            $table->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    public function storeOpeningHourCreateOrUpdate(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'days' => 'required|array'
        ]);

        foreach ($request->days as $day) {
            StoreOpeningHour::updateOrCreate(
                [
                    'store_id' => $request->store_id,
                    'day' => $day['day']
                ],
                [
                    'open_time' => $day['open_time'],
                    'close_time' => $day['close_time'],
                    'is_open' => $day['is_open'] ?? true
                ]
            );
        }

        return response()->json(['success' => true]);
    }

    public function storeOpeningHourDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:store_opening_hours,id'
        ]);

        StoreOpeningHour::destroy($request->id);
        return response()->json(['success' => true]);
    }
}
