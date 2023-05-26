@extends('community-frontend.layout.frontend_master')
@section('frontend.content')

    <!-- my profile start -->
    {{--    @dd($userDetails)--}}
    <div class="main-profile">
        <div class="row">
            <div class="col-lg-12">
                <div class="full-profile-box">

                    <div class="full-profile-cover">

                        @if(isset($userDetails->coverPicture))
                            <img
                                {{--                            src="{{asset("community-frontend/assets/images/community/myProfile/my-profile-cover.jpg")}}"--}}
                                src="{{asset("storage/community/cover-picture/".$userDetails->coverPicture)}}"
                                alt="cover">
                        @else
                            <img
                                {{--                            src="{{asset("community-frontend/assets/images/community/myProfile/my-profile-cover.jpg")}}"--}}
                                src="{{asset("community-frontend/assets/images/community/myProfile/my-profile-cover.jpg")}}"
                                alt="cover">
                        @endif

                    </div>

                    <div class="full-profile-info">
                        <div class="full-profile-left">
                            <div class="profile-img">

                                @if(isset($userDetails->coverPicture))
                                    <a href="#"><img
                                            src="{{asset("storage/community/profile-picture/".$userDetails->profilePicture)}}"
                                            alt="Image">
                                    </a>
                                @else
                                    <a href=""><img
                                            src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                            alt="image">
                                    </a>
                                @endif


{{--                                @dd($userDetails)--}}
                            </div>
                            <div class="profile-name">
                                <h6><a href="#">{{!empty($userDetails) && isset($userDetails)? $userDetails->name:'No Data Found'}}</a></h6>
                                <span
                                    class="locaiton">{{!empty($userDetails) && isset($userDetails)? $userDetails->birthplace:'No Data Found'}}</span>
                            </div>
                        </div>
                        <ul class="profile-statistics">
                            <li><a href="#">
                                    <p class="statics-count">0</p>
                                    <p class="statics-name">Likes</p>
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

                    <div class="profile-down-part">
                        <ul class="nav nav-tabs profile-dwon-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                        aria-selected="true">Timeline
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                        type="button" role="tab" aria-controls="profile" aria-selected="false">About
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                        type="button" role="tab" aria-controls="contact" aria-selected="false">Friends
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="photo-tab" data-bs-toggle="tab" data-bs-target="#forPhoto"
                                        type="button" role="tab" aria-controls="contact" aria-selected="false">Photo
                                </button>
                            </li>
                        </ul>
                        {{--                        @dd($userSocialLinks)--}}
                        <ul class="community-profile-social">
                            @if(isset($userSocialLinks['facebook']))
                                <li>
                                    <a href="{{$userSocialLinks['facebook']}}">
                                        <img
                                            src="{{asset("community-frontend/assets/images/community/myProfile/facebook.png")}}"
                                            alt="icon">
                                    </a>
                                </li>
                            @endif

                            @if(isset($userSocialLinks['twitter']))
                                <li>
                                    <a href="{{$userSocialLinks['twitter']}}"><img
                                            src="{{asset("community-frontend/assets/images/community/myProfile/twitter.png")}}"
                                            alt="icon">
                                    </a>
                                </li>
                            @endif

                            @if(isset($userSocialLinks['instagram']))
                                <li>
                                    <a href="{{$userSocialLinks['instagram']}}"><img
                                            src="{{asset("community-frontend/assets/images/community/myProfile/instagram.png")}}"
                                            alt="icon">
                                    </a>
                                </li>
                            @endif

                            @if(isset($userSocialLinks['linkedin']) )
                                <li>
                                    <a href="{{$userSocialLinks['linkedin']}}"><img
                                            src="{{asset("community-frontend/assets/images/community/myProfile/linkedin.png")}}"
                                            alt="icon">
                                    </a>
                                </li>
                            @endif

                            @if(isset($userSocialLinks['pinterest']) )
                                <li>
                                    <a href="{{$userSocialLinks['pinterest']}}">
                                        <img
                                            src="{{asset("community-frontend/assets/images/community/myProfile/pinterest.png")}}"
                                            alt="icon">
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- my profile end -->

    <!-- news feed content start  -->

    <div class="news-feed-content">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">

                    <div class="col-lg-3">
                        <div class="news-feed-left">
                            @include('community-frontend.layout.suggestedGroup')
                            @include('community-frontend.layout.pageLike')

                        </div>
                    </div>
                    <div class="col-lg-6">

