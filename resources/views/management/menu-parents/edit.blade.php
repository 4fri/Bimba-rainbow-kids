@extends('layouts.app')

@section('content')
    <!-- Breadcrumb-->
    <div class="bg-gray-200 text-sm">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 py-3">
                    <li class="breadcrumb-item"><a class="fw-light" href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active fw-light" aria-current="page">Edit Parents </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        Edit Parent
                    </div>
                    <div class="card-body">
                        <!-- Form untuk mengupdate data -->
                        <form action="{{ route('menu-parents.update', $hashId) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Form Group untuk Nama -->
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="menu" class="col-form-label">Menu <span
                                            class="text-danger">*</span></label>
                                    <div class="select2-container" id="selectContainer">
                                        <select class="form-select select2" name="menu">
                                            <option value="" hidden>Select menu...</option>
                                            @foreach ($menus as $menu)
                                                <option value="{{ $menu->id }}"
                                                    {{ old('menu', isset($parent->menu_id) ? $parent->menu_id : '') == $menu->id ? 'selected' : '' }}>
                                                    {{ $menu->menu_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="parentName" class="col-form-label">Parent Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="parent"
                                        value="{{ old('parent', $parent->menu_name) }}" placeholder="Enter Parent name..."
                                        id="parentName">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="routeName" class="col-form-label">Route Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="route"
                                        value="{{ old('parent', $parent->route_name) }}" placeholder="Enter route name..."
                                        id="routeName">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="child" class="col-form-label">Child Menu </label>
                                    <div class="select2-container" id="selectContainer">
                                        <select class="form-select select2" name="child">
                                            <option value="" hidden>Select menu...</option>
                                            @foreach ($select_childs as $child)
                                                <option value="{{ $child->id }}"
                                                    {{ old('child', isset($parent->child_id) ? $parent->child_id : '') == $child->id ? 'selected' : '' }}>
                                                    {{ $child->menu_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
