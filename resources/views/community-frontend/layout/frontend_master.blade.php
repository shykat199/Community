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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel=”stylesheet” href="ttps://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    @stack('css')

</head>

<body>
<!-- community header area start  -->
@include('sweetalert::alert')

<header class="community-header-area">
    <div class="main-header">
        <div class="community-logo">
            <a href="{{route('community.index')}}"><img
                    src="{{asset("community-frontend/assets/images/community/logo.png")}}" alt="Logo"></a>
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
            {{--            @dd(allRequestedFriend())--}}
            <ul class="menu_list">
                <li class="list_option">
                    <a href="{{route('community.index')}}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
                <li class="list_option">
                    <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><i
                            class="fa fa-user" aria-hidden="true"></i> <span
                            class="counting frind-request-counting">{{ !empty(countRequest()[0]) && isset(countRequest()[0])?countRequest()[0]['total']:'0'}}</span></a>
                    <div class="dropdown-option dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-title d-flex align-items-center">
                            <h4>Friend Requests</h4>
                            <button type="button" class="title-option"><i class="fa fa-ellipsis-h"
                                                                          aria-hidden="true"></i></button>
                        </div>
                        <ul class="dropdown-content">


                            @foreach(allRequestedFriend() as $friendRequest)

                                <li class="dropdown-content-list">
                                    <div class="figure">
                                        <a href="#"><img
                                                src="{{asset("community-frontend/assets/images/community/header/user-1.jpg")}}"
                                                alt=""></a>
                                    </div>
                                    <div class="text">
                                        <h6><a href="#" class="userName" data-idd="{{$friendRequest->reqId}}"
                                               data-id="{{$friendRequest->uId}}">{{$friendRequest->userName}}</a></h6>
                                        <p>26 friends</p>
                                    </div>
                                    <div class="add-dlt-btn">
                                        <a class="dltBtn" type="button"><i class="fa fa-times" aria-hidden="true"></i>
                                        </a>
                                        <a class="addBtn" type="button"><i class="fa fa-check" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </li>
                            @endforeach


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
                                    <a href="#"><img
                                            src="{{asset("community-frontend/assets/images/community/header/user-3.jpg")}}"
                                            alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">Matthew Smith </a></h6>
                                    <p>Hello Dear I Want Talk To You</p>
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
                                    <a href="#"><img
                                            src="{{asset("community-frontend/assets/images/community/header/user-4.jpg")}}"
                                            alt=""></a>
                                </div>
                                <div class="text">
                                    <h6><a href="#">James Vanwin</a></h6>
                                    <p>Posted a comment on your status</p>
                                    <p class="notify-time">20 minutes ago</p>
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
                {{--                @php--}}
                {{--                    $userDetails=allUsersDetails();--}}
                {{--                        $userCover=explode(',',$userDetails->user_cover);--}}
                {{--                        $userProfile=explode(',',$userDetails->user_profile);--}}
                {{--                @endphp--}}
                @php
                    $userDetails=allUsersDetails() !== null ? allUsersDetails():'' ;
                        $userCover=explode(',',!empty($userDetails->user_cover) && isset($userDetails->user_cover)?$userDetails->user_cover:'');
                        $userProfile=explode(',',!empty($userDetails->user_profile) && isset($userDetails->user_cover)?$userDetails->user_cover:'');
                @endphp

                {{--                @dd('storage/community/profile-picture/'.!empty($userProfile[0]) && isset($userProfile[0])?$userProfile[0]:'')--}}

                <li class="list_option">
                    <a href="#" role="button" id="settingDropDown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="logged_profil d-flex align-items-center justify-content-between">
                            <div class="menu-profile d-flex align-items-center me-3">
                                @if(!empty(allUsersDetails()->user_profile) && isset(allUsersDetails()->user_profile))
                                    @if(!empty($userProfile[0]) &&  isset($userProfile[0]))
                                        <img
                                            src="{{asset('storage/community/profile-picture/'.$userProfile[0])}}"
                                            alt="cover">
                                    @else
                                        <img
                                            src="{{asset('community-frontend/assets/images/community/home/user-0.jpg')}}"
                                            alt="cover">

                                    @endif

                                @else
                                    <img src="{{asset('community-frontend/assets/images/community/home/user-0.jpg')}}"
                                         alt="cover">
                                @endif
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
                                <li><i class="fa fa-user" aria-hidden="true"></i><a href="{{route('user.my-profile')}}">My
                                        Profile</a></li>
                                <li><i class="fa fa-cog" aria-hidden="true"></i><a
                                        href="{{route('user.my-profile.setting')}}">Setting</a></li>
                                <li><i class="fa fa-user-secret" aria-hidden="true"></i><a
                                        href="{{route('sight.privacy_policy')}}">Privacy</a></li>
                                <li><i class="fa fa-question-circle" aria-hidden="true"></i><a
                                        href="{{route('sight.help_support')}}">Help &
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
    @yield('frontend.user_setting')
    @yield('frontend.others.birthday')

    <div class="news-feed-content">

        @yield('frontend.others')

        <div class="row">

            @yield('frontend.content')

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

<script src="{{asset("community-frontend/assets/js/jquery.min.js")}}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset("community-frontend/assets/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{asset("community-frontend/assets/js/odometer.js")}}"></script>
<script src="{{asset("community-frontend/assets/js/slick-slider.js")}}"></script>
<script src="{{asset("community-frontend/assets/js/community/script.js")}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('script')


<script>
    $(document).ready(function (e) {
        $('.addBtn').on('click', function () {
            let userName = $(this).parents('.dropdown-content-list').find('.userName').text();
            let userId = $(this).parents('.dropdown-content-list').find('.userName').data('id');
            let tldId = $(this).parents('.dropdown-content-list').find('.userName').data('idd');
            console.log(userName, 'name');
            console.log(tldId, 'id');

            if (userName !== '' && userId !== '') {
                $.ajax({
                    url: '{{route('community.user.acceptRequest')}}',
                    type: 'POST',
                    data: {
                        userId: userId,
                        userName: userName,
                        tldId: tldId,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response);
                        let msg = "";
                        if (response.status) {

                            console.log(msg);
                        }

                    }
                })
            }
        });
    })
</script>

<script>
    import toastr from "../../../../public/community-frontend/assets/js/odometer";

    @if(Session::has('message'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.success("{{ session('message') }}");
    @endif

        @if(Session::has('error'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.error("{{ session('error') }}");
    @endif

        @if(Session::has('info'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.info("{{ session('info') }}");
    @endif

        @if(Session::has('warning'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.warning("{{ session('warning') }}");
    @endif
</script>

</body>

</html>
