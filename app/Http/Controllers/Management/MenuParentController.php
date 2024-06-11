<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuParent;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;

class MenuParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $parents = MenuParent::with(['menus', 'child'])
            ->when($search, function ($query, $search) {
                $query->where('menu_name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('menus', function ($query) use ($search) {
                $query->where('menu_name', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        $menus = Menu::get();

        $select_childs = MenuParent::get();

        return view('management.menu-parents.index', compact('parents', 'menus', 'select_childs'));
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "menu" => ['required'],
            "route" => ['required', 'unique:menu_parents,route_name'],
            "parent" => ['required'],
            'child' => ['nullable'],
        ]);

        if ($validator->fails()) {
            Toastr::error($validator->errors()->first(), 'Failed');
            return back();
        }

        try {
            MenuParent::create([
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
    public function edit(string $hashId)
    {
        $decoded = Hashids::decode($hashId);
        $id = $decoded ? $decoded[0] : null;

        $parent = MenuParent::findOrFail($id);

        $menus = Menu::get();

        $select_childs = MenuParent::get();

        return view('management.menu-parents.edit', compact('parent', 'hashId', 'menus', 'select_childs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $hashId)
    {
        $decoded = Hashids::decode($hashId);
        $id = $decoded ? $decoded[0] : null;

        $validator = Validator::make($request->all(), [
            "menu" => ['required'],
            "route" => ['required'],
            "parent" => ['required'],
            'child' => ['nullable'],
        ]);

        if ($validator->fails()) {
            Toastr::error($validator->errors()->first(), 'Failed');
            return back();
        }

        try {
            MenuParent::where('id', $id)->update([
                'menu_id' => $request->menu,
                'menu_name' => $request->parent,
                'route_name' => $request->route,
                'child_id' => $request->child,
            ]);

            Toastr::success('Menu Parent Updated', 'Success');

            return redirect()->route('menu-parents.index');
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Error');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $hashId)
    {
        $decoded = Hashids::decode($hashId);
        $id = $decoded ? $decoded[0] : null;

        try {
            MenuParent::destroy($id);

            Toastr::success('Menu Parent Deleted', 'Success');

            return back();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Error');
            return back();
        }
    }
}
