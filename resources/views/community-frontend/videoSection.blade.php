@extends('community-frontend.layout.frontend_master')
@section('frontend.user_setting')
    <!-- my profile start -->
    <div class="main-profile">
        <div class="row">
            <div class="col-lg-12">
                <div class="full-profile-box">
                    <div class="full-profile-cover">
                        <img
                            src="{{asset("community-frontend/assets/images/community/myProfile/my-profile-cover.jpg")}}"
                            alt="cover">
                        <div class="page-name">
                            Video
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- my profile end -->
@endsection

{{--<div class="col-lg-3 col-md-6 col-12">--}}
{{--    <div class="single-upload-video">--}}
{{--        <div class="single-info">--}}
{{--            <div class="page-img">--}}
{{--                <a href="#">--}}

{{--                    @if(!empty($video->users->userProfileImages[0]) && isset($video->users->userProfileImages[0])?$video->users->userProfileImages[0]:'')--}}
{{--                        <img--}}
{{--                            src="{{asset("storage/community/profile-picture/".$video->users->userProfileImages[0]->user_profile)}}"--}}
{{--                            alt="image">--}}
{{--                    @else--}}
{{--                        <img--}}
{{--                            src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"--}}
{{--                            alt="image">--}}
{{--                    @endif--}}

{{--                </a>--}}
{{--            </div>--}}
{{--            <div class="page-title">--}}
{{--                <a href="#">{{$video->name}}</a>--}}
{{--                <span class="date">Published: {{\Carbon\Carbon::parse( $video->created_at)->format('d M, Y')}}</span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="video-img">--}}
{{--            --}}{{--                        <img src="{{asset("community-frontend/assets/images/community/video/video-1.jpg")}}" alt="img">--}}
{{--            --}}{{--                        <a class="vido-play-icon" href="#" data-video-id="8qU2xhZlsJE">--}}
{{--            --}}{{--                            <i class="fa fa-youtube-play" aria-hidden="true"></i>--}}
{{--            --}}{{--                        </a>--}}

{{--            <video controls>--}}
{{--                <source src="{{asset("storage/community/post/videos/".$video->postMedia)}}"--}}
{{--                        type="video/mp4">--}}
{{--            </video>--}}

{{--        </div>--}}
{{--        <ul class="post-react-widget">--}}
{{--            <li class="post-react like-react">--}}
{{--                <a href="javascript:void(0)">--}}
{{--                    <div class="react-icon video-react-icon">--}}
{{--                        <i class="fa fa-heart-o" aria-hidden="true"></i>--}}
{{--                    </div>--}}
{{--                    <span class="react-count">2560</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="post-react">--}}
{{--                <a href="#">--}}
{{--                    <div class="react-icon">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g fill="#000"><path d="M10 11a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM14 13a2 2 0 1 1 4 0 2 2 0 0 1-4 0zM22 11a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" fill="#000000" data-original="#000000"></path><path fill-rule="evenodd" d="M5 1a5 5 0 0 0-5 5v14a5 5 0 0 0 5 5h.012l.01 4.678a1 1 0 0 0 1.725.687L11.836 25H27a5 5 0 0 0 5-5V6a5 5 0 0 0-5-5zM2 6a3 3 0 0 1 3-3h22a3 3 0 0 1 3 3v14a3 3 0 0 1-3 3H11.406a1 1 0 0 0-.726.312l-3.664 3.862-.006-3.176a1 1 0 0 0-1-.998H5a3 3 0 0 1-3-3z" clip-rule="evenodd" fill="#000000" data-original="#000000"></path></g></g></svg>--}}
{{--                    </div>--}}
{{--                    <span class="react-count">256</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="post-react">--}}
{{--                <a href="#">--}}
{{--                    <div class="react-icon">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512.001" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M361.824 344.395c-24.531 0-46.633 10.593-61.972 27.445l-137.973-85.453A83.321 83.321 0 0 0 167.605 256a83.29 83.29 0 0 0-5.726-30.387l137.973-85.457c15.34 16.852 37.441 27.45 61.972 27.45 46.211 0 83.805-37.594 83.805-83.805C445.629 37.59 408.035 0 361.824 0c-46.21 0-83.804 37.594-83.804 83.805a83.403 83.403 0 0 0 5.726 30.386l-137.969 85.454c-15.34-16.852-37.441-27.45-61.972-27.45C37.594 172.195 0 209.793 0 256c0 46.21 37.594 83.805 83.805 83.805 24.53 0 46.633-10.594 61.972-27.45l137.97 85.454a83.408 83.408 0 0 0-5.727 30.39c0 46.207 37.593 83.801 83.804 83.801s83.805-37.594 83.805-83.8c0-46.212-37.594-83.805-83.805-83.805zm-53.246-260.59c0-29.36 23.887-53.246 53.246-53.246s53.246 23.886 53.246 53.246c0 29.36-23.886 53.246-53.246 53.246s-53.246-23.887-53.246-53.246zM83.805 309.246c-29.364 0-53.25-23.887-53.25-53.246s23.886-53.246 53.25-53.246c29.36 0 53.242 23.887 53.242 53.246s-23.883 53.246-53.242 53.246zm224.773 118.95c0-29.36 23.887-53.247 53.246-53.247s53.246 23.887 53.246 53.246c0 29.36-23.886 53.246-53.246 53.246s-53.246-23.886-53.246-53.246zm0 0" fill="#000000" data-original="#000000"></path></g></svg>--}}
{{--                    </div>--}}
{{--                    <span class="react-count">2506</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--        <form action="#" class="vido-coment">--}}
{{--            <input type="text" placeholder="Write Comment">--}}
{{--            <button type="submit" class="vido-coment-send"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--</div>--}}

@section('frontend.others')

    <div class="row">
        {{--        @dd($allVideos)--}}
        @foreach($allVideos as $video)
            {{--                        @dd($video)--}}
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-upload-video">
                    <div class="single-info">
                        <div class="page-img">
                            <a href="#">

                                @if(!empty($video->users->userProfileImages[0]) && isset($video->users->userProfileImages[0])?$video->users->userProfileImages[0]:'')
                                    <img class="profilePicture"
                                         src="{{asset("storage/community/profile-picture/".$video->users->userProfileImages[0]->user_profile)}}"
                                         alt="image">
                                @else
                                    <img
                                        src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                        alt="image">
                                @endif

                            </a>
                        </div>
                        <div class="page-title">
                            <a href="#" class="data"
                            >{{$video->name}}</a>
                            <span
                                class="date">Published: {{\Carbon\Carbon::parse( $video->created_at)->format('d M, Y')}}</span>
                        </div>
                    </div>


                    <div class="video-img" data-bs-toggle="modal" data-bs-target="#videoShow"
                         data-postId="{{$video->pId}}"
                         data-postDescription="{{$video->post_description}}"
                         data-userNmae="{{$video->name}}"
                         data-date="{{\Carbon\Carbon::parse( $video->created_at)->format('d M, Y')}}"
                         data-postImg="{{$video->postMedia}}"
                         data-userImg="{{$video->users->userProfileImages[0]->user_profile}}">
                        <video class="community-video-poster">
                            <source src="{{asset('storage/community/post/videos/'.$video->postMedia)}}"
                                    type="video/mp4">
                        </video>
                        <div class="vido-play-icon">
                            <i class="fa fa-youtube-play" aria-hidden="true"></i>
                        </div>
                    </div>

                    <ul class="post-react-widget">
                        <li class="post-react like-react">
                            <a href="javascript:void(0)">
                                <div class="react-icon video-react-icon">
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                </div>
                                <span class="react-count">{{getUserTimeLinePostReactionCount($video->pId)}}</span>
                            </a>
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
                                                      clip-rule="evenodd" fill="#000000" data-original="#000000"></path>
                                            </g>
                                        </g></svg>
                                </div>
                                <span class="react-count">{{getUserTimeLinePostCommentCount($video->pId)}}</span>
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
                                <span class="react-count">0</span>
                            </a>
                        </li>
                    </ul>

{{--                    @dd($video)--}}
                    <div  class="vido-coment" >
                        <input type="text" placeholder="Write Comment">
                        <button type="submit" class="vido-coment-send">
                            <i class="fa fa-paper-plane-o" aria-hidden="true" data-postId="{{$video->pId}}"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- video show modal start -->
        <div class="modal fade video-modal-show" id="videoShow" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true" onclick="document.getElementById('comunityVideoPause').pause();">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="vido-modal-close-btn" data-bs-dismiss="modal" aria-label="Close"
                            onclick="document.getElementById('comunityVideoPause').pause();"><i class="fa fa-times"
                                                                                                aria-hidden="true"></i>
                    </button>
                    <div class="modal-body">
                        <div class="single-info">
                            <div class="page-img "><a href="#"><img class="uImg"
                                                                    src=""
                                                                    alt="img"></a>
                            </div>
                            <div class="page-title">
                                <a href="#">Lolita Benally</a>
                                <span class="date">Published: 10 July, 2021</span>
                            </div>
                        </div>
                        <div class="uploaded-video-status">
                            <p class="postDescription"></p>
                        </div>


                        <video class="playing-video" id="comunityVideoPause" controls>
                            <source class="source" src="" type="video/mp4">
                        </video>

                        <div class="vido-cm-div video-coment-list">
                            <ul class="post-comment-list ">
                                <li class="single-comment">
                                    <div class="comment-img">
                                        <a href="#">
                                            <img src="{{asset("community-frontend/assets/images/community/home/news-post/comment01.jpg")}}"
                                                 alt="image">
                                        </a>
                                    </div>
                                    <div class="comment-details">
                                        <div class="coment-info">
                                            <h6><a href="#">David Moore</a></h6>
                                            <span class="comment-time">10 Mint Ago</span>
                                        </div>
                                        <p class="comment-content">Praesent sapien massa convallis a pellentesque non
                                            nisi curabitur non nulla sit amet nisl tempus convallis lectus.</p>
                                        <ul class="coment-react">
                                            <li class="comment-like"><a href="#">Like(2)</a></li>
                                            <li><a href="#">Replay</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                            <div class="more-comment">
                                <a href="#">More Comments+</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- video show modal end -->


    </div>
@endsection
@include('community-frontend.layout.liveChat')
@include('community-frontend.layout.sidebar')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {
        $('.video-img').on('click', function () {
            let userName = $(this).attr('data-userNmae');
            let postId = $(this).attr('data-postId');
            let postDescription = $(this).attr('data-postDescription');
            let postTime = $(this).attr('data-date');
            let postMedia = $(this).attr('data-postImg');
            let userImag = $(this).attr('data-userImg');

            console.log(userImag)
            console.log(postMedia)

            console.log(`{{asset("storage/community/post/videos")}}` + '/' + postMedia)
            $('.userName').text(userName);
            $('.date').text(postTime);
            $('.postDescription').text(postDescription);
            $('.source').attr('src', `{{asset("storage/community/post/videos")}}` + '/' + postMedia);
            $('.uImg').attr('src', `{{asset("storage/community/profile-picture")}}` + '/' + userImag);
            let v = document.getElementById('comunityVideoPause');
            v.load();
        })

        $(document).on('click','.fa-paper-plane-o',function (){
            let postId=$(this).attr('data-postId');
            console.log(postId);

            $.ajax({
                url:'{{route('community.user.post.comment')}}',
                type:"POST",
                data:{
                    postId:postId,
                    '_token': '{{csrf_token()}}'
                },
                success:function (response){
                    console.log(response.msg);
                }
            })

        })

    })
</script>
