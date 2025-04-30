        <style>
            .css-vubbuv {
    user-select: none;
    width: 1em;
    height: 1em;
    display: inline-block;
    fill: currentcolor;
    flex-shrink: 0;
    font-size: 1.5rem;
    transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1);
}
        </style>
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <div class="d-flex sidebar-profile">
                        <div class="sidebar-profile-image">
                            <img src=" {{ $loggedInUser && $loggedInUser->profile_picture ? asset('storage/profile-picture/' . $loggedInUser->profile_picture) : asset('assets/images/user-icon.png') }}"
                                alt="image">
                            <span class="sidebar-status-indicator"></span>
                        </div>
                        <div class="sidebar-profile-name">
                            <p class="sidebar-name">
                                {{ $loggedInUser->first_name }}
                            </p>
                            <p class="sidebar-designation">
                                Welcome
                            </p>
                        </div>
                    </div>
                </li>

                <li class="nav-item {{ request()->route()->named('admin.index') ? 'active-nav' : '' }} ">
                    <a class="nav-link" href="{{ route('admin.index') }}">
                        <i class="fa fa-desktop menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.menus.index') }}">
                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="RestaurantMenuIcon"><path d="m8.1 13.34 2.83-2.83L3.91 3.5c-1.56 1.56-1.56 4.09 0 5.66l4.19 4.18zm6.78-1.81c1.53.71 3.68.21 5.27-1.38 1.91-1.91 2.28-4.65.81-6.12-1.46-1.46-4.2-1.1-6.12.81-1.59 1.59-2.09 3.74-1.38 5.27L3.7 19.87l1.41 1.41L12 14.41l6.88 6.88 1.41-1.41L13.41 13l1.47-1.47z"></path></svg>
                        <span class="ml-3 menu-title"> Menu </span> 
                    </a> 
                </li>


                <li class="nav-item {{ Request::is('admin/order*') ? 'active-nav' : '' }}">
                    <a class="nav-link" href="{{ route('admin.orders.index') }}">
                        <i class="fa fa-file menu-icon"></i>
                        <span class="menu-title">Orders</span>
                    </a>
                </li>
                <li class="nav-item d-none {{ request()->route()->named('admin.table-bookings') ? 'active-nav' : '' }}">
                    <a class="nav-link" href="{{ route('admin.table-bookings') }}">
                        <i class="fa fa-folder-open menu-icon"></i>
                        <span class="menu-title">Manage Bookings</span>
                    </a>
                </li>
                {{-- @if ($loggedInUser->role == 'global_admin') --}}

                {{-- <li class="nav-item {{ request()->route()->named('admin.users.index') ? 'active-nav' : '' }}">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="fa fa-users menu-icon"></i>
                    <span class="menu-title">Manage Admins</span>
                </a>
                </li> --}}

          
                {{-- @endif    --}}
                <li class="nav-item {{ Request::is('admin/blog*') ? 'active-nav' : '' }}">
                    <a class="nav-link" href="{{ route('admin.blog.index') }}">
                        <i class="far fa-newspaper menu-icon"></i>
                        <span class="menu-title">Manage Blog</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->route()->named('admin.pos.index') ? 'active-nav' : '' }}">
                    <a class="nav-link" href="{{ route('admin.pos.index') }}">
                        <i class="fa fa-shopping-cart menu-icon"></i>
                        <span class="menu-title">Point of Sale</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->route()->named('admin.view.myprofile') ? 'active-nav' : '' }}">
                    <a class="nav-link" href="{{ route('admin.view.myprofile') }}">
                        <i class="fa fa-user menu-icon"></i>
                        <span class="menu-title">My Profile</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->route()->named('change.password.form') ? 'active-nav' : '' }}">
                    <a class="nav-link" href="{{ route('change.password.form') }}">
                        <i class="fa fa-lock menu-icon"></i>
                        <span class="menu-title">Change Password</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fa fa-globe menu-icon"></i>
                        <span class="menu-title">Main Website</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="fa fa-power-off menu-icon"></i>
                        <span class="menu-title">Logout</span>
                    </a>
                </li>
            </ul>

        </nav>