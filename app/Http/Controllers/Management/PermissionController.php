<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $search = $req->search;

        $permissions = Permission::with('roles')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        $roles = Role::all();

        $data = [
            'permissions' => $permissions,
            'roles' => $roles
        ];

        return view('management.permissions.index', $data);
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
    public function store(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:permissions,name'],
            'roles' => ['required', 'array', 'min:1']
        ]);

        if ($validator->fails()) {
            Toastr::error($validator->errors()->first(), 'Failed');
            return back();
        }

        try {
            $permission->create([
                'name' => $request->name
            ]);

            foreach ($request->input('roles') as $roleName) {
                $role = Role::where('name', $roleName)->firstOrFail(); // Mengambil role dari database berdasarkan namanya
                $role->givePermissionTo($request->name); // Memberikan permission ke role
            }

            Toastr::success('Permission created successfully', 'Congratulations');

            return back();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed!');

            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('management.permissions.edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => ['required', 'unique:permissions,name'],
        ]);

        try {
            $permission->update($request->all());

            Toastr::success('Permission updated successfully', 'Congratulations');

            return redirect()->route('permissions.index');
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed!');

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();

            Toastr::success('Permission deleted successfully', 'Congratulations');

            return back();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed!');

            return back();
        }
    }
}
