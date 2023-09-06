<!-- Topbar Start -->
<div class="navbar-custom">
    <ul class="list-unstyled topbar-menu float-end mb-0">

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#"
               role="button" aria-haspopup="false"
               aria-expanded="false">
                                    <span class="account-user-avatar">
                                        <img src="{{asset('assets/images/users/avatar-1.jpg')}}" alt="user-image"
                                             class="rounded-circle">
                                    </span>
                <span>

{{--                    @dd(Auth::user())--}}

                                        <span class="account-user-name">{{  Auth::user()->name}}</span>
                    @if(Auth::user()->role===1)
                        <span class="account-position">
                            Admin
                        </span>
                    @endif
                    @if(Auth::user()->role===2)
                        <span class="account-position">
                            User
                        </span>
                    @endif
                    @if(Auth::user()->role===3)
                        <span class="account-position">
                            Service Provider
                        </span>
                    @endif

                                    </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                <!-- item-->
                <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome !</h6>
                </div>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-circle me-1"></i>
                    <span>My Profile</span>
                </a>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-edit me-1"></i>
                    <span>Settings</span>
                </a>

                <!-- item-->
                <a href="{{route('admin.logout')}}" class="dropdown-item notify-item">
                    <i class="mdi mdi-logout me-1"></i>
                    <span>Logout</span>
                </a>
            </div>
        </li>

    </ul>
    <button class="button-menu-mobile open-left">
        <i class="mdi mdi-menu"></i>
    </button>
    <div class="app-search dropdown d-none d-lg-block">
        <form>
            <div class="input-group">
                <input type="text" class="form-control dropdown-toggle" placeholder="Search..." id="top-search">
                <span class="mdi mdi-magnify search-icon"></span>
                <button class="input-group-text btn-primary" type="submit">Search</button>
            </div>
        </form>


    </div>
</div>
<!-- end Topbar -->
