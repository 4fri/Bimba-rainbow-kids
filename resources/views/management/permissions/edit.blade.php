@extends('layouts.app')

@section('content')
    <!-- Breadcrumb-->
    <div class="bg-gray-200 text-sm">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 py-3">
                    <li class="breadcrumb-item"><a class="fw-light" href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active fw-light" aria-current="page">Edit Permissions </li>
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
                        Edit Permission
                    </div>
                    <div class="card-body">
                        <!-- Form untuk mengupdate data -->
                        <form action="{{ route('permissions.update', $hashId) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Form Group untuk Nama -->
                            <div class="mb-3">
                                <label for="permissionName" class="form-label">Permission Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" placeholder="Enter permission name..."
                                    value="{{ old('name', $permission->name) }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