{{--                        @dd($allMyPosts)--}}

                        @foreach($allMyPosts as $myPost)

                            {{--                            @dd($myPost)--}}
                            <div class="main-content posted-content">
                                <div class="post-autore d-flex justify-content-between align-items-center">
                                    <div class="authore-title d-flex align-items-center">
                                        <a href="#">
                                            @if(!empty($myPost->users->userProfileImages[0]) && isset($myPost->users->userProfileImages[0]) ? $myPost->users->userProfileImages[0]:'')
                                                <img
                                                    src="{{asset("storage/community/profile-picture/".$myPost->users->userProfileImages[0]->user_profile)}}"
                                                    alt="image">
                                            @else
                                                <img
                                                    src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                                    alt="image">
                                            @endif

                                        </a>
                                        <div class="athore-info">
                                            <p class="athore-name"><a href="#">{{Auth::user()->name}}</a></p>
                                            <p class="posted-time"><a
                                                    href="#">{{\Carbon\Carbon::parse(strtotime($myPost->created_at))->diffForHumans()}}</a>
                                            </p>
                                        </div>
                                    </div>
                                    @php
                                        $isOwner=\App\Models\Community\User\CommunityUserPost::select('id','user_id')->where('user_id','=',request()->segment(3))
                                       ->get();
                //                            dd($isOwner);
                                    @endphp


                                    <div class="post-option">

                                        @foreach($isOwner as $owner)
                                            @if($myPost->postId==$owner->id)
                                                <button type="button" class="dropdown-toggle" id="dropdownMenuButton1"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fa fa-ellipsis-h"
                                                        aria-hidden="true"></i>
                                                </button>

                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li>
                                                        <a href="#" data-mediaDetails="{{$myPost->userPostMedia}}"
                                                           data-postDetails="{{$myPost->postDescription}}"
                                                           data-postId="{{$myPost->postId}}"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#photoModal1"
                                                           class="post-option-item btnEdit"><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"></i> Edit Post
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('community.user.post.delete',$myPost->postId)}}"
                                                           data-id="{{$myPost->postId}}"
                                                           class="post-option-item dltPost"><i class="fa fa-trash-o"
                                                                                               aria-hidden="true"></i>
                                                            Delete Post</a>
                                                    </li>

                                                    @endif
                                                    @endforeach
                                                </ul>
                                    </div>
                                </div>
                                {{--                                @dd($myPost)--}}
                                <div class="post-body">
                                    <p class="post-status">{{$myPost->postDescription}}.</p>

                                    @php
                                        $extension=explode('.',$myPost->postMediaFile);
                                    @endphp
                                    {{--                    @dd($extension[1])--}}

                                    @if($myPost->postMediaFile)

                                        @if($extension[1]==='mp4'||$extension[1]==='mov'||$extension[1]==='wmv'||$extension[1]==='avi'||
                                        $extension[1]==='mkv'||$extension[1]==='webm')
                                            <div class="post-img">
                                                <video width="470" height="240" controls>
                                                    <source
                                                        src="{{asset("storage/community/post/videos/".$myPost->postMediaFile)}}"
                                                        type="video/mp4">
                                                </video>
                                            </div>
                                        @else
                                            <div class="post-img">
                                                <img src="{{asset("storage/community/post/".$myPost->postMediaFile)}}"
                                                     alt="">
                                            </div>
                                        @endif

                                    @endif

                                    <ul class="post-react-widget">
                                        <li class="post-react like-react">
                                            <a href="#">
                                                <div class="react-icon">

                                                    @if ($myPost->reaction_type=='like')
                                                        <img
                                                            src="{{asset("community-frontend/assets/images/community/home/news-post/react-1.png")}}"
                                                            alt="React">
                                                    @elseif($myPost->reaction_type=='love')
                                                        <img
                                                            src="{{asset("community-frontend/assets/images/community/home/news-post/react-2.png")}}"
                                                            alt="React">
                                                    @elseif($myPost->reaction_type=='haha')
                                                        <img
                                                            src="{{asset("community-frontend/assets/images/community/home/news-post/react-4.png")}}"
                                                            alt="React">
                                                    @elseif($myPost->reaction_type=='sad')
                                                        <img
                                                            src="{{asset("community-frontend/assets/images/community/home/news-post/react-6.png")}}"
                                                            alt="React">
                                                    @elseif($myPost->reaction_type=='angry')
                                                        <img
                                                            src="{{asset("community-frontend/assets/images/community/home/news-post/react-7.png")}}"
                                                            alt="React">
                                                    @elseif($myPost->reaction_type=='care')
                                                        <img
                                                            src="{{asset("community-frontend/assets/images/community/home/news-post/react-3.png")}}"
                                                            alt="React">
                                                    @elseif($myPost->reaction_type=='wow')
                                                        <img
                                                            src="{{asset("community-frontend/assets/images/community/home/news-post/react-5.png")}}"
                                                            alt="React">
                                                    @else
                                                        <img class="like"
                                                             src="{{asset("community-frontend/assets/images/community/home/news-post/like.png")}}"
                                                             alt="">
                                                    @endif

                                                </div>
                                                <span class="react-name">
                                                    @if($myPost->reaction_type=='like')
                                                        Like
                                                    @elseif($myPost->reaction_type=='love')
                                                        Love
                                                    @elseif($myPost->reaction_type=='care')
                                                        Care
                                                    @elseif($myPost->reaction_type=='haha')
                                                        Haha
                                                    @elseif($myPost->reaction_type=='wow')
                                                        Wow
                                                    @elseif($myPost->reaction_type=='sad')
                                                        Sad
                                                    @elseif($myPost->reaction_type=='angry')
                                                        Angry
                                                    @else
                                                        Like
                                                    @endif


                                                </span>
                                                <span
                                                    class="react-count reactionCount">{{myPostReactionCount($myPost->postId)}}</span>
                                            </a>
                                            <ul class="react-option">
                                                {{--                                                                                @dd($myPost)--}}

                                                <li class="reaction {{$myPost->reaction_type=='like'?'active':''}}"
                                                    data-reaction_type="like" data-pId="{{$myPost->postId}}"><img
                                                        src="{{asset("community-frontend/assets/images/community/home/news-post/react-1.png")}}"
                                                        alt="React">
                                                </li>
                                                <li class="reaction {{$myPost->reaction_type=='love'?'active':''}}"
                                                    data-reaction_type="love" data-pId="{{$myPost->postId}}"><img
                                                        src="{{asset("community-frontend/assets/images/community/home/news-post/react-2.png")}}"
                                                        alt="React">
                                                </li>
                                                <li class="reaction {{$myPost->reaction_type=='care'?'active':''}}"
                                                    data-reaction_type="care" data-pId="{{$myPost->postId}}"><img
                                                        src="{{asset("community-frontend/assets/images/community/home/news-post/react-3.png")}}"
                                                        alt="React"></li>
                                                <li class="reaction {{$myPost->reaction_type=='haha'?'active':''}}"
                                                    data-reaction_type="haha" data-pId="{{$myPost->postId}}"><img
                                                        src="{{asset("community-frontend/assets/images/community/home/news-post/react-4.png")}}"
                                                        alt="React"></li>
                                                <li class="reaction {{$myPost->reaction_type=='wow'?'active':''}}"
                                                    data-reaction_type="wow" data-pId="{{$myPost->postId}}"><img
                                                        src="{{asset("community-frontend/assets/images/community/home/news-post/react-5.png")}}"
                                                        alt="React"></li>
                                                <li class="reaction {{$myPost->reaction_type=='sad'?'active':''}}"
                                                    data-reaction_type="sad" data-pId="{{$myPost->postId}}"><img
                                                        src="{{asset("community-frontend/assets/images/community/home/news-post/react-6.png")}}"
                                                        alt="React"></li>
                                                <li class="reaction {{$myPost->reaction_type=='angry'?'active':''}}"
                                                    data-reaction_type="care" data-pId="{{$myPost->postId}}"><img
                                                        src="{{asset("community-frontend/assets/images/community/home/news-post/react-7.png")}}"
                                                        alt="React"></li>
                                            </ul>
                                        </li>
                                        <li class="post-react">
                                            <a href="#">
                                                <div class="react-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0"
                                                         viewBox="0 0 32 32" style="enable-background:new 0 0 512 512"
                                                         xml:space="preserve" class=""><g>
                                                            <g fill="#000">
                                                                <path
                                                                    d="M10 11a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM14 13a2 2 0 1 1 4 0 2 2 0 0 1-4 0zM22 11a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"
                                                                    fill="#000000" data-original="#000000"></path>
                                                                <path fill-rule="evenodd"
                                                                      d="M5 1a5 5 0 0 0-5 5v14a5 5 0 0 0 5 5h.012l.01 4.678a1 1 0 0 0 1.725.687L11.836 25H27a5 5 0 0 0 5-5V6a5 5 0 0 0-5-5zM2 6a3 3 0 0 1 3-3h22a3 3 0 0 1 3 3v14a3 3 0 0 1-3 3H11.406a1 1 0 0 0-.726.312l-3.664 3.862-.006-3.176a1 1 0 0 0-1-.998H5a3 3 0 0 1-3-3z"
                                                                      clip-rule="evenodd" fill="#000000"
                                                                      data-original="#000000"></path>
                                                            </g>
                                                        </g></svg>
                                                </div>
                                                <span class="react-name">Comment</span>
                                                <span
                                                    class="react-count commentCount">{{myPostCommentCount($myPost->postId)}}</span>
                                            </a>
                                        </li>


                                        <li class="post-react">
                                            <a href="#">
                                                <div class="react-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0"
                                                         viewBox="0 0 512 512.001"
                                                         style="enable-background:new 0 0 512 512"
                                                         xml:space="preserve" class=""><g>
                                                            <path
                                                                d="M361.824 344.395c-24.531 0-46.633 10.593-61.972 27.445l-137.973-85.453A83.321 83.321 0 0 0 167.605 256a83.29 83.29 0 0 0-5.726-30.387l137.973-85.457c15.34 16.852 37.441 27.45 61.972 27.45 46.211 0 83.805-37.594 83.805-83.805C445.629 37.59 408.035 0 361.824 0c-46.21 0-83.804 37.594-83.804 83.805a83.403 83.403 0 0 0 5.726 30.386l-137.969 85.454c-15.34-16.852-37.441-27.45-61.972-27.45C37.594 172.195 0 209.793 0 256c0 46.21 37.594 83.805 83.805 83.805 24.53 0 46.633-10.594 61.972-27.45l137.97 85.454a83.408 83.408 0 0 0-5.727 30.39c0 46.207 37.593 83.801 83.804 83.801s83.805-37.594 83.805-83.8c0-46.212-37.594-83.805-83.805-83.805zm-53.246-260.59c0-29.36 23.887-53.246 53.246-53.246s53.246 23.886 53.246 53.246c0 29.36-23.886 53.246-53.246 53.246s-53.246-23.887-53.246-53.246zM83.805 309.246c-29.364 0-53.25-23.887-53.25-53.246s23.886-53.246 53.25-53.246c29.36 0 53.242 23.887 53.242 53.246s-23.883 53.246-53.242 53.246zm224.773 118.95c0-29.36 23.887-53.247 53.246-53.247s53.246 23.887 53.246 53.246c0 29.36-23.886 53.246-53.246 53.246s-53.246-23.886-53.246-53.246zm0 0"
                                                                fill="#000000" data-original="#000000"></path>
                                                        </g></svg>
                                                </div>
                                                <span class="react-name">share</span>
                                                <span class="react-count">0</span>
                                            </a>
                                        </li>
                                    </ul>

                                    {{--                                    @dd($myPost)--}}
                                    <ul class="post-comment-list">

                                        @php
                                            $cmtIdArray=[];
                                            foreach ($myPost->newsFeedComments as $cId){
                                                $cmtIdArray[]=$cId->id;
                                            }
                                        @endphp
                                        @foreach($myPost->newsFeedComments as $postComment)

                                            <li class="single-comment post-Comment-{{$postComment->id}}">
                                                <div class="parent-comment">
                                                    <div class="comment-img">
                                                        @if(!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0])?$postComment->users->userProfileImages[0]:'')

                                                            @if(!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0])?$postComment->users->userProfileImages[0]:'')
                                                                <a href=""><img
                                                                        src="{{asset("storage/community/profile-picture/".$postComment->users->userProfileImages[0]->user_profile)}}"
                                                                        alt="image"></a>
                                                            @else
                                                                <a href=""><img
                                                                        src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                                                        alt="image">
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div class="comment-details">
                                                        <div class="coment-info">
                                                            <div class="coment-authore-div">
                                                                <h6><a href="#">{{$postComment->users->name}}</a></h6>
                                                                <span
                                                                    class="comment-time">{{\Carbon\Carbon::parse($postComment->created_at)->diffForHumans()}}</span>
                                                            </div>

                                                            @if($postComment->user_id === request()->segment(3))
                                                                <div class="comment-option">
                                                                    <button type="button"
                                                                            class="dropdown-toggle comment-option-btn"
                                                                            id="dropdownMenuButton1"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-expanded="false"><i
                                                                            class="fa fa-ellipsis-h"
                                                                            aria-hidden="true"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu comment-option-dropdown"
                                                                        aria-labelledby="dropdownMenuButton1" style="">
                                                                        <li class="post-option-item" id="editComment">
                                                                            <i class="fa fa-pencil-square-o"
                                                                               aria-hidden="true"></i>
                                                                            Edit Comment
                                                                        </li>
                                                                        <li class="post-option-item dltComment"
                                                                            data-commentId="{{$postComment->id}}">
                                                                            <i class="fa fa-trash-o"
                                                                               aria-hidden="true"></i>
                                                                            Delete comment
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                            @else
                                                                <div class="comment-option">
                                                                    <button type="button"
                                                                            class="dropdown-toggle comment-option-btn"
                                                                            id="dropdownMenuButton1"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-expanded="false"><i
                                                                            class="fa fa-ellipsis-h"
                                                                            aria-hidden="true"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu comment-option-dropdown"
                                                                        aria-labelledby="dropdownMenuButton1" style="">
                                                                        <li class="post-option-item dltComment"
                                                                            data-commentId="{{$postComment->id}}">
                                                                            <i class="fa fa-trash-o"
                                                                               aria-hidden="true"></i>
                                                                            Delete comment
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                            @endif


                                                        </div>

                                                        <div class="comment-div">
                                                            <p class="comment-content">{{$postComment->comment_text}}</p>

                                                            <button class="textarea-btn" type="submit"
                                                                    style="display: none;">
                                                                <i class="fa fa-paper-plane"
                                                                   data-commentText="{{$postComment->comment_text}}"
                                                                   data-cmtId="{{$postComment->id}}"
                                                                   data-postId="{{$postComment->user_post_id}}"

                                                                   aria-hidden="true"></i>
                                                            </button>
                                                            <button class="textarea-cancel-btn" style="display: none;">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                        <ul class="coment-react">
                                                            <li class="comment-like"><a href="#">Like(0)</a></li>
                                                            <li><a href="javascript:void(0)"
                                                                   class="replay-tag">Replay</a></li>
                                                        </ul>
                                                    </div>

                                                    <!-- child comment start  -->
                                                    <div class="child-comment">

                                                        <div
                                                            class="single-replay-comnt nested-comment-{{$postComment->id}}">


                                                        </div>


                                                        @if( count($postComment->replies)>0)
                                                            <div class="more-comment mt-2">
                                                                <a class="loadChildCmt"
                                                                   data-postIdd="{{$myPost->postId}}"
                                                                   data-commentId="{{$postComment->id}}">
                                                                                           <span class="replay-arrow">
                                                                                            <svg x="0" y="0"
                                                                                                 viewBox="0 0 48 48"
                                                                                                 style="enable-background:new 0 0 512 512"
                                                                                                 xml:space="preserve"
                                                                                                 class=""><g><path
                                                                                                        d="m47.12 31.403-9.992-9.992a2.98 2.98 0 1 0-4.215 4.216l3.037 3.037C15.565 29.665 2.31 15.984 2.188 1.96c-.004-.507-.716-.61-.874-.144-4.922 14.579 4.03 32.89 27.427 36.201 2.266.295 4.558.519 6.868.681l-2.697 2.697a2.98 2.98 0 1 0 4.215 4.215l9.992-9.992a2.98 2.98 0 0 0 .001-4.215z"
                                                                                                        data-original="#ffcc66"
                                                                                                        class=""></path></g></svg>
                                                                                            </span> Replay <span
                                                                        class="count">({{count($postComment->replies)}})</span></a>
                                                            </div>
                                                        @endif

                                                        <div class="new-comment replay-new-comment">


                                                            @if(!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0])?$postComment->users->userProfileImages[0]:'')

                                                                @if(!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0])?$postComment->users->userProfileImages[0]:'')
                                                                    <a href=""
                                                                       class="new-comment-img replay-comment-img"><img
                                                                            src="{{asset("storage/community/profile-picture/".$postComment->users->userProfileImages[0]->user_profile)}}"
                                                                            alt="image"></a>
                                                                @else
                                                                    <a href=""><img
                                                                            src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                                                            alt="image">
                                                                    </a>
                                                                @endif
                                                            @endif
                                                            <div class="new-comment-input replay-commnt-input">
                                                                <input data-cmtId="{{$postComment->id}}" class="cmtText"
                                                                       type="text"
                                                                       name="cmttext"
                                                                       data-userPostId="{{$postComment->user_post_id}}"
                                                                       placeholder="Write a comment....">
                                                                <div class="attached-icon">
                                                                    <a href="#"><i class="fa fa-camera"
                                                                                   aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                        @endforeach


                                    </ul>

                                    @if(count($myPost->newsFeedComments)>0)
                                        <div class="more-comment">
                                            <a class="checkCmt justify-content-center"
                                               data-postIdd="{{$myPost->postId}}"
                                               data-commentid="{{json_encode($cmtIdArray)}}">More Comments+</a>
                                        </div>
                                    @endif

                                    <div class="new-comment">

                                        <a href="#" class="new-comment-img">
                                            @if(!empty($myPost->users->userProfileImages[0]) && isset($myPost->users->userProfileImages[0]) ? $myPost->users->userProfileImages[0]:'')
                                                <img
                                                    src="{{asset("storage/community/profile-picture/".$myPost->users->userProfileImages[0]->user_profile)}}"
                                                    alt="image" style="height: 60px; width: 60px">
                                            @else
                                                <img
                                                    src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                                    alt="image">
                                            @endif
                                        </a>

                                        <div class="new-comment-input">
                                            <input type="text" data-postId="{{$myPost->postId}}" class="postComments"
                                                   placeholder="Write a comment....">
                                            <div class="attached-icon">
                                                <a href="#"><i class="fa fa-camera" aria-hidden="true"></i></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach


                        {{--                        @dd(myPostReactionCount())--}}

                        @if(count($allMyPosts)>0)
                            <div class="load-more mb-30">
                                <a href="#">
                                    <span class="loading-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0"
                                             viewBox="0 0 24 24" style="enable-background:new 0 0 512 512"
                                             xml:space="preserve" class=""><g><path
                                                    d="M22 11a1 1 0 0 0-1 1 9 9 0 1 1-9-9 8.9 8.9 0 0 1 4.42 1.166l-1.127 1.127A1 1 0 0 0 16 7h4a1 1 0 0 0 1-1V2a1 1 0 0 0-1.707-.707L17.882 2.7A10.9 10.9 0 0 0 12 1a11 11 0 1 0 11 11 1 1 0 0 0-1-1z"
                                                    fill="#000000" data-original="#000000" class=""></path></g></svg>
                                    </span>
                                    Load more Posts
                                </a>
                            </div>

                        @else

                            <div class="load-more mb-30">
                                <a href="#">
                                    No Post Available
                                </a>
                            </div>
                        @endif


                    </div>


                    <div class="col-lg-3">
                        <div class="news-feed-right">
                            @include('community-frontend.layout.weather')

                            @include('community-frontend.layout.birthday')

                            @php
                            $id=\request()->segment(3);
