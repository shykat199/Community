@extends('community-frontend.layout.frontend_master')
@section('frontend.user_setting')
    <!-- my profile start -->
    <div class="main-profile">
        <div class="row">
            <div class="col-lg-12">
                <div class="full-profile-box">
                    <div class="full-profile-cover group-page-cover">
                        <img
                            src="{{asset("community-frontend/assets/images/community/myProfile/my-profile-cover.jpg")}}"
                            alt="cover">
                        <div class="page-name">
                            Groups
                        </div>
                        <div>
                            <button type="button" class="social-theme-btn group-add-btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                <i class="fa fa-plus"></i>
                                Create Group
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form action="{{route('user.create.groups')}}" class="add-group-modal"
                                                  method="post">
                                                @csrf
                                                <label for="gname">Group Name</label>

                                                <input type="text" name="groupName" id="gname">

                                                <label for="gdescription">Group Description</label>

                                                <textarea name="groupDescription" id="gdescription"></textarea>

                                                <div class="group-btn-div">
                                                    <button type="submit" class="social-theme-btn creat-group-btn">
                                                        Create Groups
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Modal -->
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
                                    <button class="nav-link active" id="friendRequestTab" data-bs-toggle="tab"
                                            data-bs-target="#friendRequest" type="button" role="tab"
                                            aria-controls="home" aria-selected="false">All Groups
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="recentlyAddedTab" data-bs-toggle="tab"
                                            data-bs-target="#recentlyAdded" type="button" role="tab"
                                            aria-controls="profile" aria-selected="true">My Groups
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="search_box">
                            <form>
                                <input type="text" id="inputSearch" placeholder="Search...">
                                <button type="submit" id="inputSearchBtn"><i class="fa fa-search"
                                                                             aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- tab button with searchbox start  -->
            </div>
        </div>
        <div class="row">  <!-- tab content in this row -->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="friendRequest" role="tabpanel"
                     aria-labelledby="friendRequestTab">
                    <div class="profile-friend-list">
                        <div class="row">
{{--                            @dd($allAvailableGroups)--}}
                            @foreach($allAvailableGroups as $group)
                                {{--@dd($group)--}}
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="single-profile-list single-group-list">
                                        <div class="view-profile left-widget">
                                            <div class="profile-cover">
                                                <a href="#"><img
                                                        src="{{asset("community-frontend/assets/images/community/home/smallCover.jpg")}}"
                                                        alt="cover"></a>
                                            </div>
                                            <a href="{{route('user.group.details',\Illuminate\Support\Facades\Crypt::encrypt($group->gId))}}" style="text-decoration: none;color: inherit;">

                                                <div class="profile-title d-flex align-items-center">
                                                    <img
                                                            src="{{asset("community-frontend/assets/images/community/home/user-0.jpg")}}"
                                                            alt="image">
                                                    <div class="profile-name">
                                                        <h6>{{$group->gName}}</h6>
                                                        <span class="mutual-friend">Public Groups</span>
                                                    </div>
                                                </div>

                                            </a>
                                            <ul class="profile-statistics">
                                                <li><a href="#">
                                                        <p class="statics-count">{{getGroupPostCount($group->gId)}}</p>
                                                        <p class="statics-name">Post</p>
                                                    </a></li>
                                                <li><a href="#">
                                                        <p class="statics-count">{{$group->userCount?$group->userCount:'0'}}</p>
                                                        <p class="statics-name">Members</p>
                                                    </a></li>
                                                <li><a href="#">
                                                        <p class="statics-count">{{\Carbon\Carbon::parse($group->created_at)->format('Y')}}</p>
                                                        <p class="statics-name">Since</p>
                                                    </a></li>
                                            </ul>
                                            <ul class="add-msg-btn join-group">

                                                <li>
                                                    <form action="{{route('user.join.groups')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="groupId" value="{{$group->gId}}">
                                                        @if($group->user_status===0)
                                                            <button type="button" class="add-btn">Request Send</button>
                                                            {{--                                                        @elseif($group->user_status===1)--}}
                                                            {{--                                                            <button type="button" class="add-btn">Go</button>--}}
                                                        @else
                                                            <button type="submit" class="add-btn">Join Group</button>
                                                        @endif
                                                    </form>
                                                </li>

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

                            @foreach($myGroups as $group)
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="single-profile-list single-group-list">
                                        <div class="view-profile left-widget">
                                            <div class="profile-cover">
                                                <a href="#"><img
                                                        src="{{asset("community-frontend/assets/images/community/home/smallCover.jpg")}}"
                                                        alt="cover"></a>
                                            </div>

                                            <a href="{{route('user.group.details',$group->gId)}}" style="text-decoration: none;color: inherit;">
                                                <div class="profile-title d-flex align-items-center">
                                                    <img
                                                            src="{{asset("community-frontend/assets/images/community/home/user-0.jpg")}}"
                                                            alt="image">
                                                    <div class="profile-name">
                                                        <h6>{{$group->gName}}</h6>
                                                        <span class="mutual-friend">Public Groups</span>
                                                    </div>
                                                </div>
                                            </a>

                                            <ul class="profile-statistics">
                                                <li><a href="#">
                                                        <p class="statics-count">{{getGroupPostCount($group->gId)}}</p>
                                                        <p class="statics-name">Post</p>
                                                    </a></li>
                                                <li><a href="#">
                                                        <p class="statics-count">{{$group->userCount?$group->userCount:'0'}}</p>
                                                        <p class="statics-name">Members</p>
                                                    </a></li>
                                                <li><a href="#">
                                                        <p class="statics-count">{{\Carbon\Carbon::parse($group->created_at)->format('Y')}}</p>
                                                        <p class="statics-name">Since</p>
                                                    </a></li>
                                            </ul>
                                            <ul class="add-msg-btn join-group">

                                                <li>
                                                    <form action="{{route('user.create.groups')}}">
                                                        <input type="hidden" name="groupId" value="{{$group->gId}}">
                                                        @if($group->user_status===1)
                                                            <button type="button" class="add-btn">Go</button>
                                                        @endif

                                                    </form>
                                                </li>

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
