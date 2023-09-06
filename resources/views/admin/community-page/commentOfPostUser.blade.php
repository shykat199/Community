@extends('admin.layouts.master')
@section('admin.content')
    <style>
        body {
            margin-top: 20px;
            background: #ebeef0;
        }

        .img-sm {
            width: 46px;
            height: 46px;
        }

        .panel {
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.075);
            border-radius: 0;
            border: 0;
            margin-bottom: 15px;
        }

        .panel .panel-footer, .panel > :last-child {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        .panel .panel-heading, .panel > :first-child {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .panel-body {
            padding: 25px 20px;
        }


        .media-block .media-left {
            display: block;
            float: left
        }

        .media-block .media-right {
            float: right
        }

        .media-block .media-body {
            display: block;
            overflow: hidden;
            width: auto
        }

        .middle .media-left,
        .middle .media-right,
        .middle .media-body {
            vertical-align: middle
        }

        .thumbnail {
            border-radius: 0;
            border-color: #e9e9e9
        }

        .tag.tag-sm, .btn-group-sm > .tag {
            padding: 5px 10px;
        }

        .tag:not(.label) {
            background-color: #fff;
            padding: 6px 12px;
            border-radius: 2px;
            border: 1px solid #cdd6e1;
            font-size: 12px;
            line-height: 1.42857;
            vertical-align: middle;
            -webkit-transition: all .15s;
            transition: all .15s;
        }

        .text-muted, a.text-muted:hover, a.text-muted:focus {
            color: #acacac;
        }

        .text-sm {
            font-size: 0.9em;
        }

        .text-5x, .text-4x, .text-5x, .text-2x, .text-lg, .text-sm, .text-xs {
            line-height: 1.25;
        }

        .btn-trans {
            background-color: transparent;
            border-color: transparent;
            color: #929292;
        }

        .btn-icon {
            padding-left: 9px;
            padding-right: 9px;
        }

        .btn-sm, .btn-group-sm > .btn, .btn-icon.btn-sm {
            padding: 5px 10px !important;
        }

        .mar-top {
            margin-top: 15px;
        }
    </style>

{{--    @dd($allPostComments)--}}
    <div class="content-page">

        @if(\Illuminate\Support\Facades\Session::has('success'))
            <div class="alert alert-success">
                {{\Illuminate\Support\Facades\Session::get('success')}}
            </div>
        @endif

        @if(\Illuminate\Support\Facades\Session::has('error'))
            <div class="alert alert-success">
                {{\Illuminate\Support\Facades\Session::get('error')}}
            </div>
        @endif


        {{-- ================= Start===================== --}}

{{--                        @dd($postComments)--}}

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <div class="container bootdey">
            <div class="col-md-12 bootstrap snippets">
                <div class="panel">
                    <div class="panel-body">
                        <!-- Newsfeed Content -->
                        <!--===================================================-->
{{--                                                        @dd($postComments)--}}
                        @foreach($postComments as $mainPost)
                            <div class="media-block post-Comment-{{$mainPost->id}}">
                                <a class="media-left" href="#">

                                    @if(!empty($mainPost->userPosts->users->userProfileImages[0]) && isset($mainPost->userPosts->users->userProfileImages[0])?$mainPost->userPosts->users->userProfileImages[0]:'')
                                        <img class="mg-circle img-sm"
                                            src="{{asset("storage/community/profile-picture/".$mainPost->userPosts->users->userProfileImages[0]->user_profile)}}"
                                            alt="image">
                                    @else
                                        <img class="mg-circle img-sm"
                                            src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                            alt="image">
                                    @endif

                                </a>
                                <div class="media-body">
                                    <div class="mar-btm">
                                        <a href="#"
                                           class="btn-link text-semibold media-heading box-inline">{{$mainPost->userPosts->users->name}}</a>
                                        <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i>
                                            - {{\Carbon\Carbon::parse($mainPost->created_at)->diffForHumans()}}</p>
                                    </div>
                                    <p>{{$mainPost->comment_text}}</p>
                                    <div class="pad-ver">
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-default btn-hover-danger dltComment" data-commentId="{{$mainPost->id}}"><i
                                                    class="fa fa-trash text-danger"></i></a>
                                        </div>
                                        @if(count($mainPost->replies)>0)
                                            <a class="btn btn-sm btn-default btn-hover-primary loadChildCmt" href="#"
                                               data-postIdd="{{$mainPost->user_post_id}}"
                                               data-commentId="{{$mainPost->id}}">
                                                Load Reply <i class="fa fa-plus"></i></a>
                                        @endif
                                    </div>
                                    <hr>

                                    <!-- Comments -->
                                    <div class="post-comments nested-comment-{{$mainPost->id}}">

{{--                                        <div class="media-block">--}}
{{--                                            <a class="media-left" href="#"><img class="img-circle img-sm"--}}
{{--                                                                                alt="Profile Picture"--}}
{{--                                                                                src="https://bootdey.com/img/Content/avatar/avatar2.png"></a>--}}
{{--                                            <div class="media-body">--}}
{{--                                                <div class="mar-btm">--}}
{{--                                                    <a href="#" class="btn-link text-semibold media-heading box-inline">Bobby--}}
{{--                                                        Marz</a>--}}
{{--                                                    <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i> ---}}
{{--                                                        From Mobile - 7 min ago</p>--}}
{{--                                                </div>--}}
{{--                                                <p>Sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna--}}
{{--                                                    aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud--}}
{{--                                                    exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea--}}
{{--                                                    commodo consequat.</p>--}}
{{--                                                <div class="pad-ver">--}}
{{--                                                    <div class="btn-group">--}}
{{--                                                        <a class="btn btn-sm btn-default btn-hover-success active"--}}
{{--                                                           href="#"><i class="fa fa-thumbs-up"></i> You Like it</a>--}}
{{--                                                        <a class="btn btn-sm btn-default btn-hover-danger" href="#"><i--}}
{{--                                                                class="fa fa-thumbs-down"></i></a>--}}
{{--                                                    </div>--}}
{{--                                                    <a class="btn btn-sm btn-default btn-hover-primary"--}}
{{--                                                       href="#">Comment</a>--}}
{{--                                                </div>--}}
{{--                                                <hr>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!--===================================================-->
                        <!-- End Newsfeed Content -->
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= End ===================== --}}


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
                integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            $(document).on('click', '.loadChildCmt', function () {
                let postId = $(this).attr('data-postIdd');
                let cmtId = $(this).attr('data-commentId');
                $(this).hide();
                console.log(postId);
                let htmlData = $(this).parents('.posted-content').find('.post-comment-list')
                $.ajax({
                    url: "{{route('user.load.child.comment')}}",
                    post: "GET",
                    data: {
                        postId: postId,
                        cmtId: cmtId,
                        reqType:'adminUserChildComment'
                    },
                    success: function (response) {

                        if (response.status === true) {

                            // console.log(response.html,'cmt');
                            $('.cmtText').val('');
                            $('.nested-comment-' + cmtId).append(response.html);

                        }


                    },
                })

            })

            $(document).on('click', '.dltComment', function () {
                // console.log(commentId);
                // return false;
                let commentId = $(this).attr('data-commentId');
                // console.log(commentId);
                // return false;

                let hideDivChildCmt = $(this).parents('.nested-comment1-' + commentId);
                let hideDivParentCmt = $(this).parents('.post-Comment-' + commentId);


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

                                        Swal.fire('Saved!', '', 'success')


                                        hideDivChildCmt.hide();
                                        hideDivParentCmt.hide();


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
        </script>

        <script>
            $('[data-toggle="collapse"]').on('click', function () {
                let $this = $(this),
                    $parent = typeof $this.data('parent') !== 'undefined' ? $($this.data('parent')) : undefined;
                if ($parent === undefined) { /* Just toggle my  */
                    $this.find('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
                    return true;
                }

                /* Open element will be close if parent !== undefined */
                let currentIcon = $this.find('.glyphicon');
                currentIcon.toggleClass('glyphicon-plus glyphicon-minus');
                $parent.find('.glyphicon').not(currentIcon).removeClass('glyphicon-minus').addClass('glyphicon-plus');

            });

        </script>

@endsection
