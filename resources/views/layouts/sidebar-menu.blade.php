@php
    use App\Models\Menu;

    $menus = Menu::with('menuParent')->orderBy('id', 'ASC')->get();
@endphp

<!-- Side Navbar -->
<nav class="side-navbar">
    <div class="side-navbar-inner">
        <!-- Sidebar Header    -->
        <div class="sidebar-header d-flex align-items-center justify-content-center p-3 mb-3">
            <!-- User Info-->
            <div class="sidenav-header-inner text-center"><img class="img-fluid rounded-circle avatar mb-3"
                    src="{{ asset('template') }}/img/avatar-7.jpg" alt="person">
                <h2 class="h5 text-white text-uppercase mb-0">{{ Auth::user()->name ?? '' }}</h2>
                <p class="text-sm mb-0 text-muted">{{ Auth::user()->getRoleName() ?? '' }}</p>
            </div>
            <!-- Small Brand information, appears on minimized sidebar-->
            <a class="brand-small text-center" href="{{ url('/') }}">
                <p class="h1 m-0">KIDS</p>
            </a>
        </div>

        <!-- Sidebar Navigation Menus-->
        @foreach ($menus as $menu)
            @if ($menu->category_name !== null)
                <span class="text-uppercase text-gray-500 text-sm fw-bold letter-spacing-0 mx-lg-2 heading">
                    {{ $menu->category_name }}
                </span>
            @endif

            @php
                $dropdownHref = '#menuSidebar' . $menu->id;
                $dropDownId = 'menuSidebar' . $menu->id;

                // Cek apakah menu aktif
                $isActive =
                    $menu->route_name !== null &&
                    Route::has($menu->route_name) &&
                    Route::currentRouteName() == $menu->route_name;
                // Cek apakah salah satu submenu aktif
                $isDropdownActive =
                    $menu->route_name === null &&
                    collect($menu->menuParent)->contains(function ($parent) {
                        return Route::has($parent->route_name) && Route::currentRouteName() == $parent->route_name;
                    });
            @endphp

            <ul class="list-unstyled">
                <li class="sidebar-item {{ $isActive || $isDropdownActive ? 'active' : '' }}">
                    <a class="sidebar-link"
                        href="{{ $menu->route_name !== null && Route::has($menu->route_name) ? route($menu->route_name) : $dropdownHref }}"
                        data-bs-toggle="{{ $menu->route_name === null ? 'collapse' : '' }}"
                        aria-expanded="{{ $isDropdownActive ? 'true' : 'false' }}"
                        style="{{ $isActive ? 'color: orange;' : '' }}">
                        <svg class="svg-icon svg-icon-sm svg-icon-heavy me-2">
                            <use xlink:href="#{{ $menu->menu_icon }}"> </use>
                        </svg>{{ $menu->menu_name }}
                    </a>

                    @if ($menu->route_name === null)
                        <ul class="collapse list-unstyled {{ $isDropdownActive ? 'show' : '' }}"
                            id="{{ $dropDownId }}">
                            @foreach ($menu->menuParent as $parent)
                                <li>
                                    <a class="sidebar-link"
                                        href="{{ Route::has($parent->route_name) ? route($parent->route_name) : '#' }}"
                                        style="{{ Route::currentRouteName() == $parent->route_name ? 'color: orange;' : '' }}">
                                        {{ $parent->menu_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            </ul>
        @endforeach

        {{-- <span class="text-uppercase text-gray-500 text-sm fw-bold letter-spacing-0 mx-lg-2 heading">
            Second menu
        </span> --}}

    </div>
</nav>
