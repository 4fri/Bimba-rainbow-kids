<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;

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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => ['nullable', 'unique:menus,category_name'],
            'menu_name' => ['required', 'unique:menus,menu_name'],
            'menu_icon' => ['required'],
        ]);

        if ($validator->fails()) {
            Toastr::error($validator->errors()->first(), 'Failed');
            return back();
        }

        try {
            Menu::create($request->all());

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
    public function edit(string $hashId)
    {
        $decoded = Hashids::decode($hashId);
        $id = $decoded ? $decoded[0] : null;

        $menu = Menu::findOrFail($id);
        return view('management.menus.edit', compact('menu', 'hashId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $hashId)
    {
        $decoded = Hashids::decode($hashId);
        $id = $decoded ? $decoded[0] : null;

        $validator = Validator::make($request->all(), [
            'category_name' => ['nullable'],
            'menu_name' => ['required'],
            'menu_icon' => ['required'],
        ]);

        if ($validator->fails()) {
            Toastr::error($validator->errors()->first(), 'Failed');
            return back();
        }

        try {
            $data = $request->only(['category_name', 'menu_name', 'menu_icon']);

            Menu::where('id', $id)->update($data);

            Toastr::success('Menu updated successfully', 'Congratulations');

            return redirect()->route('menus.index');
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed!');

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
            Menu::where('id', $id)->delete();
            Toastr::success('Menu deleted successfully', 'Congratulations');
            return back();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed!');
            return back();
        }
    }
}
