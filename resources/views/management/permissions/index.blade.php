@extends('layouts.app')

@section('content')
    <!-- Breadcrumb-->
    <div class="bg-gray-200 text-sm">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 py-3">
                    <li class="breadcrumb-item"><a class="fw-light" href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active fw-light" aria-current="page">Permissions </li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="tables py-4">
        <div class="container-fluid">
            <div class="row mb-4 justify-content-end">
                <div class="col-md-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModel"
                        data-bs-whatever="@mdo">Create</button>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col">
                                <h3 class="h4 mb-0">Permissions Table</h3>
                            </div>
                            <div class="col-md-3">
                                <form>
                                    <input type="search" class="form-control form-control-sm" name="search"
                                        placeholder="Search data...">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-sm mb-0 table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Permission Name</th>
                                        <th>Guard Name</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <th scope="row">{{ $count++ }}</th>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->guard_name }}</td>
                                            <td class="text-end">
                                                <a class="btn btn-outline-info btn-sm" title="Edit"
                                                    href="{{ route('permissions.edit', $permission->id) }}">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                                <button class="btn btn-outline-danger btn-sm" title="Delete"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $permission->id }}"
                                                    onclick="setDeleteForm();">
                                                    <i class="fa fa-trash-alt"></i>
                                                </button>

                                                <!-- Modal Delete -->
                                                <div class="modal fade" id="deleteModal{{ $permission->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="POST"
                                                                action="{{ route('permissions.destroy', $permission->id) }}">
                                                                @csrf
                                                                @method('DELETE')

                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel">Delete
                                                                        permission</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p class="text-center">Are you sure you want to delete
                                                                        this permission?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Delete</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        {{-- Tombol Previous --}}
                        <li class="page-item {{ $permissions->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $permissions->previousPageUrl() }}" tabindex="-1"
                                aria-disabled="true">Prev</a>
                        </li>

                        {{-- Halaman-halaman --}}
                        @for ($i = 1; $i <= $permissions->lastPage(); $i++)
                            <li class="page-item {{ $permissions->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $permissions->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        {{-- Tombol Next --}}
                        <li
                            class="page-item {{ $permissions->currentPage() == $permissions->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $permissions->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>



            <div class="modal fade" id="createModel" tabindex="-1" aria-labelledby="createModelLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('permissions.store') }}" method="POST">
                            @csrf

                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Create permission</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="permissionName" class="col-form-label">Permission Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Enter permission name..." id="permissionName">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="assignRole" class="col-form-label">Assign Role <span
                                                class="text-danger">*</span></label>
                                        <div class="select2-container" id="selectContainer">
                                            <select class="form-select select2" name="roles[]" multiple="multiple">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
