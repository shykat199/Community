@extends('community-frontend.layout.frontend_master')
{{--@dd($getGroupDetails)--}}
@php
    $id=\Request::segment(3);

     $isAdmin=\App\Models\Community\Group\CommunityUserGroupPivot::select('group_user_role')->where('user_id','=',Auth::id())
                ->where('group_id','=',$id)->first();

@endphp
@section('group.mainProfile')
    @include('community-frontend.layout.groupProfile',['getGroupDetails'=>$getGroupDetails,'id'=>$id])
    {{--    <x-page-group-header-section :getGroupDetails="$getGroupDetails">--}}
    {{--    </x-page-group-header-section>--}}

@endsection
@section('frontend.content')

    <div class="col-lg-3">


        <div class="news-feed-left">

            {{--            @include('community-frontend.layout.groupProfile')--}}

            @if(!empty($isAdmin->group_user_role) && isset($isAdmin->group_user_role) && $isAdmin->group_user_role == 1)
                @include('community-frontend.layout.groupUserInvitation',['id'=>$id])
            @endif

            @include('community-frontend.layout.suggestedGroup',['id',$id])

        </div>
    </div>

    <div class="col-lg-6">


        <div class="main-content create-post">
            <div class="widget-title">
                <h5>Create New Post</h5>
            </div>
            <form action="{{route('user.group.post.store')}}" class="input-psot" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="groupId" value="{{Request::segment(3)}}">
                <textarea name="postMessage" id="postMessage" placeholder="Write something here..."></textarea>
                <ul class="attachment-btn">
                    <li>
                        <button type="button" class="attachment-option-btn" data-bs-toggle="modal"
                                data-bs-target="#photoModal">
                            <div class="attachment-icon photo-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0"
                                     viewBox="0 0 430.23 430.23" style="enable-background:new 0 0 512 512"
                                     xml:space="preserve" class=""><g>
                                        <path
                                            d="M217.875 159.668c-24.237 0-43.886 19.648-43.886 43.886 0 24.237 19.648 43.886 43.886 43.886 24.237 0 43.886-19.648 43.886-43.886 0-24.238-19.648-43.886-43.886-43.886zm0 66.873c-12.696 0-22.988-10.292-22.988-22.988s10.292-22.988 22.988-22.988 22.988 10.292 22.988 22.988-10.292 22.988-22.988 22.988z"
                                            fill="#000000" data-original="#000000" class=""></path>
                                        <path
                                            d="M392.896 59.357 107.639 26.966a39.18 39.18 0 0 0-30.824 8.882 39.705 39.705 0 0 0-15.151 27.167l-5.224 42.841H40.243c-22.988 0-40.229 20.375-40.229 43.363V362.9c-.579 21.921 16.722 40.162 38.644 40.741.528.014 1.057.017 1.585.01h286.824c22.988 0 43.886-17.763 43.886-40.751v-8.359a52.242 52.242 0 0 0 19.853-8.359 43.366 43.366 0 0 0 15.151-28.212l24.033-212.114c2.45-23.041-14.085-43.768-37.094-46.499zM350.055 362.9c0 11.494-11.494 19.853-22.988 19.853H40.243c-10.383.305-19.047-7.865-19.352-18.248a18.68 18.68 0 0 1 .021-1.605v-38.661l80.98-59.559c9.728-7.469 23.43-6.805 32.392 1.567l56.947 50.155a49.114 49.114 0 0 0 30.825 11.494 47.542 47.542 0 0 0 25.078-6.792l102.922-59.559V362.9zm0-125.91-113.894 66.351a26.645 26.645 0 0 1-30.825-2.612l-57.469-50.678c-16.471-14.153-40.545-15.021-57.992-2.09l-68.963 50.155V149.219c0-11.494 7.837-22.465 19.331-22.465h286.824c12.28.509 22.197 10.201 22.988 22.465v87.771zm59.057-133.955c-.007.069-.013.139-.021.208l-24.555 212.114a17.762 17.762 0 0 1-6.792 14.106c-2.09 2.09-6.792 3.135-6.792 4.18V149.219c-.825-23.801-20.077-42.824-43.886-43.363H77.337l4.702-40.751a24.034 24.034 0 0 1 7.837-13.584 24.032 24.032 0 0 1 15.674-4.18l284.735 32.914c11.488 1.091 19.918 11.29 18.827 22.78z"
                                            fill="#000000" data-original="#000000" class=""></path>
                                    </g></svg>
                            </div>
                            Photo
                        </button>

                        <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content post-modal-content">
                                    <div class="modal-header">
                                        <div class="post-modal-title">
                                            <h6 class="modal-title" id="photoModalLabel">Create Post</h6>
                                        </div>
                                        <button type="button" class=" post-close" data-bs-dismiss="modal"
                                                aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i>
                                        </button>
                                    </div>

                                    @php
                                        $profilePic=\App\Models\Community\User_Profile\CommunityUserProfilePhoto::with('users.userProfileImages')->leftJoin('users','users.id','=','community_user_profile_photos.user_id')
                                    ->where('users.id','=',Auth::id())
                                    ->selectRaw('users.id as user_id,community_user_profile_photos.user_profile,community_user_profile_photos.created_at,community_user_profile_photos.id as ppId')
                                    ->latest()
                                    ->first();
                                    @endphp
                                    {{--                                                                        @dd($profilePic)--}}
                                    <div class="modal-body post-modal-body">
                                        <div class="my-profile">
                                            <div class="my-profile-img">

                                                @if(!empty($profilePic->users->userProfileImages[0]) && isset($profilePic->users->userProfileImages[0])?$profilePic->users->userProfileImages[0]:'')

                                                    @if(!empty($profilePic->users->userProfileImages[0]) && isset($profilePic->users->userProfileImages[0])?$profilePic->users->userProfileImages[0]:'')
                                                        <a href=""><img
                                                                src="{{asset("storage/community/profile-picture/".$profilePic->users->userProfileImages[0]->user_profile)}}"
                                                                alt="image"></a>
                                                    @else
                                                        <a href=""><img
                                                                src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                                                alt="image"></a>
                                                    @endif
                                                @endif


                                            </div>
                                            <div class="my-profile-name">{{Auth::user()->name}}</div>
                                        </div>
                                        <div class="post-text">
                                            <div class="post-text">
                                            <textarea id="postArea" name="imageCaption"
                                                      placeholder="Write Something here..."></textarea>
                                            </div>
                                        </div>

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
                                                <h6 class="title">Add Photos/Videos</h6>
                                                <p class="small-text">or drag and drop</p>
                                            </div>
                                            <div class="preview-file">
                                                <img class="previewImg" src="#" alt="">
                                                <button type="button" class="imgClose"><i class="fa fa-times"
                                                                                          aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            <div class="media-input">
                                                <input accept="" name="postFile" type='file' class="imgInp"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="social-theme-btn post-btn">Post</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </li>
                    <li>
                        <button type="button" class="attachment-option-btn" data-bs-toggle="modal"
                                data-bs-target="#photoModal">
                            <div class="attachment-icon vido-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 512 512"
                                     style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g>
                                        <g fill-rule="evenodd">
                                            <path
                                                d="M440.59 206.676H99.418l327.7-94.93a10.018 10.018 0 0 0 5.976-4.781 9.989 9.989 0 0 0 .847-7.606L416.793 40.16C409.941 16.516 387.926 0 363.253 0c-5.198 0-10.378.738-15.401 2.191L40.176 91.321c-14.23 4.12-26.024 13.581-33.215 26.632-7.188 13.05-8.875 28.078-4.754 42.305l16.754 57.836v238.254C18.96 487.035 43.926 512 74.609 512h120.164c5.524 0 10-4.477 10-10s-4.476-10-10-10H74.613c-19.66 0-35.652-15.992-35.652-35.652V320.262H430.589v136.086c0 19.66-15.991 35.652-35.651 35.652H274.773c-5.52 0-10 4.477-10 10s4.48 10 10 10h120.165c30.687 0 55.652-24.965 55.652-55.652V216.676c0-5.524-4.477-10-10-10zm-176.332 93.586 42.488-73.586h55.262l-42.485 73.586zm-78.36 0 42.489-73.586h55.261l-42.484 73.586zm-78.355 0 42.484-73.586h55.266l-42.488 73.586zm37.18-129.457-71.149-68.336 53.309-15.442a9.92 9.92 0 0 0 1.312 1.543l71.149 68.336-53.309 15.442a9.951 9.951 0 0 0-1.312-1.543zm134-125.84L349.87 113.3l-53.308 15.441a9.742 9.742 0 0 0-1.313-1.543l-71.148-68.336 53.308-15.441a9.92 9.92 0 0 0 1.313 1.543zM203.457 66.77l71.148 68.332-53.308 15.445a9.742 9.742 0 0 0-1.313-1.543l-71.148-68.336 53.309-15.441c.378.543.816 1.062 1.312 1.543zm149.961-45.368c3.21-.93 6.52-1.402 9.836-1.402 15.824 0 29.937 10.578 34.328 25.727l14.367 49.59-40.12 11.62a10.165 10.165 0 0 0-1.317-1.542l-71.145-68.333zM24.48 127.602c4.61-8.372 12.16-14.434 21.262-17.07l5.875-1.704a10.17 10.17 0 0 0 1.313 1.543l71.148 68.336-88.293 25.578-14.367-49.59c-2.637-9.097-1.547-18.718 3.062-27.093zm14.48 99.074h87.974l-42.485 73.586H38.961zm303.657 73.586 42.485-73.586h45.488v73.586zm0 0"
                                                fill="#000000" data-original="#000000" class=""></path>
                                            <path
                                                d="M303.922 405.113a9.997 9.997 0 0 0-5-8.66l-87.856-50.723a10.006 10.006 0 0 0-10 0 9.997 9.997 0 0 0-5 8.66v101.446a9.995 9.995 0 0 0 5 8.656 9.983 9.983 0 0 0 10 0l87.856-50.719a9.997 9.997 0 0 0 5-8.66zm-87.856 33.403V371.71l57.856 33.402zM234.773 492c-5.507 0-10 4.492-10 10s4.493 10 10 10c5.512 0 10-4.492 10-10s-4.488-10-10-10zm0 0"
                                                fill="#000000" data-original="#000000" class=""></path>
                                        </g>
                                    </g></svg>
                            </div>
                            Video
                        </button>
                    </li>
                    <li>
                        <button type="submit" class="social-theme-btn">Post</button>
                    </li>
                </ul>
            </form>

        </div>
{{--                                                @dd($groupPosts)--}}
        @foreach($groupPosts as $post)
            <div class="main-content posted-content">

                <div class="post-autore d-flex justify-content-between align-items-center">
                    <div class="authore-title d-flex align-items-center">
                        <a href="#">

                            @if(!empty($post->users->userProfileImages[0]) && isset($post->users->userProfileImages[0]) ? $post->users->userProfileImages[0]:'')
                                <img
                                    src="{{asset("storage/community/profile-picture/".$post->users->userProfileImages[0]->user_profile)}}"
                                    alt="image">
                            @else
                                <img
                                    src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                    alt="image">
                            @endif

                        </a>
                        {{--                        @dd($post)--}}
                        <div class="athore-info">
                            <p class="athore-name"><a href="#">{{$post->userName}}</a></p>
                            <p class="posted-time"><a
                                    href="#">{{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</a>
                            </p>
                        </div>
                    </div>

                    @php
                        $isAdmin=\App\Models\Community\Group\CommunityUserGroupPivot::select('group_user_role')->where('user_id','=',Auth::id())
                    ->where('group_id','=',Request::segment(3))->first();
//                    @dd($isAdmin)
//                            dd($isOwner);
                    @endphp


                    <div class="post-option">


                        @if($isAdmin)

                            <button type="button" class="dropdown-toggle" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"
                                                                                       aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <a href="#" data-mediaDetails="{{$post->group_post_file}}"
                                       data-postDetails="{{$post->post_description}}"
                                       data-postId="{{$post->grpPostId}}"
                                       data-bs-toggle="modal"
                                       data-bs-target="#photoModal1" class="post-option-item btnEdit"><i
                                            class="fa fa-pencil-square-o"
                                            aria-hidden="true"></i> Edit Post
                                    </a>
                                </li>
                                {{--                            @dd($post->grpPostId)--}}
                                <li><a href="{{route('community.group.post.delete',$post->grpPostId)}}"
                                       data-id="{{$post->grpPostId}}"
                                       class="post-option-item dltPost"><i class="fa fa-trash-o"
                                                                           aria-hidden="true"></i> Delete Post</a>
                                </li>
                            </ul>
                        @endif


                    </div>


                </div>

                <!-- Modal -->
                <div class="modal fade" id="photoModal1" tabindex="-1" aria-labelledby="photoModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content post-modal-content">
                            <div class="modal-header">
                                <div class="post-modal-title">
                                    <h6 class="modal-title" id="photoModalLabel">Edit Post</h6>
                                </div>
                                <button type="button" class=" post-close" data-bs-dismiss="modal"
                                        aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                            <form action="{{route('community.group.post.update')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="postId" class="postId" value="">
                                <div class="modal-body post-modal-body">
                                    <div class="my-profile">
                                        <div class="my-profile-img"><a href="#"><img
                                                    src="{{asset("community-frontend/assets/images/community/home/right/birthday01.jpg")}}"
                                                    alt="img"></a></div>
                                        <div class="my-profile-name">{{Auth::user()->name}}</div>
                                    </div>
                                    <div class="post-text">
                                        <div class="post-text">
                                            <textarea id="postArea" class="postDescription" name="postMessage"
                                                      placeholder="Write Something here..."></textarea>
                                        </div>
                                    </div>

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
                                            <h6 class="title">Add Photos/Videos</h6>
                                            <p class="small-text">or drag and drop</p>
                                        </div>
                                        <div class="preview-file">
                                            {{--                                        <div class="post-img">--}}
                                            {{--                                            <video width="550" height="240" controls>--}}
                                            {{--                                                <source class="videoSrc" src="#" type="video/mp4">--}}
                                            {{--                                            </video>--}}
                                            {{--                                        </div>--}}
                                            <img class="previewImg postMedia" src="#" alt="">
                                            <button type="button" class="imgClose"><i class="fa fa-times"
                                                                                      aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <div class="media-input">
                                            <input accept="" name="postFile1" type='file' class="imgInp"/>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="social-theme-btn post-btn">Update</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>


                <div class="post-body">
                    <p class="post-status">{{$post->post_description}}</p>
                    {{--                    @dd($post->group_post_file)--}}

                    @if($post->group_post_file!=null)

                        {{--                    @dd(explode('.',$post->userPostMedia))--}}
                        @php
                            $extension=explode('.',$post->group_post_file);
                        @endphp
                        {{--                                            @dd($extension[1])--}}

                        @if($post->group_post_file)

                            @if($extension[1]==='mp4'||$extension[1]==='mov'||$extension[1]==='wmv'||$extension[1]==='avi'||
                            $extension[1]==='mkv'||$extension[1]==='webm')
                                <div class="post-img">
                                    <video width="550" height="240" controls>
                                        <source
                                            src="{{asset("storage/community/group-post/videos/".$post->group_post_file)}}"
                                            type="video/mp4">
                                    </video>
                                </div>
                            @else
                                <div class="post-img">
                                    <img src="{{asset("storage/community/group-post/".$post->group_post_file)}}" alt="">
                                </div>
                            @endif

                        @endif
                        {{--                    <div class="post-img">--}}
                        {{--                        <img src="{{asset("community-frontend/assets/images/community/home/news-post/post-1.jpg")}}" alt="">--}}
                        {{--                    </div>--}}
                        {{--                        <div class="post-img">--}}
                        {{--                            <img src="{{asset("storage/community/group-post/".$post->group_post_file)}}" alt="">--}}
                        {{--                        </div>--}}
                    @endif

                    <ul class="post-react-widget">
                        <li class="post-react like-react">
                            <a href="Javascript:void(0)">
                                <div class="react-icon" id="react-icon">

                                    <img class="like"
                                         src="{{asset("community-frontend/assets/images/community/home/news-post/like.png")}}"
                                         alt="">
                                </div>

                                <span class="react-name">Like</span>
                                <span
                                    class="react-count">{{getGroupPostReactionCount($post->grpPostId)}}</span>
                            </a>
                            <ul class="react-option">
                                <li class="reaction" data-reaction_type="like" data-gId="{{$post->grpPostId}}">
                                    <img
                                        src="{{asset("community-frontend/assets/images/community/home/news-post/react-1.png")}}"
                                        alt="React">
                                </li>
                                {{--                                @dd($post)--}}
                                <li class="reaction" data-reaction_type="love" data-gId="{{$post->grpPostId}}"><img
                                        src="{{asset("community-frontend/assets/images/community/home/news-post/react-2.png")}}"
                                        alt="React"></li>
                                <li class="reaction" data-reaction_type="care" data-gId="{{$post->grpPostId}}"><img
                                        src="{{asset("community-frontend/assets/images/community/home/news-post/react-3.png")}}"
                                        alt="React"></li>
                                <li class="reaction" data-reaction_type="haha" data-gId="{{$post->grpPostId}}"><img
                                        src="{{asset("community-frontend/assets/images/community/home/news-post/react-4.png")}}"
                                        alt="React"></li>
                                <li class="reaction" data-reaction_type="wow" data-gId="{{$post->grpPostId}}"><img
                                        src="{{asset("community-frontend/assets/images/community/home/news-post/react-5.png")}}"
                                        alt="React"></li>
                                <li class="reaction" data-reaction_type="sad" data-gId="{{$post->grpPostId}}"><img
                                        src="{{asset("community-frontend/assets/images/community/home/news-post/react-6.png")}}"
                                        alt="React"></li>
                                <li class="reaction" data-reaction_type="care" data-gId="{{$post->grpPostId}}"><img
                                        src="{{asset("community-frontend/assets/images/community/home/news-post/react-7.png")}}"
                                        alt="React"></li>
                            </ul>
                        </li>
                        <li class="post-react">
                            <a href="#">
                                <div class="react-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 32 32"
                                         style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g>
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
                                <span class="react-count">{{getGroupPostCommentCount($post->grpPostId)}}</span>
                            </a>
                        </li>

                        <li class="post-react">
                            <a href="#">
                                <div class="react-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0"
                                         viewBox="0 0 512 512.001" style="enable-background:new 0 0 512 512"
                                         xml:space="preserve" class=""><g>
                                            <path
                                                d="M361.824 344.395c-24.531 0-46.633 10.593-61.972 27.445l-137.973-85.453A83.321 83.321 0 0 0 167.605 256a83.29 83.29 0 0 0-5.726-30.387l137.973-85.457c15.34 16.852 37.441 27.45 61.972 27.45 46.211 0 83.805-37.594 83.805-83.805C445.629 37.59 408.035 0 361.824 0c-46.21 0-83.804 37.594-83.804 83.805a83.403 83.403 0 0 0 5.726 30.386l-137.969 85.454c-15.34-16.852-37.441-27.45-61.972-27.45C37.594 172.195 0 209.793 0 256c0 46.21 37.594 83.805 83.805 83.805 24.53 0 46.633-10.594 61.972-27.45l137.97 85.454a83.408 83.408 0 0 0-5.727 30.39c0 46.207 37.593 83.801 83.804 83.801s83.805-37.594 83.805-83.8c0-46.212-37.594-83.805-83.805-83.805zm-53.246-260.59c0-29.36 23.887-53.246 53.246-53.246s53.246 23.886 53.246 53.246c0 29.36-23.886 53.246-53.246 53.246s-53.246-23.887-53.246-53.246zM83.805 309.246c-29.364 0-53.25-23.887-53.25-53.246s23.886-53.246 53.25-53.246c29.36 0 53.242 23.887 53.242 53.246s-23.883 53.246-53.242 53.246zm224.773 118.95c0-29.36 23.887-53.247 53.246-53.247s53.246 23.887 53.246 53.246c0 29.36-23.886 53.246-53.246 53.246s-53.246-23.886-53.246-53.246zm0 0"
                                                fill="#000000" data-original="#000000"></path>
                                        </g></svg>
                                </div>
                                <span class="react-name">share</span>
                                <span class="react-count">2506</span>
                            </a>
                        </li>

                    </ul>
                    <ul class="post-comment-list">

                        {{--All Comments List--}}
                    </ul>
                    <div class="more-comment">
                        <a class="checkCmt" data-postIdd="{{$post->grpPostId}}">More Comments+</a>
                    </div>

                    <form action="#" class="new-comment">
                        <a href="#" class="new-comment-img">
                            @if(!empty($post->users->userProfileImages[0]) && isset($post->users->userProfileImages[0]) ? $post->users->userProfileImages[0]:'')
                                <img
                                    src="{{asset("storage/community/profile-picture/".$post->users->userProfileImages[0]->user_profile)}}"
                                    alt="image" style="height: 60px; width: 60px">
                            @else
                                <img
                                    src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                    alt="image">
                            @endif
                        </a>

                        <div class="new-comment-input">
                            <input type="text" data-postId="{{$post->grpPostId}}" class="postComments" placeholder="Write a comment....">
                            <div class="attached-icon">
                                <a href="#"><i class="fa fa-camera" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @endforeach

    </div>


    <div class="col-lg-3">
        <div class="news-feed-right">
            <div class="weather-img">
                <a href="#">
                    @include('community-frontend.layout.weather')
                </a>
            </div>


            {{--            @include('community-frontend.layout.birthday')--}}
            @include('community-frontend.layout.group_user_list')

            {{--            @include('community-frontend.layout.followers')--}}


        </div>
    </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

</script>
<script>
    $(document).ready(function () {
        $('.reaction').on('click', function () {

            $('.reaction').removeClass('active');
            $(this).addClass('active');

            let getReaction = $(this).attr('data-reaction_type');
            let grpPostId = $(this).attr('data-gId');

            let img_src = $(this).find('img').attr('src')
            $(this).parents('.like-react').find('.react-icon img').attr('src', img_src)

            // console.log(parests_data, 'parests_data')
            // let img_src = $(this).find('img').attr('src');
            // console.log(img_src,'img_src');

            if (getReaction !== '' && grpPostId !== '') {
                $.ajax({
                    url: '{{route('user.group.post.reaction')}}',
                    type: 'POST',
                    data: {
                        getReaction: getReaction,
                        grpPostId: grpPostId,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response);
                        console.log(response.data);
                        if (response.success === true) {

                            toastr.success(response.msg);

                            // let img_src = $(this).find('img').attr('src');
                            // console.log(img_src,'img_src');
                            // $(this).parents('.like-react').find('.react-icon img').attr('src', img_src);

                        } else {
                            toastr.error(response.msg);
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
                e.preventDefault();
                let comment = e.target.value;
                let postId = $(this).attr('data-postId');
                $(this).val('');
                // let htmlData = $(this).parents('.posted-content').find('.post-comment-list')
                let htmlData = $(this).parents('.main-content').find('.post-comment-list');

                if (comment !== '' && postId !== '') {
                    $.ajax({
                        url: '{{route('community.store.user.group.post.comment')}}',
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
                                // console.log($(this),'this')
                                $(this).val('');
                                console.log(response.data,'datat');
                                htmlData.html(response.data);
                                // console.log(response.data);

                            } else {
                                toastr.error(response.msg);
                            }
                        },
                        error: function (err) {

                            toastr.error("Error with AJAX callback !");
                        }
                    })
                }
            }
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
            $('.videoSrc').attr('src', `{{asset("storage/community/group-post/videos")}}` + "/" + postMedia);

        } else {
            $('.postMedia').attr('src', `{{asset("storage/community/group-post/")}}` + "/" + postMedia);

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
                let url = '{{ route("community.group.post.delete", ":slug") }}';
                url = url.replace(':slug', postId);
                window.location.href = url
                Swal.fire('Saved!', '', 'success')
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    });
</script>
<script>
    $(document).on('click', '.replay-tag', function () {

        $(this).parents('.comment-details').find('.replay-new-comment').css('display', 'block');
    })


    $(document).keypress('.cmtText', function (e) {
        let cmtId = e.target.dataset.cmtid;
        let group_post_id = e.target.dataset.userpostid;
        let cmtText = e.target.value;
        let key = e.which;
        // console.log(user_post_id);
// return false;
        if (key === 13) {
            // console.log(cmtText);

            $.ajax({
                url: "{{route('community.user.store.group.commentsOfComments')}}",
                type: 'POST',
                data: {
                    cmtId: cmtId,
                    cmtText: cmtText,
                    group_post_id: group_post_id,
                    '_token': '{{csrf_token()}}'
                },
                success: function (response) {
                    // console.log(response);

                    if (response.success === true) {
                        toastr.success(response.msg);
                        $('.cmtText').val('');
                        $('.comment-parent-'+cmtId).append(response.data);
                    } else {
                        toastr.error(response.msg);
                    }
                },
                error: function (err) {

                    toastr.error("Error with AJAX callback !");
                }
            })
        }


    })

</script>

<script>
    $(document).on('click','.checkCmt',function (){
        let gPostId=$(this).attr('data-postIdd')
        let htmlData = $(this).parents('.posted-content').find('.post-comment-list')
        console.log(gPostId);
        $.ajax({
            url:'{{route('users.get-all-comments')}}',
            type:'GET',
            data:{
                gPostId:gPostId,
                reqTyp:'grpCmt'
            },
            success: function (response) {

                if (response.status === true) {

                    // console.log(response.html,'cmt');
                    // $('.postComments').val('');
                    htmlData.html(response.html);
                }


            },
        })
    })
</script>
