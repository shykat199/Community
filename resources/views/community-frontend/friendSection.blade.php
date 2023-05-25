@extends('community-frontend.layout.frontend_master')
@section('frontend.user_setting')
    <!-- my profile start -->
    <div class="main-profile">
        <div class="row">
            <div class="col-lg-12">
                <div class="full-profile-box">
                    <div class="full-profile-cover">
                        <img src="{{asset("community-frontend/assets/images/community/myProfile/my-profile-cover.jpg")}}" alt="cover">
                        <div class="page-name">
                            Friends
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- my profile end -->
@endsection

@section('frontend.others')
    <div class="setting-page-wrap">
        <!-- Friend list page start  -->
        <div class="row">
            <div class="col-lg-12">
                <!-- tab button with searchbox start  -->
                <div class="friends-tab-wrap">
                    <div class="friends-title">
                        <div class="friend-status">
                            <ul class="nav nav-tabs status-tab" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="friendRequestTab" data-bs-toggle="tab" data-bs-target="#friendRequest" type="button" role="tab" aria-controls="home" aria-selected="false">Friend Requests
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="recentlyAddedTab" data-bs-toggle="tab" data-bs-target="#recentlyAdded" type="button" role="tab" aria-controls="profile" aria-selected="true">People You Know</button>
                                </li>
                            </ul>
                        </div>
                        <div class="search_box">
                            <form>
                                <input type="text" id="inputSearch" placeholder="Search...">
                                <button type="submit" id="inputSearchBtn"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- tab button with searchbox start  -->
            </div>
        </div>
        <div class="row">  <!-- tab content in this row -->

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="friendRequest" role="tabpanel" aria-labelledby="friendRequestTab">
                    <div class="profile-friend-list">
                        <div class="row">
{{--                            @dd($allRequestedUser)--}}
                            @foreach($allRequestedUser as $requestFriend)
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="single-profile-list">
                                        <div class="view-profile left-widget">
                                            <div class="profile-cover">
{{--                                                <a href="#"><img src="{{asset("community-frontend/assets/images/community/home/smallCover.jpg")}}" alt="cover"></a>--}}


                                                @if(!empty($requestFriend->userCoverImages[0]) && isset($requestFriend->userCoverImages[0])?$requestFriend->userCoverImages [0]:'')

                                                    @if(!empty($requestFriend->userCoverImages[0]) && isset($requestFriend->userCoverImages[0])?$requestFriend->userCoverImages [0]:'')
                                                        <a href=""><img
                                                                src="{{asset("storage/community/profile-picture/".$requestFriend->userCoverImages[0]->user_cover)}}"
                                                                alt="image"></a>
                                                    @else
                                                        <a href=""><img
                                                                src="{{asset("community-frontend/assets/images/community/home/smallCover.jpg")}}"
                                                                alt="image"></a>
                                                    @endif
                                                @else

                                                    <a href=""><img
                                                            src="{{asset("community-frontend/assets/images/community/home/smallCover.jpg")}}"
                                                            alt="image"></a>
                                                @endif


                                                <div class="add-friend-icon">
                                                    <a href="#"><i class="fa fa-user-o" aria-hidden="true"></i></a>
                                                </div>
                                            </div>

                                            <div class="profile-title d-flex align-items-center">


                                                @if(!empty($requestFriend->userProfileImages[0]) && isset($requestFriend->userProfileImages[0])?$requestFriend->userProfileImages[0]:'')

                                                    @if(!empty($requestFriend->userProfileImages[0]) && isset($requestFriend->userProfileImages[0])?$requestFriend->userProfileImages[0]:'')
                                                        <a href=""><img
                                                                src="{{asset("storage/community/profile-picture/".$requestFriend->userProfileImages[0]->user_profile)}}"
                                                                alt="image"></a>
                                                    @else
                                                        <a href=""><img
                                                                src="{{asset("community-frontend/assets/images/community/home/user-0.jpg")}}"
                                                                alt="image"></a>
                                                    @endif
                                                @else

                                                    <a href=""><img
                                                            src="{{asset("community-frontend/assets/images/community/home/user-0.jpg")}}"
                                                            alt="image"></a>
                                                @endif



                                                <div class="profile-name">
                                                    <h6><a href="#">{{$requestFriend->name}}</a></h6>
                                                    <span class="mutual-friend">{{$requestFriend->countMutualFriend}} Mutual Friends</span>
                                                </div>
                                            </div>
                                            <ul class="profile-statistics">
                                                <li><a href="#">
                                                        <p class="statics-count">0</p>
                                                        <p class="statics-name">Likes</p>
                                                    </a></li>
                                                <li><a href="#">
                                                        <p class="statics-count">{{$requestFriend->followings}}</p>
                                                        <p class="statics-name">Following</p>
                                                    </a></li>
                                                <li>
{{--                                                    <a href="#">--}}
{{--                                                        <p class="statics-count">784514</p>--}}
{{--                                                        <p class="statics-name">Followers</p>--}}
{{--                                                    </a>--}}
                                                </li>
                                            </ul>
                                            <ul class="add-msg-btn">
                                                <li><button type="button" class="add-btn">Accept</button></li>
                                                <li><button type="button" class="msg-btn">Send Message</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="recentlyAdded" role="tabpanel" aria-labelledby="recentlyAddedTab">
                    <div class="profile-friend-list">
                        <div class="row">