//                            dd($id)
                            @endphp
                            @include('community-frontend.layout.followers',['user_id'=>$id])


                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row">
                    <div class="col-lg-3 col-12">
                        <div class="main-content posted-content">
                            <div
                                class="post-autore profile-about-left d-flex justify-content-between align-items-center">
                                <p class="about-left-title">Personal Information</p>

                            </div>
{{--                                                                                @dd($userDetails)--}}
                            <ul class="profile-personal-information">
                                <li><span>Email:</span><a href="#">{{$userDetails->email}}</a></li>
                                <li>
                                    <span>Birthday:</span>{{!empty($userDetails) && isset($userDetails)?\Carbon\Carbon::parse($userDetails->dob)->format('M d, Y'):'No Data Found'}}
                                    {{--                                <li><span>Birthday:</span>{{  \Carbon\Carbon::parse($userDetails->dob)->format('M d, Y')}}--}}
                                </li>
                                <li>
                                    <span>Occupation:</span>{{!empty($userDetails) && isset($userDetails)? $userDetails->designation:'No Data Found'}}
                                </li>
                                <li>
                                    <span>Birthplace:</span> {{!empty($userDetails) && isset($userDetails)? $userDetails->birthplace:'No Data Found'}}
                                </li>
                                <li><span>Phone:</span><a
                                        href="#">{{!empty($userDetails) && isset($userDetails)? $userDetails->phone:'No Data Found'}}</a>
                                </li>
                                {{--                                <li><span>Phone:</span><a href="#">{{$userDetails->phone}}</a></li>--}}
                                <li><span>Gender:</span><a
                                        href="#">{{!empty($userDetails) && isset($userDetails)? $userDetails->gender:'No Data Found'}}</a>
                                </li>
                                {{--                                <li><span>Gender:</span><a href="#">{{$userDetails->gender}}</a></li>--}}
                                <li><span>Relationship Status:</span><a
                                        href="#">{{!empty($userDetails) && isset($userDetails)? $userDetails->relationship:'No Data Found'}}</a>
                                </li>
                                {{--                                <li><span>Relationship Status:</span><a href="#">{{$userDetails->relationship}}</a></li>--}}
                                <li><span>Blood Group:</span><a
                                        href="#">{{!empty($userDetails) && isset($userDetails)? ($userDetails->blood.' Positive'):'No Data Found'}}</a>
                                </li>
                                {{--                                <li><span>Blood Group:</span><a href="#">{{$userDetails->blood}} Positive</a></li>--}}
                                <li><span>Website:</span><a href="#"><a
                                            href="#">{{!empty($userDetails) && isset($userDetails)? $userDetails->website:'No Data Found'}}</a></a>
                                </li>
                                {{--                                <li><span>Website:</span><a href="#"><a href="#">{{$userDetails->website}}</a></a></li>--}}
                                <li><span>Languages:</span>
                                    <a href="#">
                                        @if(count($allUserLanguage)>0)
                                            @foreach($allUserLanguage as $language)
                                                <a href="#">
                                                    {{$language->language_name}}&nbsp;,
                                                </a>
                                            @endforeach
                                        @else
                                            <a href="#">
                                                No Language Found
                                            </a>
                                        @endif


                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9 col-12">
                        <div class="main-content posted-content">
                            <div
                                class="post-autore profile-about-left d-flex justify-content-between align-items-center">
                                <p class="about-left-title">About Me!</p>
                                <div class="post-option">
                                    <button type="button" class="dropdown-toggle" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"
                                                                                               aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a href="{{route('user.my-profile.setting')}}" class="post-option-item"><i
                                                    class="fa fa-pencil-square-o"
                                                    aria-hidden="true"></i> Edit
                                                Post</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="community-aboutMe-content">
                                <p>
                                    {{!empty($userDetails) && isset($userDetails)?$userDetails->about_me:'No Data Found'}}
                                </p>

                            </div>
                        </div>
                        <div class="main-content posted-content">
                            <div
                                class="post-autore profile-about-left d-flex justify-content-between align-items-center">
                                <p class="about-left-title">Education</p>

                            </div>
                            {{--                            @dd($userEducationDetails)--}}
                            <div class="education-work-list">

                                @foreach($userEducationDetails as $education)

                                    <div class="single-education">

                                        <div class="post-option" style="float: right;">
                                            <h4>
                                                <a href="{{route('user.my-profile.profile.edit.education',$education->id)}}"><i
                                                        class="fa fa-pencil-square"></i></a>
                                            </h4>
                                        </div>

                                        <h6 class="education-title">{{$education->degree_name}} <span>({{\Carbon\Carbon::parse($education->starting_date)->format('Y')}} - {{$education->is_present===1?'Present':\Carbon\Carbon::parse($education->ending_date)->format('Y')}})</span>
                                        </h6>
                                        <p class="education-sub-title">{{$education->institute}}</p>
                                        <p class="details">{!! $education->description !!}</p>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        <div class="main-content posted-content">
                            <div
                                class="post-autore profile-about-left d-flex justify-content-between align-items-center">
                                <p class="about-left-title">Work</p>

                            </div>
                            <div class="education-work-list">

                                @foreach($userWorkDetails as $work)

                                    <div class="single-education">

                                        <div class="post-option" style="float: right;">
                                            <h4>
                                                <a href="{{route('user.my-profile.edit.profile.work',$work->id)}}"><i
                                                        class="fa fa-pencil-square"></i></a>
                                            </h4>
                                        </div>

                                        <h6 class="education-title">{{$work->designation}} <span>({{\Carbon\Carbon::parse($work->starting_date)->format('Y')}} - {{$work->is_present===1?'Present':\Carbon\Carbon::parse($work->ending_date)->format('Y')}})</span>
                                        </h6>
                                        <p class="education-sub-title">{{$work->institute}}</p>
                                        <p class="details">{!! $work->description !!}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="main-content posted-content">
                            <div
                                class="post-autore profile-about-left d-flex justify-content-between align-items-center">
                                <p class="about-left-title">Interest</p>
                            </div>

                            <div class="education-work-list">

                                @foreach($userInterest as $interest)
                                    <div class="single-education">
                                        <h6 class="education-title">
                                            @if($interest->interest_name==='hobby')
                                                Hobby
                                            @elseif($interest->interest_name==='fav_book')
                                                Favourite Book
                                            @elseif($interest->interest_name==='other_interest')
                                                Other Interest
                                            @endif

                                            :</h6>
                                        <p class="details">{{$interest->interest_details}}</p>
                                    </div>

                                @endforeach


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="friends-tab-wrap">
                            <div class="friends-title">
                                <div class="friends-count">
                                    <p>Friends</p>

                                    <span>{{$countFriends}}</span>
                                </div>
                                <div class="friend-status">
                                    <ul class="nav nav-tabs status-tab" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="allFriendTab" data-bs-toggle="tab"
                                                    data-bs-target="#profileFriend" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true">All Friend
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="recentlyAddedTab" data-bs-toggle="tab"
                                                    data-bs-target="#recentlyAdded" type="button" role="tab"
                                                    aria-controls="profile" aria-selected="false">Recently Added
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
                    </div>
                </div>
                <div class="row">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="profileFriend" role="tabpanel"
                             aria-labelledby="allFriendTab">
                            <div class="profile-friend-list">
                                <div class="row">
{{--                                    @dd($myFriends)--}}

                                    @foreach($myFriends as $friend)
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="single-profile-list">
                                                <div class="view-profile left-widget">
                                                    <div class="profile-cover">


                                                        @if(!empty($friend->userCoverImages[0]) && isset($friend->userCoverImages[0])?$friend->userCoverImages [0]:'')

                                                            @if(!empty($friend->userCoverImages[0]) && isset($friend->userCoverImages[0])?$friend->userCoverImages [0]:'')
                                                                <a href="{{route('user.profile',\Illuminate\Support\Facades\Crypt::encrypt($friend->id))}}"><img
                                                                        src="{{asset("storage/community/profile-picture/".$friend->userCoverImages[0]->user_cover)}}"
                                                                        alt="image"></a>
                                                            @else
                                                                <a href="{{route('user.profile',\Illuminate\Support\Facades\Crypt::encrypt($friend->id))}}"><img
                                                                        src="{{asset("community-frontend/assets/images/community/home/smallCover.jpg")}}"
                                                                        alt="image"></a>
                                                            @endif
                                                        @else

                                                            <a href="{{route('user.profile',\Illuminate\Support\Facades\Crypt::encrypt($friend->id))}}"><img
                                                                    src="{{asset("community-frontend/assets/images/community/home/smallCover.jpg")}}"
                                                                    alt="image"></a>
                                                        @endif



