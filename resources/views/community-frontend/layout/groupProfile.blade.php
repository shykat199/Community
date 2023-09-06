<!-- my profile start -->

@php

    $isAdmin=\App\Models\Community\Group\CommunityUserGroupPivot::select('group_user_role')->where('user_id','=',Auth::id())
               ->where('group_id','=',$id)->first();

@endphp
<div class="main-profile">
    <div class="row">
        <div class="col-lg-12">
            <div class="full-profile-box">
                <div class="full-profile-cover">

                    @if(!empty($getGroupDetails->cover_photo) && isset($getGroupDetails->cover_photo))

                        @if(!empty($getGroupDetails->cover_photo) &&  isset($getGroupDetails->cover_photo))
                            <img
                                src="{{asset('storage/community/group-post/cover/'.$getGroupDetails->cover_photo)}}"
                                alt="cover">

                        @else
                            <img src="{{asset('community-frontend/assets/images/community/home/smallCover.jpg')}}"
                                 alt="cover">

                        @endif
                    @else
                        <img src="{{asset('community-frontend/assets/images/community/home/smallCover.jpg')}}"
                             alt="cover">

                    @endif
                    {{--                            <img src="{{asset("community-frontend/assets/images/community/myProfile/my-profile-cover.jpg")}}" alt="cover">--}}
                    {{--                        @dd($getGroupDetails)--}}
                    @if($isAdmin)
                        <div class="edit-cover">
                            <button data-bs-toggle="modal" data-bs-target="#coverPhotoModal">Edit Cover</button>

                            <div class="modal fade" id="coverPhotoModal" tabindex="-1"
                                 aria-labelledby="coverPhotoModalLabel" aria-hidden="true">
                                <form action="{{route('user.group.cover.upload')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="grpId" id="" value="{{$getGroupDetails->gId}}">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content post-modal-content">
                                            <div class="modal-header">
                                                <div class="post-modal-title">
                                                    <h6 class="modal-title" id="photoModalLabel">Upload Cover</h6>
                                                </div>
                                                <button type="button" class=" post-close" data-bs-dismiss="modal"
                                                        aria-label="Close"><i class="fa fa-times"
                                                                              aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body post-modal-body">
                                                <div class="upload-media">
                                                    <div class="photo-place">
                                                    <span class="icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0"
                                                             y="0" viewBox="0 0 24 24"
                                                             style="enable-background:new 0 0 512 512"
                                                             xml:space="preserve" class=""><g><path
                                                                    d="m22.448 7.608-1.2 8.58a3.142 3.142 0 0 1-1.257 2.312.311.311 0 0 1-.488-.244V9.665A3.829 3.829 0 0 0 15.335 5.5H5.923c-.3 0-.307-.27-.286-.39a3.134 3.134 0 0 1 1.112-2.085 3.2 3.2 0 0 1 2.442-.473l10.561 1.48a3.211 3.211 0 0 1 2.223 1.134 3.191 3.191 0 0 1 .473 2.442zM18 9.665v8.668A2.358 2.358 0 0 1 15.335 21H4.667A2.357 2.357 0 0 1 2 18.333V9.665A2.357 2.357 0 0 1 4.667 7h10.668A2.358 2.358 0 0 1 18 9.665zM13.25 14a.75.75 0 0 0-.75-.75h-1.75V11.5a.75.75 0 0 0-1.5 0v1.75H7.5a.75.75 0 0 0 0 1.5h1.75v1.75a.75.75 0 0 0 1.5 0v-1.75h1.75a.75.75 0 0 0 .75-.75z"
                                                                    fill="#000000" data-original="#000000"
                                                                    class=""></path></g></svg>
                                                    </span>
                                                        <h6 class="title">Add Photos</h6>
                                                        <p class="small-text">or drag and drop</p>
                                                    </div>
                                                    <div class="preview-file">
                                                        <img class="previewImg" src="#" alt="">
                                                        <button type="button" class="imgClose"><i class="fa fa-times"
                                                                                                  aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="media-input">
                                                        <input accept="image/*" type='file' name="grpCover"
                                                               class="imgInp"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="social-theme-btn post-btn">Post</button>
                                            </div>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="full-profile-info p-50">
                    <div class="full-profile-left">
                        <div class="profile-img">
                            @if(!empty($getGroupDetails->groupProfile) && isset($getGroupDetails->groupProfile))

                                @if(!empty($getGroupDetails->groupProfile) &&  isset($getGroupDetails->groupProfile))
                                    <a href="#">
                                        <img
                                            src="{{asset('storage/community/group-post/profile/'.$getGroupDetails->groupProfile)}}"
                                            alt="cover">
                                    </a>
                                @else
                                    <a href="#">
                                        <img
                                            src="{{asset('community-frontend/assets/images/community/home/smallCover.jpg')}}"
                                            alt="cover">
                                    </a>
                                @endif
                            @else
                                <a href="#">
                                    <img src="{{asset('community-frontend/assets/images/community/home/user-0.jpg')}}"
                                         alt="cover">
                                </a>

                            @endif
                            {{--                                    <a href="#">--}}
                            {{--                                        <img src="{{asset("community-frontend/assets/images/community/myProfile/my-profile.jpg")}}" alt="Image">--}}
                            {{--                                    </a>--}}

                            @if($isAdmin)
                                <div class="replace-icon">
                                    <a href="#" class="replace-btn" data-bs-toggle="modal" data-bs-target="#profilePhotoModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0"
                                             viewBox="0 0 32 32" style="enable-background:new 0 0 512 512"
                                             xml:space="preserve" class=""><g>
                                                <path
                                                    d="M27.348 7h-4.294l-.5-1.5A3.645 3.645 0 0 0 19.089 3h-6.178a3.646 3.646 0 0 0-3.464 2.5L8.946 7H4.652A3.656 3.656 0 0 0 1 10.652v14.7A3.656 3.656 0 0 0 4.652 29h22.7A3.656 3.656 0 0 0 31 25.348v-14.7A3.656 3.656 0 0 0 27.348 7ZM29 25.348A1.654 1.654 0 0 1 27.348 27H4.652A1.654 1.654 0 0 1 3 25.348v-14.7A1.654 1.654 0 0 1 4.652 9h5.015a1 1 0 0 0 .948-.684l.729-2.187A1.65 1.65 0 0 1 12.911 5h6.178a1.649 1.649 0 0 1 1.567 1.13l.729 2.186a1 1 0 0 0 .948.684h5.015A1.654 1.654 0 0 1 29 10.652Z"
                                                    fill="#000000" data-original="#000000"></path>
                                                <path
                                                    d="M16 10a7.5 7.5 0 1 0 7.5 7.5A7.508 7.508 0 0 0 16 10Zm0 13a5.5 5.5 0 1 1 5.5-5.5A5.506 5.506 0 0 1 16 23Z"
                                                    fill="#000000" data-original="#000000"></path>
                                                <circle cx="26" cy="12" r="1" fill="#000000"
                                                        data-original="#000000"></circle>
                                            </g></svg>
                                    </a>
                                    <div class="modal fade" id="profilePhotoModal" tabindex="-1"
                                         aria-labelledby="profilePhotoModalLabel" aria-hidden="true">

                                        <form action="{{route('user.group.profile.upload')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="grpId" id="" value="{{$getGroupDetails->gId}}">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content post-modal-content">
                                                    <div class="modal-header">
                                                        <div class="post-modal-title">
                                                            <h6 class="modal-title" id="photoModalLabel">Upload
                                                                Profile</h6>
                                                        </div>
                                                        <button type="button" class=" post-close"
                                                                data-bs-dismiss="modal"
                                                                aria-label="Close"><i class="fa fa-times"
                                                                                      aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body post-modal-body">
                                                        <div class="upload-media">
                                                            <div class="photo-place">
                                                    <span class="icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0"
                                                             y="0" viewBox="0 0 24 24"
                                                             style="enable-background:new 0 0 512 512"
                                                             xml:space="preserve" class=""><g><path
                                                                    d="m22.448 7.608-1.2 8.58a3.142 3.142 0 0 1-1.257 2.312.311.311 0 0 1-.488-.244V9.665A3.829 3.829 0 0 0 15.335 5.5H5.923c-.3 0-.307-.27-.286-.39a3.134 3.134 0 0 1 1.112-2.085 3.2 3.2 0 0 1 2.442-.473l10.561 1.48a3.211 3.211 0 0 1 2.223 1.134 3.191 3.191 0 0 1 .473 2.442zM18 9.665v8.668A2.358 2.358 0 0 1 15.335 21H4.667A2.357 2.357 0 0 1 2 18.333V9.665A2.357 2.357 0 0 1 4.667 7h10.668A2.358 2.358 0 0 1 18 9.665zM13.25 14a.75.75 0 0 0-.75-.75h-1.75V11.5a.75.75 0 0 0-1.5 0v1.75H7.5a.75.75 0 0 0 0 1.5h1.75v1.75a.75.75 0 0 0 1.5 0v-1.75h1.75a.75.75 0 0 0 .75-.75z"
                                                                    fill="#000000" data-original="#000000"
                                                                    class=""></path></g></svg>
                                                    </span>
                                                                <h6 class="title">Add Photos</h6>
                                                                <p class="small-text">or drag and drop</p>
                                                            </div>
                                                            <div class="preview-file">
                                                                <img class="previewImg" src="#" alt="">
                                                                <button type="button" class="imgClose"><i
                                                                        class="fa fa-times"
                                                                        aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                            <div class="media-input">
                                                                <input accept="image/*" type='file' name="grpProfile"
                                                                       class="imgInp"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="social-theme-btn post-btn">Post
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="profile-name">
                            <h6><a href="#">{{$getGroupDetails->group_name}}</a></h6>
                            {{--                            <span class="locaiton">Washington</span>--}}
                            <p style="width: 60%; font-size: 12px; color: #091727;">{{!empty($getGroupDetails->group_details) && isset($getGroupDetails->group_details)?$getGroupDetails->group_details:'No Group Details'}}</p>

                        </div>
                    </div>
                    <ul class="profile-statistics">
                        <li><a href="#">
                                <p class="statics-count">{{!empty($getGroupDetails->userCount) && isset($getGroupDetails->userCount)?$getGroupDetails->userCount:'0'}}</p>
                                <p class="statics-name">Member</p>
                            </a></li>
                        <li><a href="#">
                                <p class="statics-count">{{!empty(countFollowing()[0]) && isset(countFollowing()[0])?countFollowing()[0]['userFollowings']:'0'}}</p>
                                <p class="statics-name">Following</p>
                            </a></li>
                        <li><a href="#">
                                <p class="statics-count">{{!empty(countFollowers()[0]) && isset(countFollowers()[0])?countFollowers()[0]['userFollowers']:'0'}}</p>
                                <p class="statics-name">Followers</p>
                            </a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
