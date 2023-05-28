<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Community\Group\CommunityUserGroupPostComment;
use App\Models\Community\Page\CommunityPagePostComment;
use App\Models\Community\User_Post\CommunityUserPostComment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetCommentController extends Controller
{
    public function getAllComments(Request $request)
    {

        $returnResult = [];

//        dd($request->all());
        if ($request->ajax()) {

            if ($request->get('reqTyp') === 'grpCmt') {

                $newPostComments = CommunityUserGroupPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('group_post_id', '=', $request->get('gPostId'))
                    ->where('group_post_comment_id', '=', 0)
                    ->whereNotIn('community_user_group_post_comments.id', (array)json_decode($request->get('commentId')))->latest()->get();

//            dd($newPostComments);
                $html = '';

                if ($newPostComments) {

                    foreach ($newPostComments as $comment) {

                        $date = Carbon::parse($comment->created_at)->diffForHumans();
                        $userName = $comment->userPosts->users->name;
                        $comments = $comment->comment_text;
                        $commentId = $comment->id;
                        $userProfilePicture = isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '';

                        $html .= '<li class="single-comment post-Comment-' . $commentId . '">
                                <div class="parent-comment">
                                    <div class="replay-comment-img comment-img">';
                        if (!empty($userProfilePicture) && isset($userProfilePicture)) {
                            $html .= '<a href="#"> <img src="' . asset("storage/community/profile-picture/$userProfilePicture") . '" alt="image">
                                </a>';
                        } else {
                            $html .= '<a><img src="' . asset("community-frontend/assets/images/community/home/news-post/comment01.jpg") . '"alt="image"></a>';

                        }
                        $html .= ' </div>
                                    <div class="comment-details">
                                        <div class="coment-info">
                                            <div class="coment-authore-div">
                                                <h6><a href="#">' . $userName . '</a></h6>
                                                <span class="comment-time">' . $date . '</span>
                                            </div>';
                        if ($comment->user_id === Auth::id()) {

                            $html .= '<div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1" style="">
                                                        <li class="post-option-item" id="editComment">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                            Edit Comment
                                                        </li>
                                                        <li class="post-option-item dltComment" data-commentId="' . $commentId . '">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            Delete comment
                                                        </li>
                                                    </ul>
                                                </div>';

                        } else {
                            $html .= '<div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1" style="">

                                                        <li class="post-option-item dltComment" data-commentId="' . $commentId . '">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            Delete comment
                                                        </li>
                                                    </ul>
                                                </div>';
                        }

                        $html .= '
                                        </div>

                                        <div class="comment-div">
                                            <p class="comment-content">' . $comments . '</p>

                                            <button class="textarea-btn" type="submit" style="display: none;">
                                                <i class="fa fa-paper-plane" data-commentText="' . $comments . '" data-cmtId="' . $commentId . '" data-postId="' . $comment->group_post_id . '" aria-hidden="true"></i>
                                            </button>
                                            <button class="textarea-cancel-btn" style="display: none;">Cancel</button>
                                        </div>
                                        <ul class="coment-react">
                                            <li class="comment-like"><a href="#">Like(0)</a></li>
                                            <li><a href="javascript:void(0)" class="replay-tag">Replay</a></li>
                                        </ul>
                                    </div>
                                    <!-- child comment start  -->
                                    <div class="child-comment">

                                        <div class="single-replay-comnt nested-comment-' . $commentId . '">


                                        </div>';


                        if (count($comment->replies) > 0) {

                            $html .= '<div class="more-comment mt-2">
                                                <a class="loadChildCmt" data-postIdd="' . $comment->group_post_id . '"
                                                   data-commentId="' . $commentId . '">
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
                                                        class="count">('.count($comment->replies).')</span></a>
                                            </div>';
                        }


                        $html .= '   <div class="new-comment replay-new-comment">';


                        if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0] : '') {
                            if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0] : '') {
                                $html .= '  <a href = "" class="new-comment-img replay-comment-img" ><img
                                                            src = "' . asset("storage/community/profile-picture/" . $comment->users->userProfileImages[0]->user_profile) . '"
                                                            alt = "image" ></a >';
                            }else {
                                $html .= '<a href="" class="new-comment-img replay-comment-img"><img src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '"
                                                            alt="image">
                                                    </a>';

                            }
                        } else {
                            $html .= '<a href="" class="new-comment-img replay-comment-img"><img src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '"
                                                            alt="image">
                                                    </a>';

                        }


                        $html .= '<div class="new-comment-input replay-commnt-input">
                                                <input data-cmtId="' . $commentId . '" class="cmtText" type="text"
                                                       name="cmttext" data-userPostId="' . $comment->group_post_id . '"
                                                       placeholder="Write a comment....">
                                                <div class="attached-icon">
                                                    <a href="#"><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>';

                    }
                }

                $returnResult = [
                    'status' => true,
                    'msg' => 'Successfully Added',
                    'postComments' => $newPostComments,
                    'html' => $html
                ];
            }

            elseif ($request->get('reqType') === 'pagePostChildCmt') {

                $postComments = CommunityPagePostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('page_post_id', '=', $request->get('postId'))
                    ->where('page_post_comment_id', '=', $request->get('cmtId'))
                    ->get();
//            dd($postComments);
                $html = '';
//            dd($postComments);

                foreach ($postComments as $comment) {

                    $date = Carbon::parse($comment->created_at)->diffForHumans();
                    $userName = $comment->userPosts->users->name;
                    $comments = $comment->comment_text;
                    $commentId = $comment->id;
                    $userProfilePicture = isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '';

                    $html .= '<div class="single-replay-comnt nested-comment-' . $commentId . '">
                                                <div class="replay-coment-box comment-details">
                                                    <div class="replay-comment-img">';
                    if (isset($userProfilePicture)) {
                        $html .= '<a href="#"> <img src="' . asset("storage/community/profile-picture/$userProfilePicture") . '" alt="image">
                                </a>';
                    } else {
                        $html .= '<a><img src="' . asset("community-frontend/assets/images/community/home/news-post/comment01.jpg") . '"alt="image"></a>';

                    }
                    $html .= '</div>
                                                    <div class="replay-comment-details comment-details">
                                                        <div class="replay-coment-info coment-info">
                                                            <div>
                                                                <h6><a class="replay-comnt-name" href="#">' . $userName . '</a></h6>
                                                                <span class="replay-time-comnt">' . $date . '</span>
                                                            </div>';
                    if ($comment->user_id === Auth::id()) {
                        $html .= '<div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1">
                                                        <li class="post-option-item" id="editComment"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit comment</li>
                                                        <li class="post-option-item dltComment" data-commentId="' . $commentId . '"><i class="fa fa-trash-o" aria-hidden="true"></i>  Delete comment</li>
                                                    </ul>
                                                </div>';
                    }
                    $html .= ' </div>
                                                        <div class="comment-div">
                                                            <p class="comment-content">' . $comments . '</p>
                                                            <button  class="textarea-btn" type="submit">
                                                            <i class="fa fa-paper-plane" data-commentText="' . $comments . '" data-cmtId="' . $commentId . '" data-postId="' . $comment->page_post_id . '" aria-hidden="true"></i>
                                                            </button>
                                                            <button class="textarea-cancel-btn">Cancel</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';

                }

                if ($postComments) {
                    $returnResult = [
                        'status' => true,
                        'msg' => 'Successfully Added',
                        'postComments' => json_encode($postComments),
                        'html' => $html
                    ];

                }

            }

            elseif ($request->get('reqType') === 'adminPagePostChildCmt') {

                $postComments = CommunityPagePostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('page_post_id', '=', $request->get('postId'))
                    ->where('page_post_comment_id', '=', $request->get('cmtId'))
                    ->get();
//            dd($postComments);
                $html = '';
//            dd($postComments);

                foreach ($postComments as $comment) {

                    $date = Carbon::parse($comment->created_at)->diffForHumans();
                    $userName = $comment->userPosts->users->name;
                    $comments = $comment->comment_text;
                    $commentId = $comment->id;
                    $userProfilePicture = isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '';

                    $html .= '<div class="media-block nested-comment1-'.$commentId.'">';
                    if (isset($userProfilePicture)) {
                        $html .= '<a href="#"> <img src="' . asset("storage/community/profile-picture/$userProfilePicture") . '" style="height: 40 px; width: 50px;" alt="image">
                                </a>';
                    } else {
                        $html .= '<a><img src="' . asset("community-frontend/assets/images/community/home/news-post/comment01.jpg") . '"alt="image"></a>';

                    }
                    $html .= '<div class="media-body">
                                                <div class="mar-btm">
                                                    <a href="#" class="btn-link text-semibold media-heading box-inline">' . $userName . '</a>
                                                    <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i> -
                                                        From Mobile - ' . $date . '</p>
                                                </div>
                                                <p>' . $comments . '</p>
                                                <div class="pad-ver">
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm btn-default btn-hover-danger dltComment" data-commentId="' . $commentId . '" href="#"><i
                                                    class="fa fa-trash text-danger"></i></a>
                                                    </div>
                                                    <a class="btn btn-sm btn-default btn-hover-primary"
                                                       href="#">Report</a>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>';

                }

                if ($postComments) {
                    $returnResult = [
                        'status' => true,
                        'msg' => 'Successfully Added',
                        'postComments' => $postComments,
                        'html' => $html
                    ];

                }

            }



            elseif ($request->get('reqType') === 'groupPostChildCmt') {
//                dd(1);

                $postComments = CommunityUserGroupPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('group_post_id', '=', $request->get('postId'))
                    ->where('group_post_comment_id', '=', $request->get('cmtId'))
                    ->get();
//            dd($postComments);
                $html = '';
//            dd($postComments);

                foreach ($postComments as $comment) {

                    $date = Carbon::parse($comment->created_at)->diffForHumans();
                    $userName = $comment->userPosts->users->name;
                    $comments = $comment->comment_text;
                    $commentId = $comment->id;
                    $userProfilePicture = isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '';

                    $html .= '<div class="single-replay-comnt nested-comment-' . $commentId . '">
                                                <div class="replay-coment-box comment-details">
                                                    <div class="replay-comment-img">';
                    if (!empty($userProfilePicture) && isset($userProfilePicture)) {
                        $html .= '<a href="#"> <img src="' . asset("storage/community/profile-picture/$userProfilePicture") . '" alt="image">
                                </a>';
                    } else {
                        $html .= '<a><img src="' . asset("community-frontend/assets/images/community/home/news-post/comment01.jpg") . '"alt="image"></a>';

                    }
                    $html .= '</div>
                                                    <div class="replay-comment-details comment-details">
                                                        <div class="replay-coment-info coment-info">
                                                            <div>
                                                                <h6><a class="replay-comnt-name" href="#">' . $userName . '</a></h6>
                                                                <span class="replay-time-comnt">' . $date . '</span>
                                                            </div>';
                    if ($comment->user_id === Auth::id()) {
                        $html .= '<div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1">
                                                        <li class="post-option-item" id="editComment"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit comment</li>
                                                        <li class="post-option-item dltComment" data-commentId="' . $commentId . '"><i class="fa fa-trash-o" aria-hidden="true"></i>  Delete comment</li>
                                                    </ul>
                                                </div>';
                    }
                    $html .= ' </div>
                                                        <div class="comment-div">
                                                            <p class="comment-content">' . $comments . '</p>
                                                            <button  class="textarea-btn" type="submit">
                                                            <i class="fa fa-paper-plane" data-commentText="' . $comments . '" data-cmtId="' . $commentId . '" data-postId="' . $comment->group_post_id . '" aria-hidden="true"></i>
                                                            </button>
                                                            <button class="textarea-cancel-btn">Cancel</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';

                }

                if ($postComments) {
//                    dd($postComments, 1);

                    $returnResult = [
                        'status' => true,
                        'msg' => 'Successfully Added',
                        'postComments' => json_encode($postComments),
                        'html' => $html
                    ];

                }

            }
            elseif ($request->get('reqType') === 'adminGroupPostChildCmt') {
//                dd(1);

                $postComments = CommunityUserGroupPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('group_post_id', '=', $request->get('postId'))
                    ->where('group_post_comment_id', '=', $request->get('cmtId'))
                    ->get();
//            dd($postComments);
                $html = '';
//            dd($postComments);

                foreach ($postComments as $comment) {

                    $date = Carbon::parse($comment->created_at)->diffForHumans();
                    $userName = $comment->userPosts->users->name;
                    $comments = $comment->comment_text;
                    $commentId = $comment->id;
                    $userProfilePicture = isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '';


                    $html .= '<div class="media-block nested-comment1-'.$commentId.'">';
                    if (isset($userProfilePicture)) {
                        $html .= '<a href="#"> <img src="' . asset("storage/community/profile-picture/$userProfilePicture") . '" style="height: 40 px; width: 50px;" alt="image">
                                </a>';
                    } else {
                        $html .= '<a><img src="' . asset("community-frontend/assets/images/community/home/news-post/comment01.jpg") . '"alt="image"></a>';

                    }
                    $html .= '<div class="media-body">
                                                <div class="mar-btm">
                                                    <a href="#" class="btn-link text-semibold media-heading box-inline">' . $userName . '</a>
                                                    <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i> -
                                                        From Mobile - ' . $date . '</p>
                                                </div>
                                                <p>' . $comments . '</p>
                                                <div class="pad-ver">
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm btn-default btn-hover-danger dltComment" data-commentId="' . $commentId . '" href="#"><i
                                                    class="fa fa-trash text-danger"></i></a>
                                                    </div>
                                                    <a class="btn btn-sm btn-default btn-hover-primary"
                                                       href="#">Report</a>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>';

                }

                if ($postComments) {
                    $returnResult = [
                        'status' => true,
                        'msg' => 'Successfully Added',
                        'postComments' => $postComments,
                        'html' => $html
                    ];

                }

            }
            elseif ($request->get('reqTyp') === 'pageCmt') {

                $postComment = CommunityPagePostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('page_post_id', '=', $request->get('pPostId'))
                    ->where('page_post_comment_id', '=', 0)
                    ->whereNotIn('community_page_post_comments.id', (array)json_decode($request->get('commentId'), true, 512, JSON_THROW_ON_ERROR))
                    ->latest()->get();


                $html = '';
                if ($postComment) {

//                    dd($postComment);
                    foreach ($postComment as $comment) {

//                        dd($comment);

                        $date = Carbon::parse($comment->created_at)->diffForHumans();
                        $userName = $comment->userPosts->users->name;
                        $comments = $comment->comment_text;
                        $commentId = $comment->id;
                        $userProfilePicture = isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '';

                        $html .= '<li class="single-comment post-Comment-' . $commentId . '">
                                <div class="parent-comment">
                                    <div class="replay-comment-img comment-img">';
                        if (!empty($userProfilePicture) && isset($userProfilePicture)) {
                            $html .= '<a href="#"> <img src="' . asset("storage/community/profile-picture/$userProfilePicture") . '" alt="image">
                                </a>';
                        } else {
                            $html .= '<a><img src="' . asset("community-frontend/assets/images/community/home/news-post/comment01.jpg") . '"alt="image"></a>';

                        }
                        $html .= ' </div>
                                    <div class="comment-details">
                                        <div class="coment-info">
                                            <div class="coment-authore-div">
                                                <h6><a href="#">' . $userName . '</a></h6>
                                                <span class="comment-time">' . $date . '</span>
                                            </div>';
                        if ($comment->user_id === Auth::id()) {

                            $html .= '<div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1" style="">
                                                        <li class="post-option-item" id="editComment">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                            Edit Comment
                                                        </li>
                                                        <li class="post-option-item dltComment" data-commentId="' . $commentId . '">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            Delete comment
                                                        </li>
                                                    </ul>
                                                </div>';

                        } else {
                            $html .= '<div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1" style="">

                                                        <li class="post-option-item dltComment" data-commentId="' . $commentId . '">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            Delete comment
                                                        </li>
                                                    </ul>
                                                </div>';
                        }

                        $html .= '
                                        </div>

                                        <div class="comment-div">
                                            <p class="comment-content">' . $comments . '</p>

                                            <button class="textarea-btn" type="submit" style="display: none;">
                                                <i class="fa fa-paper-plane" data-commentText="' . $comments . '" data-cmtId="' . $commentId . '" data-postId="' . $comment->page_post_id . '" aria-hidden="true"></i>
                                            </button>
                                            <button class="textarea-cancel-btn" style="display: none;">Cancel</button>
                                        </div>
                                        <ul class="coment-react">
                                            <li class="comment-like"><a href="#">Like(0)</a></li>
                                            <li><a href="javascript:void(0)" class="replay-tag">Replay</a></li>
                                        </ul>
                                    </div>
                                    <!-- child comment start  -->
                                    <div class="child-comment">

                                        <div class="single-replay-comnt nested-comment-' . $commentId . '">


                                        </div>';


                        if (count($comment->replies) > 0) {

                            $html .= '<div class="more-comment mt-2">
                                                <a class="loadChildCmt" data-postIdd="' . $comment->page_post_id . '"
                                                   data-commentId="' . $commentId . '">
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
                                                        class="count">(0)</span></a>
                                            </div>';
                        }


                        $html .= '   <div class="new-comment replay-new-comment">';


                        if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0] : '') {
                            if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0] : '') {
                                $html .= '  <a href = "" class="new-comment-img replay-comment-img" ><img
                                                            src = "' . asset("storage/community/profile-picture/" . $comment->users->userProfileImages[0]->user_profile) . '"
                                                            alt = "image" ></a >';
                            }else {
                                $html .= '<a  class="new-comment-img replay-comment-img" href=""><img src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '"
                                                            alt="image">
                                                    </a>';

                            }
                        } else {
                            $html .= '<a  class="new-comment-img replay-comment-img" href=""><img src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '"
                                                            alt="image">
                                                    </a>';

                        }


                        $html .= '<div class="new-comment-input replay-commnt-input">
                                                <input data-cmtId="' . $commentId . '" class="cmtText" type="text"
                                                       name="cmttext" data-userPostId="' . $comment->page_post_id . '"
                                                       placeholder="Write a comment....">
                                                <div class="attached-icon">
                                                    <a href="#"><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>';

                    }


                    $returnResult = [
                        'status' => true,
                        'msg' => 'Successfully Added',
                        'postComments' => $postComment,
                        'html' => $html
                    ];


                }

            }
            elseif ($request->get('reqTyp') === 'userAllCmt') {

                $newPostComments = CommunityUserPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('user_post_id', '=', $request->get('pPostId'))
                    ->where('user_post_comment_id', '=', 0)
                    ->whereNotIn('community_user_post_comments.id', (array)json_decode($request->get('commentId'), true, 512, JSON_THROW_ON_ERROR))
                    ->latest()->get();
                $html = '';


                if ($newPostComments) {

                    foreach ($newPostComments as $comment) {

//                        dd($comment);

                        $date = Carbon::parse($comment->created_at)->diffForHumans();
                        $userName = $comment->userPosts->users->name;
                        $comments = $comment->comment_text;
                        $commentId = $comment->id;
                        $userProfilePicture = isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '';

                        $html .= '<li class="single-comment post-Comment-' . $commentId . '">
                                <div class="parent-comment">
                                    <div class="replay-comment-img comment-img">';
                        if (isset($userProfilePicture)) {
                            $html .= '<a href="#"> <img src="' . asset("storage/community/profile-picture/$userProfilePicture") . '" alt="image">
                                </a>';
                        } else {
                            $html .= '<a><img src="' . asset("community-frontend/assets/images/community/home/news-post/comment01.jpg") . '"alt="image"></a>';

                        }
                        $html .= ' </div>
                                    <div class="comment-details">
                                        <div class="coment-info">
                                            <div class="coment-authore-div">
                                                <h6><a href="#">' . $userName . '</a></h6>
                                                <span class="comment-time">' . $date . '</span>
                                            </div>';
                        if ($comment->user_id === Auth::id()) {

                            $html .= '<div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1" style="">
                                                        <li class="post-option-item" id="editComment">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                            Edit Comment
                                                        </li>
                                                        <li class="post-option-item dltComment" data-commentId="' . $commentId . '">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            Delete comment
                                                        </li>
                                                    </ul>
                                                </div>';

                        } else {
                            $html .= '<div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1" style="">

                                                        <li class="post-option-item dltComment" data-commentId="' . $commentId . '">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            Delete comment
                                                        </li>
                                                    </ul>
                                                </div>';
                        }

                        $html .= '
                                        </div>

                                        <div class="comment-div">
                                            <p class="comment-content">' . $comments . '</p>

                                            <button class="textarea-btn" type="submit" style="display: none;">
                                                <i class="fa fa-paper-plane" data-commentText="' . $comments . '" data-cmtId="' . $commentId . '" data-postId="' . $comment->user_post_id . '" aria-hidden="true"></i>
                                            </button>
                                            <button class="textarea-cancel-btn" style="display: none;">Cancel</button>
                                        </div>
                                        <ul class="coment-react">
                                            <li class="comment-like"><a href="#">Like(0)</a></li>
                                            <li><a href="javascript:void(0)" class="replay-tag">Replay</a></li>
                                        </ul>
                                    </div>
                                    <!-- child comment start  -->
                                    <div class="child-comment">

                                        <div class="single-replay-comnt nested-comment-' . $commentId . '">


                                        </div>';


                        if (count($comment->replies) > 0) {

                            $html .= '<div class="more-comment mt-2">
                                                <a class="loadChildCmt" data-postIdd="' . $comment->user_post_id . '"
                                                   data-commentId="' . $commentId . '">
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
                                                        class="count">(0)</span></a>
                                            </div>';
                        }


                        $html .= '   <div class="new-comment replay-new-comment">';


                        if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0] : '') {
                            if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0] : '') {
                                $html .= '  <a href = "" class="new-comment-img replay-comment-img" ><img
                                                            src = "' . asset("storage/community/profile-picture/" . $comment->users->userProfileImages[0]->user_profile) . '"
                                                            alt = "image" ></a >';
                            }else {
                                $html .= '<a href=""><img src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '"
                                                            alt="image">
                                                    </a>';

                            }
                        } else {
                            $html .= '<a href=""><img src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '"
                                                            alt="image">
                                                    </a>';

                        }


                        $html .= '<div class="new-comment-input replay-commnt-input">
                                                <input data-cmtId="' . $commentId . '" class="cmtText" type="text"
                                                       name="cmttext" data-userPostId="' . $comment->user_post_id . '"
                                                       placeholder="Write a comment....">
                                                <div class="attached-icon">
                                                    <a href="#"><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>';

                    }


                }
                $returnResult = [
                    'status' => true,
                    'msg' => 'Successfully Added',
                    'postComments' => $newPostComments,
                    'html' => $html
                ];

            }


            return response()->json(
                $returnResult
            );
        }
    }

}