{{--                                                        <a href="{{route('user.profile',\Illuminate\Support\Facades\Crypt::encrypt($friend->uId))}}"><img--}}
{{--                                                                src="{{asset("community-frontend/assets/images/community/home/smallCover.jpg")}}"--}}
{{--                                                                alt="cover"></a>--}}
                                                        <div class="add-friend-icon">
                                                            <a href="{{route('user.profile',\Illuminate\Support\Facades\Crypt::encrypt($friend->id))}}"><i class="fa fa-user-o" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="profile-title d-flex align-items-center">



                                                        @if(!empty($friend->userProfileImages[0]) && isset($friend->userProfileImages[0])?$friend->userProfileImages[0]:'')

                                                            @if(!empty($friend->userProfileImages[0]) && isset($friend->userProfileImages[0])?$friend->userProfileImages[0]:'')
                                                                <a href="{{route('user.profile',\Illuminate\Support\Facades\Crypt::encrypt($friend->id))}}"><img
                                                                        src="{{asset("storage/community/profile-picture/".$friend->userProfileImages[0]->user_profile)}}"
                                                                        alt="image"></a>
                                                            @else
                                                                <a href="{{route('user.profile',\Illuminate\Support\Facades\Crypt::encrypt($friend->id))}}"><img
                                                                        src="{{asset("community-frontend/assets/images/community/home/user-0.jpg")}}"
                                                                        alt="image"></a>
                                                            @endif
                                                        @else

                                                            <a href="{{route('user.profile',\Illuminate\Support\Facades\Crypt::encrypt($friend->id))}}"><img
                                                                    src="{{asset("community-frontend/assets/images/community/home/user-0.jpg")}}"
                                                                    alt="image"></a>
                                                        @endif


