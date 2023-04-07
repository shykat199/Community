
<body class="loading" data-layout-color="light" data-leftbar-theme="dark" data-layout-mode="fluid"
      data-rightbar-onstart="true">
<!-- Begin page -->
<div class="wrapper">
<!-- ========== Left Sidebar Start ========== -->


<ul class="side-nav">


    <div class="leftside-menu">


        <!-- LOGO -->


        <a href="index-2.html" class="logo text-center logo-light">
                    <span class="logo-lg">
                        <img src="{{asset('assets')}}/images/logo.png" alt="" height="16">
                    </span>
            <span class="logo-sm">
                        <img src="{{asset('assets')}}images/logo_sm.png" alt="" height="16">
                    </span>
        </a>

        <!-- LOGO -->
        <a href="index-2.html" class="logo text-center logo-dark">
                    <span class="logo-lg">
                        <img src="{{asset('assets')}}/images/logo-dark.png" alt="" height="16">
                    </span>
            <span class="logo-sm">
                        <img src="{{asset('assets')}}/images/logo_sm_dark.png" alt="" height="16">
                    </span>
        </a>

        <div class="h-100" id="leftside-menu-container" data-simplebar>

            <!--- Sidemenu -->
            <ul class="side-nav">


                {{--                        <li class="side-nav-title side-nav-item"></li>--}}

                <li class="side-nav-item">
                {{--                            <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>--}}
                <li class="side-nav-title side-nav-item">DASHBOARD</li>

                </li>

                {{--Community AREA--}}

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#community" aria-expanded="false" aria-controls="adminBlog" class="side-nav-link">
                        <i class="uil-store"></i>
                        <span> Community Section </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="community">
                        <ul class="side-nav-second-level">
                            <li>
                                <a href="{{route('community.page')}}">Pages Dashboard</a>
                            </li>

                            <li>
                                <a href="">Group Dashboard</a>
                            </li>

                            <li>
                                <a href="">User Dashboard</a>
                            </li>
                            <li>
                                <a href="">User Posts</a>
                            </li>

                        </ul>
                    </div>
                </li>


                <!-- end Help Box -->
                <!-- End Sidebar -->

                <div class="clearfix"></div>
            </ul>

        </div>
        <!-- Sidebar -left -->

    </div>

</ul>
</div>
</body>
<!-- ========== Left Sidebar Start ========== -->
{{--<div class="leftside-menu">--}}

{{--    <!-- LOGO -->--}}
{{--    <a href="index-2.html" class="logo text-center logo-light">--}}
{{--                    <span class="logo-lg">--}}
{{--                        <img src="{{asset('assets/images/logo.png')}}" alt="" height="16">--}}
{{--                    </span>--}}
{{--        <span class="logo-sm">--}}
{{--                        <img src="{{asset('assets/images/logo_sm.png')}}" alt="" height="16">--}}
{{--                    </span>--}}
{{--    </a>--}}

{{--    <!-- LOGO -->--}}
{{--    <a href="index-2.html" class="logo text-center logo-dark">--}}
{{--                    <span class="logo-lg">--}}
{{--                        <img src="{{asset('assets/images/logo-dark.png')}}" alt="" height="16">--}}
{{--                    </span>--}}
{{--        <span class="logo-sm">--}}
{{--                        <img src="{{asset('assets/images/logo_sm_dark.png')}}" alt="" height="16">--}}
{{--                    </span>--}}
{{--    </a>--}}

{{--    <div class="h-100" id="leftside-menu-container" data-simplebar>--}}

{{--        <!--- Sidemenu -->--}}
{{--        <ul class="side-nav">--}}

{{--            <li class="side-nav-title side-nav-item">Navigation</li>--}}

{{--            <li class="side-nav-item">--}}
{{--                <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">--}}
{{--                    <i class="uil-home-alt"></i>--}}
{{--                    <span class="badge bg-success float-end">4</span>--}}
{{--                    <span> Dashboards </span>--}}
{{--                </a>--}}

{{--            </li>--}}


{{--            <li class="side-nav-item">--}}
{{--                <a data-bs-toggle="collapse" href="#serviceCategory" aria-expanded="false" aria-controls="serviceCategory" class="side-nav-link">--}}
{{--                    <i class="uil-store"></i>--}}
{{--                    <span> Service Category </span>--}}
{{--                    <span class="menu-arrow"></span>--}}
{{--                </a>--}}
{{--                <div class="collapse" id="serviceCategory">--}}
{{--                    <ul class="side-nav-second-level">--}}
{{--                        <li>--}}
{{--                            <a href="{{route('category.list')}}">All Categories</a>--}}
{{--                        </li>--}}

{{--                        <li>--}}
{{--                            <a href="{{route('category.view')}}">Add New Category</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}



{{--        </ul>--}}


{{--        <!-- End Sidebar -->--}}

{{--        <div class="clearfix"></div>--}}

{{--    </div>--}}
{{--    <!-- Sidebar -left -->--}}

{{--</div>--}}
<!-- Left Sidebar End -->
