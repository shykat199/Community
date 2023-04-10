<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community</title>
    <link rel="stylesheet" href="{{asset("community-frontend/assets/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("community-frontend/assets/css/odometer-theme-default.css")}}">
    <link rel="stylesheet" href="{{asset("community-frontend/assets/css/slick.css")}}">
    <link rel="stylesheet" href="{{asset("community-frontend/assets/css/font-awesome.min.css")}}">
    <link rel="stylesheet" href="{{asset("community-frontend/assets/css/default.css")}}">
    <link rel="stylesheet" href="{{asset("community-frontend/assets/sass/style.css")}}">

    <script src="{{asset("community-frontend/assets/js/jquery.min.js")}}"></script>
</head>

<body>
<!-- community header area start  -->
@if(\Illuminate\Support\Facades\Session::has('success'))
    <div class="alert alert-success m-2" role="alert">
        <i class="dripicons-checkmark me-2"></i>
        <strong>{{\Illuminate\Support\Facades\Session::get('success')}}</strong>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"
                style="float: right"></button>
    </div>
@endif
<header class="community-header-area">
    <div class="main-header">
        <div class="community-logo">
            <a href="#"><img src="{{asset("community-frontend/assets/images/community/logo.png")}}" alt="Logo"></a>
        </div>
        <div class="community-header-content">
            <div class="menu-show">
                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
            </div>
            <div class="sidenav_bar">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </div>
            <div class="search_box">
                <form>
                    <input type="text" id="inputSearch" placeholder="Search...">
                    <button type="submit" id="inputSearchBtn"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
            <ul class="menu_list">
                <li class="list_option">
                    <a href="#"><i class="fa fa-home" aria-hidden="true"></i></a></li>
                <li class="list_option">
                    <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><i
                            class="fa fa-user" aria-hidden="true"></i> <span
                            class="counting frind-request-counting">5</span></a>
                    <div class="dropdown-option dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-title d-flex align-items-center">
                            <h4>Friend Requests</h4>
                            <button type="button" class="title-option"><i class="fa fa-ellipsis-h"
                                                                          aria-hidden="true"></i></button>
                        </div>
                        <ul class="dropdown-content">
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="/assets/images/community/header/user-1.jpg" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">James Vanwin</a></h6>
                                    <p>26 friends</p>
                                </div>
                                <div class="add-dlt-btn">
                                    <button id="dltBtn" type="button"><i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                    <button id="addBtn" type="button"><i class="fa fa-check" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </li>
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="/assets/images/community/header/user-2.jpg" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">James Vanwin</a></h6>
                                    <p>26 friends</p>
                                </div>
                                <div class="add-dlt-btn">
                                    <button id="dltBtn" type="button"><i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                    <button id="addBtn" type="button"><i class="fa fa-check" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </li>
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="/assets/images/community/header/user-3.jpg" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">James Vanwin</a></h6>
                                    <p>26 friends</p>
                                </div>
                                <div class="add-dlt-btn">
                                    <button id="dltBtn" type="button"><i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                    <button id="addBtn" type="button"><i class="fa fa-check" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </li>
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="/assets/images/community/header/user-4.jpg" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">James Vanwin</a></h6>
                                    <p>26 friends</p>
                                </div>
                                <div class="add-dlt-btn">
                                    <button id="dltBtn" type="button"><i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                    <button id="addBtn" type="button"><i class="fa fa-check" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </li>
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="/assets/images/community/header/user-5.jpg" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">James Vanwin</a></h6>
                                    <p>26 friends</p>
                                </div>
                                <div class="add-dlt-btn">
                                    <button id="dltBtn" type="button"><i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                    <button id="addBtn" type="button"><i class="fa fa-check" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </li>
                        </ul>
                        <a href="#" class="vew-all-btn">View All Requests</a>
                    </div>
                </li>
                <li class="list_option">
                    <a href="#" role="button" id="smsDropdown" data-bs-toggle="dropdown" aria-expanded="false"><i
                            class="fa fa-envelope-o" aria-hidden="true"></i> <span
                            class="counting sms-counting">4</span></a>
                    <div class="dropdown-option dropdown-sms-option dropdown-menu" aria-labelledby="smsDropdown">
                        <div class="dropdown-title d-flex align-items-center">
                            <h4>Messages</h4>
                            <button type="button" class="title-option"><i class="fa fa-ellipsis-h"
                                                                          aria-hidden="true"></i></button>
                        </div>
                        <form action="#" class="sms-search">
                            <input type="text" id="smsSearch" placeholder="Search Message...">
                            <button id="smsSearchBtn" type="submit"><i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                        <ul class="dropdown-content dropdown-sms-content">
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="/assets/images/community/header/user-1.jpg" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">James Vanwin</a></h6>
                                    <p>Hello Dear I Want Talk To You</p>
                                </div>
                            </li>
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="/assets/images/community/header/user-2.jpg" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">Harry Lopez</a></h6>
                                    <p>Hello Dear I Want Talk To You</p>
                                </div>
                            </li>
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="{{asset("community-frontend/assets/images/community/header/user-3.jpg")}}" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">Matthew Smith </a></h6>
                                    <p>Hello Dear I Want Talk To You</p>
                                </div>
                            </li>
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="/assets/images/community/header/user-4.jpg" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">James Vanwin</a></h6>
                                    <p>Hi. I Am looking For UI Designer</p>
                                </div>
                            </li>
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="/assets/images/community/header/user-5.jpg" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">Harry Lopez</a></h6>
                                    <p>Thanks For Connecting!</p>
                                </div>
                            </li>
                        </ul>
                        <a href="#" class="vew-all-btn">View All Message</a>
                    </div>
                </li>
                <li class="list_option">
                    <a href="#" role="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false"><i
                            class="fa fa-bell-o" aria-hidden="true"></i> <span
                            class="counting notificaiton-counting">5</span></a>
                    <div class="dropdown-option dropdown-menu" aria-labelledby="notificationDropdown">
                        <div class="dropdown-title d-flex align-items-center">
                            <h4>Notifications</h4>
                            <button type="button" class="title-option"><i class="fa fa-ellipsis-h"
                                                                          aria-hidden="true"></i></button>
                        </div>
                        <ul class="dropdown-content">
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="/assets/images/community/header/user-1.jpg" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">James Vanwin</a></h6>
                                    <p>Posted a comment on your status</p>
                                    <p class="notify-time">20 minutes ago</p>
                                </div>
                            </li>
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="/assets/images/community/header/user-2.jpg" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">Harry Lopez</a></h6>
                                    <p>Sent Your a Friend Request</p>
                                    <p class="notify-time">2 Days ago</p>
                                </div>
                            </li>
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="/assets/images/community/header/user-3.jpg" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">Matthew Smith </a></h6>
                                    <p>Posted a comment on your status</p>
                                    <p class="notify-time">3 Days ago</p>
                                </div>
                            </li>
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="/assets/images/community/header/user-4.jpg" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">James Vanwin</a></h6>
                                    <p>Posted a comment on your status</p>
                                    <p class="notify-time">20 minutes ago</p>
                                </div>
                            </li>
                            <li class="dropdown-content-list">
                                <div class="figure">
                                    <a href="#"><img src="/assets/images/community/header/user-5.jpg" alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">Harry Lopez</a></h6>
                                    <p>Sent Your a Friend Request</p>
                                    <p class="notify-time">2 Days ago</p>
                                </div>
                            </li>
                        </ul>
                        <a href="#" class="vew-all-btn">View All Notifications</a>
                    </div>
                </li>
                <li class="list_option d-flex align-items-center">
                    <a href="#"><i class="fa fa-globe" aria-hidden="true"></i></a>
                    <select id="language_selector">
                        <option value="eng">Eng</option>
                        <option value="china">简体中文</option>
                        <option value="arb">العربيّة</option>
                    </select>
                </li>
                <li class="list_option">
                    <a href="#" role="button" id="settingDropDown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="logged_profil d-flex align-items-center justify-content-between">
                            <div class="menu-profile d-flex align-items-center me-3">
                                <img src="{{asset("community-frontend/assets/images/community/header/01.jpg")}}" alt="">
                                <p class="member_name">{{Auth::user()->name}}
                                    <span class="login-status"></span>
                                </p>
                            </div>
                            <div class="menu-profile-icon">
                                <i class="fa fa-cog" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="dropdown-for-setting dropdown-menu" aria-labelledby="settingDropDown">
                            <div class="profile-name-menu">
                                <h5>{{Auth::user()->name}}</h5>
                                <p class="profile-mail">
                                    <a href="#">{{Auth::user()->email}}</a>
                                </p>
                            </div>
                            <ul class="settings-list">
                                <li><i class="fa fa-user" aria-hidden="true"></i><a href="#">My Profile</a></li>
                                <li><i class="fa fa-cog" aria-hidden="true"></i><a href="#">Setting</a></li>
                                <li><i class="fa fa-user-secret" aria-hidden="true"></i><a href="#">Privecy</a></li>
                                <li><i class="fa fa-question-circle" aria-hidden="true"></i><a href="#">Help &
                                        Support</a></li>
                                <li><i class="fa fa-sign-out" aria-hidden="true"></i>
                                    <a href="{{route('admin.logout')}}">Logout</a></li>
                            </ul>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</header>