{{--                                                        <a href="{{route('user.profile',\Illuminate\Support\Facades\Crypt::encrypt($friend->uId))}}">--}}
{{--                                                            <img--}}
{{--                                                                src="{{asset("community-frontend/assets/images/community/home/user-0.jpg")}}"--}}
{{--                                                                alt=""></a>--}}



                                                        <div class="profile-name">
                                                            <h6><a href="{{route('user.profile',\Illuminate\Support\Facades\Crypt::encrypt($friend->id))}}">{{$friend->userName}}</a></h6>
                                                            <span class="locaiton">

                                                                @if($friend->birthplace===null)
                                                                    No Data Found
                                                                @else
                                                                    {{ $friend->birthplace}}
                                                                @endif

                                                            </span>
                                                        </div>
                                                    </div>
                                                    <ul class="profile-statistics">
                                                        <li><a href="#">
                                                                <p class="statics-count">0</p>
                                                                <p class="statics-name">Likes</p>
                                                            </a></li>
                                                        <li><a href="#">
                                                                <p class="statics-count">{{$friend->userFollowings}}</p>
                                                                <p class="statics-name">Following</p>
                                                            </a></li>
                                                        <li><a href="#">
                                                                <p class="statics-count">{{$friend->userFollowers}}</p>
                                                                <p class="statics-name">Followers</p>
                                                            </a></li>
                                                    </ul>
                                                    <ul class="add-msg-btn">
                                                        <li>
                                                            <button type="button" class="add-btn">Add Friend</button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="msg-btn">Send Message</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach

                                </div>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="recentlyAdded" role="tabpanel"
                             aria-labelledby="recentlyAddedTab">
                            <div class="profile-friend-list">
                                <div class="row">

