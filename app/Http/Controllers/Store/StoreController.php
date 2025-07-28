<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use App\Models\UserHasRole;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
    public function update_unique_code($id)
    {        
        DB::beginTransaction();
        try {
            do {
                $uniqueCode = Str::upper(Str::random(8));
            } while (Store::where('unique_code', $uniqueCode)->exists());

            $store = Store::findOrFail($id);
            $store->unique_code = $uniqueCode;
            $store->save();

            DB::commit();

            return redirect()->route('store.index')->with('success', 'Unique code update successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update store');
        }
    }
    public function join()
    {
        return view('dashboard.join_store');
    }
    public function apply(Request $request)
    {
        $validated = $request->validate([
            'unique_code' => ['required', 'string', new SafeInput],
        ]);

        $uniqueCode = $validated['unique_code'];
        $store = Store::where('unique_code',$uniqueCode)->first();
        DB::beginTransaction();
        try {

            $role = new UserHasRole();
            $role->user_id = session('user_id');
            $role->role_id = 3;
            $role->store_id = $store->id;
            $role->save();

            DB::commit();
            
            session(['store_id' => $store->id]);

            return redirect()->route('dashboard')->with('success', 'Join store successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update store');
        }
    }
    public function list_crew()
    {
        $user = UserHasRole::with('hasUser')
                            ->with('hasRole')
                            ->where('store_id',session('store_id'))
                            ->where('user_id','!=',session('user_id'))
                            ->get();
        $roles = Role::where('id','!=',1)->get();

        return view('dashboard.store.list_crew',compact('user','roles'));
    }
    public function update_role(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'numeric','max:255', new SafeInput],
            'user_id' => ['required', 'numeric','max:255', new SafeInput],
            'role' => ['required', 'numeric','max:255', new SafeInput],
        ]);
        $id = $validated['id'];
        $user_id = $validated['user_id'];
        $role = $validated['role'];

        DB::beginTransaction();
        try {

            $user_has_role = UserHasRole::findOrFail($id);
            $user_has_role->role_id = $role;
            $user_has_role->save();

            DB::commit();

            return redirect()->route('store.list_crew')->with('success', 'Role update successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update store');
        }
    }
}
