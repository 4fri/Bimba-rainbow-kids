@extends('layouts.app')

@section('content')
    <!-- Breadcrumb-->
    <div class="bg-gray-200 text-sm">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 py-3">
                    <li class="breadcrumb-item"><a class="fw-light" href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active fw-light" aria-current="page">Edit Menus </li>
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
                        Edit menu
                    </div>
                    <div class="card-body">
                        <!-- Form untuk mengupdate data -->
                        <form action="{{ route('menus.update', $hashId) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Form Group untuk Nama -->
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="category_name" placeholder="Enter Category name..."
                                    value="{{ old('category_name', $menu->category_name) }}">
                                @error('category_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="menuName" class="form-label">Menu Name <span class="text-danger"></span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="menu_name" placeholder="Enter menu name..."
                                    value="{{ old('menu_name', $menu->menu_name) }}">
                                @error('menu_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="menuIcon" class="form-label">Menu Icon <span class="text-danger"></span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="menu_icon" placeholder="Example: portfolio-grid-1"
                                    value="{{ old('menu_icon', $menu->menu_icon) }}">
                                @error('menu_icon')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
