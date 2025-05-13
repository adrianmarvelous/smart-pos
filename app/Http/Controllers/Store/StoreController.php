<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\UserHasRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Rules\SafeInput;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::where('user_id',session('user_id'))->get();
        return view('dashboard.store.index',compact('stores'));
    }
    public function create()
    {
        return view('dashboard.store.create');
    }
    public function create_store(Request $request)
    {
        $validated = $request->validate([
            'store_name' => ['required', 'string', new SafeInput],
            'address' => ['required', 'string', new SafeInput],
        ]);
        $store_name = $validated['store_name'];
        $address = $validated['address'];
        $user_id = session('user_id');
        
        // Begin the transaction
        DB::beginTransaction();

        try {
            // Insert the store using the store model
            $store = new store();
            $store->store_name = $validated['store_name'];
            $store->address = $validated['address'];
            $store->user_id = $user_id;
            $store->save(); // This will insert the store

            // Get the ID of the newly created store
            $storeId = $store->id;

            $hasRole = new UserHasRole();
            $hasRole->user_id = $user_id;
            $hasRole->role_id = 2;
            $hasRole->store_id = $storeId; // Set the store_id from the first table's ID
            $hasRole->save(); // This will insert the store

            // If everything is fine, commit the transaction
            DB::commit();

            // Redirect or return success response
            return redirect()->route('store.index')->with('success', 'Store created successfully!');
        } catch (\Exception $e) {
            // In case of error, roll back the transaction
            DB::rollBack();

            // Handle the error (e.g., log it or show a user-friendly message)
            return redirect()->back()->with('error',   'There was an error creating the store.');
        }
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'string', new SafeInput],
            'store_name' => ['required', 'string', new SafeInput],
            'address' => ['required', 'string', new SafeInput],
        ]);
        
        DB::beginTransaction();
        try {
            $store = Store::findOrFail($validated['id']);
            $store->store_name = $request->store_name;
            $store->address = $request->address;
            $store->save();

            DB::commit();

            return redirect()->route('store.index')->with('success', 'Store updated successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update store');
        }
    }
    public function change_store($id)
    {
        session(['store_id' => $id]);
        return redirect()->route('dashboard');
    }
    public function delete(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'string', new SafeInput]
        ]);
        $store = Store::find($validated['id']);
        $store->delete();

        return redirect()->route('store.index')->with('success', 'Store deleted successfully!');
    }
}
