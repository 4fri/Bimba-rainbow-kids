<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $search = $req->search;

        $menus = Menu::with(['menuParent'])
            ->when($search, function ($query, $search) {
                $query->where('menu_name', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        return view('management.menus.index', compact('menus'));
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
    public function store(Request $request, Menu $menu)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => ['nullable', 'unique:menus,category_name'],
            'menu_name' => ['required', 'unique:menus,menu_name'],
            'icon_name' => ['required'],
            'route_name' => ['nullable', 'unique:menus,route_name'],
        ]);

        if ($validator->fails()) {
            Toastr::error($validator->errors()->first(), 'Failed');
            return back();
        }

        try {
            $menu->create($request->all());

            Toastr::success('Menu created successfully', 'Congratulations');

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