<!-- community header area end  -->
<!-- community main content area start  -->
<section class="all-content">
    <!-- news feed content start  -->
    <div class="news-feed-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="news-feed-left">

                    @include('community-frontend.layout.userProfile')

                    @include('community-frontend.layout.pageLike')
                    @include('community-frontend.layout.suggestedGroup')

                </div>
            </div>


            @yield('frontend.content')

            <div class="col-lg-3">
                <div class="news-feed-right">
                    <div class="weather-img">
                        <a href="#">
                            <img src="{{asset("community-frontend/assets/images/community/home/right/weather.jpg")}}" alt="image">
                        </a>
                    </div>


                    @include('community-frontend.layout.birthday')

                    @include('community-frontend.layout.following')

                </div>
            </div>
        </div>
    </div>
    <!-- news feeds content start  -->
    <!-- live chat and contact area start  -->
    @include('community-frontend.layout.liveChat')
    <!-- live chat and contact area end  -->
    <!-- side nav start  -->
    @include('community-frontend.layout.sidebar')
    <!-- side nav end  -->
</section>
<!-- community main content area end  -->

@include('community-frontend.layout.footer')


<script src="{{asset("community-frontend/assets/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{asset("community-frontend/assets/js/odometer.js")}}"></script>
<script src="{{asset("community-frontend/assets/js/slick-slider.js")}}"></script>
<script src="{{asset("community-frontend/assets/js/community/script.js")}}"></script>
</body>

</html>
