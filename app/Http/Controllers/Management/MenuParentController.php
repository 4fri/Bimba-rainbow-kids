<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuParent;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class MenuParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parents = MenuParent::with(['menus', 'child'])
            ->paginate(10);

        $menus = Menu::get();

        $select_parents = MenuParent::get();

        return view('management.menu-parents.index', compact('parents', 'menus', 'select_parents'));
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
    public function store(Request $request, MenuParent $menuParent)
    {
        $request->validate([
            "menu" => ['required'],
            "route" => ['required'],
            "parent" => ['required'],
            'child' => ['nullable'],
        ]);

        try {
            $menuParent->create([
                'menu_id' => $request->menu,
                'route_name' => $request->route,
                'menu_name' => $request->parent,
                'child_id' => $request->child,
            ]);

            Toastr::success('Menu Parent Created', 'Success');

            return back();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Error');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