{{--                            @dd($allUsers)--}}

                            @foreach($allUsers as $user)
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="single-profile-list">
                                        <div class="view-profile left-widget">
                                            <div class="profile-cover">


                                                @if(!empty($user->userCoverImages[0]) && isset($user->userCoverImages[0])?$user->userCoverImages [0]:'')

                                                    @if(!empty($user->userCoverImages[0]) && isset($user->userCoverImages[0])?$user->userCoverImages [0]:'')
                                                        <a href=""><img
                                                                src="{{asset("storage/community/profile-picture/".$user->userCoverImages[0]->user_cover)}}"
                                                                alt="image"></a>
                                                    @else
                                                        <a href=""><img
                                                                src="{{asset("community-frontend/assets/images/community/home/smallCover.jpg")}}"
                                                                alt="image"></a>
                                                    @endif
                                                @else

                                                    <a href=""><img
                                                            src="{{asset("community-frontend/assets/images/community/home/smallCover.jpg")}}"
                                                            alt="image"></a>
                                                @endif


{{--                                                <a href="#"><img src="{{asset("community-frontend/assets/images/community/home/smallCover.jpg")}}" alt="cover"></a>--}}
                                                <div class="add-friend-icon">
                                                    <a href="#"><i class="fa fa-user-o" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                            <div class="profile-title d-flex align-items-center">
                                                @if(!empty($user->userProfileImages[0]) && isset($user->userProfileImages[0])?$user->userProfileImages[0]:'')

                                                    @if(!empty($user->userProfileImages[0]) && isset($user->userProfileImages[0])?$user->userProfileImages[0]:'')
                                                        <a href=""><img
                                                                src="{{asset("storage/community/profile-picture/".$user->userProfileImages[0]->user_profile)}}"
                                                                alt="image"></a>
                                                    @else
                                                        <a href=""><img
                                                                src="{{asset("community-frontend/assets/images/community/home/user-0.jpg")}}"
                                                                alt="image"></a>
                                                    @endif
                                                @else

                                                    <a href=""><img
                                                            src="{{asset("community-frontend/assets/images/community/home/user-0.jpg")}}"
                                                            alt="image"></a>
                                                @endif
                                                <div class="profile-name">
                                                    <h6><a href="#">{{$user->name}}</a></h6>
                                                    <span class="mutual-friend">{{$user->countMutualFriend}} Mutual Friends</span>
                                                </div>
                                            </div>
                                            <ul class="profile-statistics">
                                                <li><a href="#">
                                                        <p class="statics-count">0</p>
                                                        <p class="statics-name">Likes</p>
                                                    </a></li>
                                                <li><a href="#">
                                                        <p class="statics-count">{{$user->followings}}</p>
                                                        <p class="statics-name">Following</p>
                                                    </a></li>
                                                <li>
{{--                                                    <a href="#">--}}
{{--                                                        <p class="statics-count">784514</p>--}}
{{--                                                        <p class="statics-name">Followers</p>--}}
{{--                                                    </a>--}}
                                                </li>
                                            </ul>
                                            <ul class="add-msg-btn">
                                                <li><button type="button" class="add-btn">Add Friend</button></li>
                                                <li><button type="button" class="msg-btn">Send Message</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Friend list page start  -->
    </div>
@endsection
@include('community-frontend.layout.liveChat')
@include('community-frontend.layout.sidebar')
