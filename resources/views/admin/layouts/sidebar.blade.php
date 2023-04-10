<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">

    <!-- LOGO -->
    <a href="index-2.html" class="logo text-center logo-light">
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/logo.png')}}" alt="" height="16">
                    </span>
        <span class="logo-sm">
                        <img src="{{asset('assets/images/logo_sm.png')}}" alt="" height="16">
                    </span>
    </a>

    <!-- LOGO -->
    <a href="index-2.html" class="logo text-center logo-dark">
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/logo-dark.png')}}" alt="" height="16">
                    </span>
        <span class="logo-sm">
                        <img src="{{asset('assets/images/logo_sm_dark.png')}}" alt="" height="16">
                    </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title side-nav-item">Navigation</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span class="badge bg-success float-end">4</span>
                    <span> Dashboards </span>
                </a>

            </li>


            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#communityPages" aria-expanded="false" aria-controls="communityPages" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Community Page </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="communityPages">
                    <ul class="side-nav-second-level">
                        <li >
                            <a href="{{route('community.page.dashboard')}}">Pages Dashboard</a>
                        </li>

                        <li>
                            <a href="{{route('community.page')}}">All Pages</a>
                        </li>

                        <li>
                            <a href="{{route('community.page')}}">Page Owners</a>
                        </li>

                        <li>
                            <a href="{{route('community.page.posts')}}">Pages Posts</a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#communityUser" aria-expanded="false" aria-controls="serviceCategory" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Community All Users </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="communityUser">
                    <ul class="side-nav-second-level">


                        <li>
                            <a href="{{route('community.user')}}">All Users</a>
                        </li>


                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#communityGroups" aria-expanded="false" aria-controls="communityGroups" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Community All Groups </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="communityGroups">
                    <ul class="side-nav-second-level">


                        <li>
                            <a href="">All Groups</a>
                        </li>
                        <li>
                            <a href="">All Groups Owners</a>
                        </li>
                        <li>
                            <a href="">All Groups User</a>
                        </li>
                        <li>
                            <a href="">All Groups Posts</a>
                        </li>


                    </ul>
                </div>
            </li>



        </ul>


        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
