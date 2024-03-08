<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function __construct()
    // {
    //     $this->middleware(['role_or_permission:admin|roles-index|roles-edit|roles-update'])->only(['index', 'edit', 'update']);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $search = $req->search;

        $roles = Role::when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->paginate(10);

        return view('management.roles.index', ['roles' => $roles]);
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
    public function store(Request $request, Role $role)
    {
        $user = Auth::user(); // Mengambil objek pengguna yang saat ini masuk
        $isAdmin = $user->hasRole('admin'); // Memeriksa apakah pengguna memiliki peran 'admin'

        if ($isAdmin) {
            Toastr::error('You are not allowed to create roles', 'Failed');
            return back();
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:roles,name'],
        ]);

        if ($validator->fails()) {
            Toastr::error($validator->errors()->first(), 'Failed');
            return back();
        }

        try {
            $role->create($request->all());

            Toastr::success('Role created successfully', 'Congratulations');

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
    public function edit(Role $role)
    {
        return view('management.roles.edit', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'unique:roles,name'],
        ]);

        try {
            $role->update($request->all());

            Toastr::success('Role updated successfully', 'Congratulations');

            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed!');

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $user = Auth::user(); // Mengambil objek pengguna yang saat ini masuk
        $isAdmin = $user->hasRole('admin'); // Memeriksa apakah pengguna memiliki peran 'admin'

        if ($isAdmin) {
            Toastr::error('You are not allowed to create roles', 'Failed');
            return back();
        }

        try {
            $role->delete();

            Toastr::success('Role deleted successfully', 'Congratulations');

            return back();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed!');

            return back();
        }
    }
}