{{--                                    @dd($recentlyAddedFriends)--}}

                                    @foreach($recentlyAddedFriends as $friend)
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="single-profile-list">
                                                <div class="view-profile left-widget">
                                                    <div class="profile-cover">
                                                        @if(!empty($friend->userCoverImages[0]) && isset($friend->userCoverImages[0])?$friend->userCoverImages [0]:'')

                                                            @if(!empty($friend->userCoverImages[0]) && isset($friend->userCoverImages[0])?$friend->userCoverImages [0]:'')
                                                                <a href={{route('user.profile',\Illuminate\Support\Facades\Crypt::encrypt($friend->uId))}}><img
                                                                        src="{{asset("storage/community/profile-picture/".$friend->userCoverImages[0]->user_cover)}}"
                                                                        alt="image"></a>
                                                            @else
                                                                <a href={{route('user.profile',\Illuminate\Support\Facades\Crypt::encrypt($friend->uId))}}><img
                                                                        src="{{asset("community-frontend/assets/images/community/home/smallCover.jpg")}}"
                                                                        alt="image"></a>
                                                            @endif
                                                        @else

                                                            <a href={{route('user.profile',\Illuminate\Support\Facades\Crypt::encrypt($friend->uId))}}><img
                                                                    src="{{asset("community-frontend/assets/images/community/home/smallCover.jpg")}}"
                                                                    alt="image"></a>
                                                        @endif
                                                        <div class="add-friend-icon">
                                                            <a href="{{route('user.profile',\Illuminate\Support\Facades\Crypt::encrypt($friend->uId))}}"><i class="fa fa-user-o" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="profile-title d-flex align-items-center">
                                                        {{--                                                        <a href="#">--}}
                                                        @if(!empty($friend->userProfileImages[0]) && isset($friend->userProfileImages[0])?$friend->userProfileImages[0]:'')

                                                            @if(!empty($friend->userProfileImages[0]) && isset($friend->userProfileImages[0])?$friend->userProfileImages[0]:'')
                                                                <a href=""><img
                                                                        src="{{asset("storage/community/profile-picture/".$friend->userProfileImages[0]->user_profile)}}"
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
                                                        {{--                                                        </a>--}}
                                                        <div class="profile-name">
                                                            <h6><a href="#">{{$friend->userName}}</a></h6>
                                                            <span class="locaiton">

                                                                @if($friend->birthplace===null)
                                                                    No Data Found
                                                                @else
                                                                    {{$friend->birthplace}}
                                                                @endif

                                                            </span>
                                                        </div>
                                                    </div>
                                                    <ul class="profile-statistics">
                                                        <li><a href="#">
                                                                <p class="statics-count">0</p>
                                                                <p class="statics-name">Likes</p>
                                                            </a></li>
                                                        <li><a href="#">
                                                                <p class="statics-count">{{$friend->userFollowings}}</p>
                                                                <p class="statics-name">Following</p>
                                                            </a></li>
                                                        <li><a href="#">
                                                                <p class="statics-count">{{$friend->userFollowers}}</p>
                                                                <p class="statics-name">Followers</p>
                                                            </a></li>
                                                    </ul>
                                                    <ul class="add-msg-btn">
                                                        <li>
                                                            <button type="button" class="add-btn">Add Friend</button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="msg-btn">Send Message</button>
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
            </div>

            <div class="tab-pane fade" id="forPhoto" role="tabpanel" aria-labelledby="photo-tab">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="friends-tab-wrap">
                            <div class="friends-title">
                                <div class="friends-count">
                                    <p>Photos</p>
                                    <span>{{count( $imgArray)}}</span>
                                </div>
                                <div class="friend-status">
                                    <ul class="nav nav-tabs status-tab" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="allPhotoTab" data-bs-toggle="tab"
                                                    data-bs-target="#allPhoto" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true">All Photos
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="gallaryPhotoTab" data-bs-toggle="tab"
                                                    data-bs-target="#gallaryPhoto" type="button" role="tab"
                                                    aria-controls="profile" aria-selected="false">Photos Albums
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="search_box">
                                    <form>
                                        <input type="text" id="inputSearch" placeholder="Search Photos..">
                                        <button type="submit" id="inputSearchBtn"><i class="fa fa-search"
                                                                                     aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="allPhoto" role="tabpanel"
                             aria-labelledby="allPhotoTab">
                            <div class="profile-friend-list">
                                <div class="row">

                                    {{--                                    @dd(userAllPhoto())--}}

                                    @foreach($imgArray as $photo)
                                        {{--                                        @dd($photo)--}}
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <div class="single-gallary-photo">
                                                <a href="#">
                                                    <img src="{{asset('storage/community/post/'.$photo)}}"
                                                         alt="image">
                                                </a>
                                                <ul class="icon-list">
                                                    <li>
                                                        <a href="#">
                                                                <span class="icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         version="1.1" x="0" y="0" viewBox="0 0 512 512"
                                                                         style="enable-background:new 0 0 512 512"
                                                                         xml:space="preserve" class=""><g><path
                                                                                d="M407.672 280.596c-21.691-15.587-45.306-27.584-70.182-35.778C370.565 219.986 392 180.449 392 136 392 61.01 330.991 0 256 0S120 61.01 120 136c0 44.504 21.488 84.084 54.633 108.911-30.368 9.998-58.863 25.555-83.803 46.069-45.732 37.617-77.529 90.086-89.532 147.743-3.762 18.066.745 36.622 12.363 50.908C25.222 503.847 42.365 512 60.693 512H267c11.046 0 20-8.954 20-20s-8.954-20-20-20H60.693c-8.538 0-13.689-4.766-15.999-7.606-3.989-4.905-5.533-11.29-4.236-17.519 20.756-99.695 108.691-172.521 210.24-174.977a137.229 137.229 0 0 0 10.643-.002c44.466 1.052 86.883 15.236 122.988 41.182 8.969 6.446 21.467 4.399 27.913-4.569 6.446-8.97 4.4-21.467-4.57-27.913zm-146.803-48.718a263.128 263.128 0 0 0-9.709.001C200.465 229.35 160 187.312 160 136c0-52.935 43.065-96 96-96s96 43.065 96 96c0 51.302-40.45 93.334-91.131 95.878z"
                                                                                fill="#000000"
                                                                                data-original="#000000"></path><path
                                                                                d="m455.285 427 50.857-50.857c7.811-7.811 7.811-20.475 0-28.285-7.811-7.811-20.474-7.811-28.284 0L427 398.715l-50.858-50.858c-7.811-7.811-20.474-7.811-28.284 0-7.81 7.811-7.811 20.475 0 28.285L398.715 427l-50.857 50.857c-7.811 7.811-7.811 20.475 0 28.285A19.933 19.933 0 0 0 362 512a19.936 19.936 0 0 0 14.142-5.857L427 455.285l50.858 50.858A19.936 19.936 0 0 0 492 512a19.936 19.936 0 0 0 14.142-5.857c7.811-7.811 7.811-20.475 0-28.285L455.285 427z"
                                                                                fill="#000000"
                                                                                data-original="#000000"></path></g></svg>
                                                                </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                                <span class="icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         version="1.1" x="0" y="0" viewBox="0 0 32 32"
                                                                         style="enable-background:new 0 0 512 512"
                                                                         xml:space="preserve"><g><path
                                                                                d="M28 24v-4a1 1 0 0 0-2 0v4a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-4a1 1 0 0 0-2 0v4a3 3 0 0 0 3 3h18a3 3 0 0 0 3-3zm-6.38-5.22-5 4a1 1 0 0 1-1.24 0l-5-4a1 1 0 0 1 1.24-1.56l3.38 2.7V6a1 1 0 0 1 2 0v13.92l3.38-2.7a1 1 0 1 1 1.24 1.56z"
                                                                                data-name="Download" fill="#000000"
                                                                                data-original="#000000"></path></g></svg>
                                                                </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="gallaryPhoto" role="tabpanel" aria-labelledby="gallaryPhotoTab">
                            <div class="profile-friend-list">
                                <div class="profile-friend-list">
                                    {{--                                                                                                            @dd(userPhotoAlbum())--}}
                                    <div class="row">

                                        @foreach($userPhotoAlbum as $key=> $album)
                                            {{--                                                                                        @dd($key)--}}
                                            <div class="col-lg-3 col-md-6 col-12 {{$key}}">
                                                <div class="single-profile-list single-group-list">
                                                    <div class="view-profile left-widget">
                                                        <div class="profile-cover">
                                                            <a href="#"><img
                                                                    src="http://127.0.0.1:8000/community-frontend/assets/images/community/home/smallCover.jpg"
                                                                    alt="cover"></a>
                                                        </div>
                                                        <a href="javascript:void(0)"
                                                           style="text-decoration: none;color: inherit;">

                                                            <div class="profile-title d-flex align-items-center">
                                                                @if(!empty($post->users->userProfileImages[0]) && isset($post->users->userProfileImages[0])?$post->users->userProfileImages[0]:'')
                                                                    <img
                                                                        src="{{asset("storage/community/profile-picture/".$post->users->userProfileImages[0]->user_profile)}}"
                                                                        alt="image">
                                                                @else
                                                                    <img
                                                                        src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                                                        alt="image">
                                                                @endif
                                                                <div class="profile-name">
                                                                    @if($key==='img')
                                                                        <h6>Uploaded Images</h6>
                                                                    @elseif($key==='pp')
                                                                        <h6>Profile Pictures</h6>
                                                                    @elseif($key==='pc')
                                                                        <h6> Cover Pictures</h6>

                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </a>

                                                        <ul class="add-msg-btn join-group mt-5">

                                                            <li>
                                                                <button class="add-btn showImg attachment-option-btn"
                                                                        data-key="{{$key}}" data-bs-toggle="modal"
                                                                        data-bs-target="#photoModal1">
                                                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                                                </button>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        {{-- Modal Album --}}

                                        <div class="modal fade" id="photoModal1" tabindex="-1"
                                             aria-labelledby="photoModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content post-modal-content">
                                                    <div class="modal-header">
                                                        <div class="post-modal-title">
                                                            <h6 class="modal-title" id="photoModalLabel">Album</h6>
                                                        </div>
                                                        <button type="button" class=" post-close"
                                                                data-bs-dismiss="modal"
                                                                aria-label="Close"><i class="fa fa-times"
                                                                                      aria-hidden="true"></i>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body post-modal-body">

                                                        <div class="row appendImage">

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- news feeds content start  -->
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {

        $('.reaction').on('click', function () {

            $('.reaction').removeClass('active');
            $(this).addClass('active');

            let postReaction = $(this).attr('data-reaction_type');
            let postId = $(this).attr('data-pId');
            // console.log(postId);
            // console.log(postReaction);
            let reactionCount = parseInt($(this).parents('.post-body').find('.reactionCount').text());
            let newReactionCount = $(this).parents('.post-body').find('.reactionCount');

            let img_src = $(this).find('img').attr('src')
            $(this).parents('.like-react').find('.react-icon img').attr('src', img_src)

            // console.log(parests_data, 'parests_data')
            // let img_src = $(this).find('img').attr('src');
            // console.log(img_src,'img_src');
            // return false;

            if (postReaction !== '' && postId !== '') {
                $.ajax({
                    url: '{{route('user.post-all.reaction')}}',
                    type: 'POST',
                    data: {
                        postReaction: postReaction,
                        postId: postId,
                        reqType: 'storePostReaction',
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (response) {

                        if (response.success === true) {
                            // console.log(response);
                            // console.log(response.data);
                            newReactionCount.text(reactionCount += 1);

                            // toastr.success(response.msg);
                            // console.log(response.postComments);

                        } else {
                            // toastr.error(response.msg);
                        }
                    },
                    error: function (err) {

                        toastr.error("Error with AJAX callback !");
                    }
                })
            }
        })


        $('.postComments').keydown(function (e) {

            if (e.keyCode === 13) {

                let htmlData = $(this).parents('.posted-content').find('.post-comment-list')
                let comment = e.target.value;
                let postId = $(this).attr('data-postId');

                let commentCount = parseInt($(this).parents('.post-body').find('.commentCount').text());
                let new_comment = $(this).parents('.post-body').find('.commentCount');
                $(this).val('');
                // console.log($(this));
                // return false;

                // console.log(comment,postId);
                if (comment !== '' && postId !== '') {
                    $.ajax({
                        url: '{{route('community.user.post.comment')}}',
                        type: 'POST',
                        data: {
                            postId: postId,
                            postComment: comment,
                            '_token': '{{csrf_token()}}'
                        },
                        success: function (response) {
                            // console.log(response);

                            if (response.success === true) {
                                toastr.success(response.msg);
                                htmlData.append(response.html);
                                new_comment.text(commentCount += 1)

                                // console.log($(this),'this')
                                // $(this).val('');
                                // console.log(response.data);

                            } else {
                                // toastr.error(response.msg);
                            }
                        },
                        error: function (err) {

                            // toastr.error("Error with AJAX callback !");
                        }
                    })
                }
            }
        })

        $(document).on('click', '.loadChildCmt', function () {
            let postId = $(this).attr('data-postIdd');
            let cmtId = $(this).attr('data-commentId');
            $(this).hide();
            // console.log(postId);
            let htmlData = $(this).parents('.posted-content').find('.post-comment-list')
            $.ajax({
                url: "{{route('user.load.child.comment')}}",
                post: "GET",
                data: {
                    postId: postId,
                    cmtId: cmtId,
                },
                success: function (response) {

                    if (response.status === true) {

                        // console.log(response.html,'cmt');
                        $('.cmtText').val('');
                        $(document).find('.nested-comment-' + cmtId).append(response.html);

                    }


                },
            })
        })

        $(document).on('click', '.checkCmt', function () {
            let pPostId = $(this).attr('data-postIdd')
            let commentId = $(this).attr('data-commentId')

            $(this).hide();
            let htmlData = $(this).parents('.posted-content').find('.post-comment-list')
            console.log(pPostId);
            $.ajax({
                url: '{{route('users.get-all-comments')}}',
                type: 'GET',
                data: {
                    pPostId: pPostId,
                    commentId: commentId,
                    reqTyp: 'userAllCmt'
                },
                success: function (response) {

                    if (response.status === true) {

                        // console.log(response.html, 'cmt');
                        // $('.postComments').val('');
                        htmlData.append(response.html);
                    }


                },
            })
        })

        $(document).keypress('.cmtText', function (e) {
            let cmtId = e.target.dataset.cmtid;
            let user_post_id = e.target.dataset.userpostid;
            let cmtText = e.target.value;
            let key = e.which;
            // $(this).hide();
            // console.log(user_post_id);
            // return false;
            if (key === 13) {
                // console.log(cmtText);

                $.ajax({
                    url: "{{route('community.user.post.child.comment')}}",
                    type: 'POST',
                    data: {
                        cmtId: cmtId,
                        cmtText: cmtText,
                        user_post_id: user_post_id,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (response) {
                        // console.log(response);

                        if (response.status === true) {
                            $('.cmtText').val('');
                            $('.nested-comment-' + cmtId).append(response.data);
                        } else {
                            toastr.error(response.msg);
                        }
                    },
                    error: function (err) {

                        // toastr.error("Error with AJAX callback !");
                    }
                })
            }


        })

        $(document).on('click', '.dltComment', function () {
            // console.log(commentId);
            // return false;
            let commentId = $(this).attr('data-commentId');
            let hideDivChildCmt = $(this).parents('.nested-comment-' + commentId).hide();
            let hideDivParentCmt = $(this).parents('.post-Comment-' + commentId).hide();

            let commentCount = parseInt($(this).parents('.posted-content').find('.commentCount').text());
            let newCommentCount = $(this).parents('.posted-content').find('.commentCount');
            // console.log(commentId);

            // return false;
            Swal.fire({
                title: 'Do you want to delete the comment?',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                denyButtonColor: '#8CD4F5',
                confirmButtonText: `Delete`,
                denyButtonText: `Don't Delete`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    if (commentId !== '') {
                        // console.log(commentId)
                        // return false;
                        $.ajax({
                            url: '{{route('user.delete.comments')}}',
                            type: 'GET',
                            data: {
                                commentId: commentId,
                                reqType: 'deleteUserPostComment'
                            },
                            success: function (response) {

                                if (response.status === true) {

                                    newCommentCount.text(commentCount -= 1);
                                    hideDivChildCmt.hide();
                                    hideDivParentCmt.hide();
                                    Swal.fire('Saved!', '', 'success')

                                } else {
                                    // toastr.error(response.msg);
                                }
                            },
                            // error: function (err) {
                            //
                            //     toastr.error("Error with AJAX callback !");
                            // }
                        })
                    }
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })

        })

        $(document).on('click', '.fa-paper-plane', function () {
            // let postText = $(this).attr("data-commentText");
            let cmtId = $(this).attr("data-cmtId");
            let postId = $(this).attr("data-postId");
            let postText = $(this).closest('.comment-div').find('.comment-content').val();
            // let postText=$(this).parents('.post-comment-list').find('.comment-content').val();
            // console.log(postText,'.....');
            // return false;
            $.ajax({
                url: "{{route('user.post-all.reaction')}}",
                type: "POST",
                data: {
                    postText: postText,
                    cmtId: cmtId,
                    postId: postId,
                    reqType: "editUserNewsFeedComment",
                    '_token': '{{csrf_token()}}'
                },
                success: function (response) {
                    // let oldText=$(this).parents('.post-comment-list').find('.comment-content').text();

                }
            })


        })

        $(document).on('click', '.showImg', function () {
            // let postText = $(this).attr("data-commentText");
            let imgType = $(this).attr("data-key");

            let getImgDev = $(this).parents('.profile-friend-list').find('.appendImage')
            // getImgDev.addClass(imgType);
            console.log(getImgDev);
            // return false;

            $.ajax({
                url: "{{route('user.show.image-album')}}",
                type: "GET",
                data: {
                    imgType: imgType,
                },
                success: function (response) {

                    // console.log(response.reqTyp);

                    if (response.reqTyp === 'img') {

                        getImgDev.removeClass('pp')
                        getImgDev.removeClass('pc')
                        getImgDev.addClass('img')
                        if (getImgDev.hasClass('img')) {
                            getImgDev.append(response.html);
                        } else {
                            getImgDev.removeClass('img')
                        }
                    } else if (response.reqTyp === 'pp') {

                        getImgDev.removeClass('img')
                        getImgDev.removeClass('pc')
                        getImgDev.addClass('pp')

                        if (getImgDev.hasClass('pp')) {
                            getImgDev.append(response.html);
                        } else {
                            getImgDev.removeClass('pp')
                        }

                    } else if (response.reqTyp === 'pc') {
                        getImgDev.removeClass('img')
                        getImgDev.removeClass('pp')
                        getImgDev.addClass('pc')

                        if (getImgDev.hasClass('pc')) {
                            getImgDev.append(response.html);
                        } else {
                            getImgDev.removeClass('pc')
                        }
                    }
                }
            })


        })

    })
</script>

<script>

    $(document).on('click', '.btnEdit', function () {
        let postText = $(this).attr("data-postDetails");
        let postMedia = $(this).attr("data-mediaDetails");
        let postId = $(this).attr("data-postId");
        // console.log(postId);
        // console.log(postText);

        $('.postId').val(postId);
        let post = postMedia.split('.');
        console.log(post);
        $('.postDescription').val(postText);
        if (post[1] === 'mp4' || post[1] === 'mov' || post[1] === 'wmv' || post[1] === 'avi' ||
            post[1] === 'mkv' || post[1] === 'webm') {
            $('.videoSrc').attr('src', `{{asset("storage/community/post/videos")}}` + "/" + postMedia);

        } else {
            $('.postMedia').attr('src', `{{asset("storage/community/post/")}}` + "/" + postMedia);

        }

    })
</script>

<script>
    $(document).on('click', '.dltPost', function (event) {
        event.preventDefault();
        let postId = $(this).attr("data-id");
        {{--console.log({{route('community.user.post.delete')}}+postId);--}}
        // return false;
        Swal.fire({
            title: 'Do you want to delete the post?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            denyButtonColor: '#8CD4F5',
            confirmButtonText: `Delete`,
            denyButtonText: `Don't Delete`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let url = '{{ route("community.user.post.delete", ":slug") }}';
                url = url.replace(':slug', postId);
                window.location.href = url
                Swal.fire('Saved!', '', 'success')
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    });
</script>
