@extends('layouts.app')

@section('content')
    <!-- Breadcrumb-->
    <div class="bg-gray-200 text-sm">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 py-3">
                    <li class="breadcrumb-item"><a class="fw-light" href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active fw-light" aria-current="page">Menus </li>
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
                                <h3 class="h4 mb-0">Menus Table</h3>
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
                                        <th>Menu Name</th>
                                        <th>Icon Menu</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <th scope="row">{{ $count++ }}</th>
                                            <td>{{ $menu->menu_name ?? 'Tidak ada' }}</td>
                                            <td>{{ $menu->menu_icon ?? 'Tidak ada' }}</td>
                                            <td class="text-end">
                                                <a class="btn btn-outline-info btn-sm" title="Edit"
                                                    href="{{ route('menus.edit', ['menu' => $menu->menuHashId]) }}">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                                <button class="btn btn-outline-danger btn-sm" title="Delete"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $menu->menuHashId }}"
                                                    onclick="setDeleteForm();">
                                                    <i class="fa fa-trash-alt"></i>
                                                </button>

                                                <!-- Modal Delete -->
                                                <div class="modal fade" id="deleteModal{{ $menu->menuHashId }}"
                                                    tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="POST"
                                                                action="{{ route('menus.destroy', ['menu' => $menu->menuHashId]) }}">
                                                                @csrf
                                                                @method('DELETE')

                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel">Delete
                                                                        menu</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p class="text-center">Are you sure you want to delete
                                                                        this menu?</p>
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
                        <li class="page-item {{ $menus->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $menus->previousPageUrl() }}" tabindex="-1"
                                aria-disabled="true">Prev</a>
                        </li>

                        {{-- Halaman-halaman --}}
                        @for ($i = 1; $i <= $menus->lastPage(); $i++)
                            <li class="page-item {{ $menus->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $menus->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        {{-- Tombol Next --}}
                        <li class="page-item {{ $menus->currentPage() == $menus->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $menus->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>



            <div class="modal fade" id="createModel" tabindex="-1" aria-labelledby="createModelLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('menus.store') }}" method="POST">
                            @csrf

                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Create menu</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="categoryName" class="col-form-label">Category Name</label>
                                        <input type="text" class="form-control" name="category_name"
                                            placeholder="Enter category name..." id="categoryName">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="menuName" class="col-form-label">Menu Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="menu_name"
                                            placeholder="Enter menu name..." id="menuName">
                                    </div>
                                </div>
                                {{-- <div class="mb-3">
                                    <div class="form-group">
                                        <label for="menu" class="col-form-label">Menu Category <span
                                                class="text-danger">*</span></label>
                                        <div class="select2-container" id="selectContainer">
                                            <select class="form-select select2" id="menuType">
                                                <option value="category">Menu Category</option>
                                                <option value="page">Menu Page</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="menuIcon" class="col-form-label">Icon Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="menu_icon"
                                            placeholder="Example: portfolio-grid-1" id="menuIcon">
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
    {{-- <script>
        $(document).ready(function() {
            getMenuNameValue();
            getRouteName();
        });

        function getMenuNameValue() {
            var menuName = $('#menuName').val();

            if (menuName === '') {
                $('#menuType').prop('disabled', true);
                $('#categoryName').prop('disabled', true);
                $('#iconName').prop('disabled', true);
                $('#routeName').prop('disabled', true);
            } else {
                $('#menuType').prop('disabled', false);
                $('#categoryName').prop('disabled', false);
                $('#iconName').prop('disabled', false);
                $('#routeName').prop('disabled', false);
            }
        }

        function getRouteName() {
            var menuType = $('#menuType').val();

            if (menuType === 'category') {
                $('#routeName').val('');
                $('#routeName').prop('disabled', true);
            } else {
                $('#routeName').prop('disabled', false);
                $('#categoryName').prop('disabled', true);

                // Mengambil nilai dari menuName
                let menuNameValue = $('#menuName').val();

                // Pastikan nilai tidak kosong atau undefined sebelum mengakses metode toLowerCase
                if (menuNameValue) {
                    // Mengubah nilai ke huruf kecil semua dan menggantikan spasi dengan tanda hubung
                    let routeNameValue = menuNameValue.toLowerCase().replace(/\s+/g, '-');

                    // Menetapkan nilai ini ke routeName
                    $('#routeName').val(routeNameValue);
                }
            }
        }
    </script> --}}
@endsection
