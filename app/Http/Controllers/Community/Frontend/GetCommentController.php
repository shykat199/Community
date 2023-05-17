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

                $postComments = CommunityUserGroupPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('group_post_id', '=', $request->get('gPostId'))
                    ->where('group_post_comment_id', '=', 0)
                    ->get();

                $postComments=count($postComments);
                $postComments=CommunityUserGroupPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('group_post_id', '=', $request->get('gPostId'))
                    ->where('group_post_comment_id', '=', 0)
                    ->limit($postComments-2)->offset(2)->get();

//            dd($postComments);
                $html = '';

                if ($postComments) {

//                    dd($postComment);
                    foreach ($postComments as $comment) {
//                        dd($comment);
                        $date = Carbon::parse($comment->created_at)->diffForHumans();
                        $userName = $comment->userPosts->users->name;
                        $comments = $comment->comment_text;
                        $commentId = $comment->id;
                        $html .= '<li class="single-comment">
                                    <!-- parent comment start  -->
                                    <div class="parent-comment">
                                        <div class="comment-img">';
                        if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {

                            if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {

                                $html .= '<a href=""><img
                                                        src="' . asset("storage/community/profile-picture/" . $comment->users->userProfileImages[0]->user_profile) . '"
                                                        alt="image"></a>';
                            }

                        }

                        $html .= '
                                        </div>
                                        <div class="comment-details">
                                            <div class="coment-info">
                                                <div class="coment-authore-div">
                                                    <h6><a href="#">' . $userName . '</a></h6>
                                                    <span class="comment-time">' . $date . '</span>
                                                </div>
                                                <div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1">
                                                        <li class="post-option-item" id="editComment"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit comment</li>
                                                        <li class="post-option-item"><i class="fa fa-trash-o" aria-hidden="true"></i>  Delete comment</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="comment-div">
                                                <p class="comment-content">' . $comments . '</p>
                                            <button id="textarea_btn" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                            </button>
                                            </div>
                                            <ul class="coment-react">
                                                <li class="comment-like"><a href="#">Like(2)</a></li>
                                                <li><a href="javascript:void(0)" class="replay-tag">Replay</a></li>
                                            </ul>
                                        </div>';

                        if (count($comment->replies)>0) {

                            $html .= '<div class="more-comment">
                                        <a class="loadChildCmt" data-postIdd="' . $comment->group_post_id . '" data-commentId="'.$comment->id.'">More+</a>
                                    </div>';
                        }

                        $html .= ' <!-- child comment start  -->
                        <div class="child-comment">

                        <div class="single-replay-comnt nested-comment-'.$comment->id.'"></div>

                        <div class="new-comment replay-new-comment">';

                        if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {

                            if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {

                                $html .= '<a class="new-comment-img replay-comment-img"><img
                                                        src="' . asset("storage/community/profile-picture/" . $comment->users->userProfileImages[0]->user_profile) . '"
                                                        alt="image"></a>';
                            }

                        }
                        $html .= ' <div class="new-comment-input replay-commnt-input">
                                                <input data-cmtId="' . $comment->id . '" class="cmtText" type="text"
                                                       name="cmttext"
                                                       data-userPostId="' . $comment->group_post_id . '"
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
                        'postComments' => json_encode($postComments),
                        'html' => $html
                    ];


                }

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
                    $userProfilePicture = $comment->users->userProfileImages[0]->user_profile;

                    $html .= '<div class="single-replay-comnt nested-comment-' . $comment->id . '">
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
                                                            </div>
                                                            <div class="comment-option">
                                                                <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                                                                <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1">
                                                                    <li class="post-option-item" id="editComment"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit comment</li>
                                                                    <li class="post-option-item"><i class="fa fa-trash-o" aria-hidden="true"></i>  Delete comment</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="comment-div">
                                                            <p class="comment-content">' . $comments . '</p>
                                                            <button id="textarea_btn" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                                            </button>
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

            elseif ($request->get('reqType') === 'groupPostChildCmt') {

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
                    $userProfilePicture = $comment->users->userProfileImages[0]->user_profile;

                    $html .= '<div class="single-replay-comnt nested-comment-' . $comment->id . '">
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
                                                            </div>
                                                            <div class="comment-option">
                                                                <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                                                                <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1">
                                                                    <li class="post-option-item" id="editComment"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit comment</li>
                                                                    <li class="post-option-item"><i class="fa fa-trash-o" aria-hidden="true"></i>  Delete comment</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="comment-div">
                                                            <p class="comment-content">' . $comments . '</p>
                                                            <button id="textarea_btn" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                                            </button>
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

            elseif ($request->get('reqTyp') === 'pageCmt') {

                $postComment = CommunityPagePostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('page_post_id', '=', $request->get('pPostId'))
                    ->where('page_post_comment_id', '=', 0)
                    ->get();

                $postComment=count($postComment);
                $postComment=CommunityPagePostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('page_post_id', '=', $request->get('pPostId'))
                    ->where('page_post_comment_id', '=', 0)
                    ->limit($postComment-2)->offset(2)->get();


                $html = '';
                if ($postComment) {

//                    dd($postComment);
                    foreach ($postComment as $comment) {
//                        dd($comment);
                        $date = Carbon::parse($comment->created_at)->diffForHumans();
                        $userName = $comment->userPosts->users->name;
                        $comments = $comment->comment_text;
                        $commentId = $comment->id;
                        $html .= '<li class="single-comment">
                                    <!-- parent comment start  -->
                                    <div class="parent-comment">
                                        <div class="comment-img">';
                        if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {

                            if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {

                                $html .= '<a href=""><img
                                                        src="' . asset("storage/community/profile-picture/" . $comment->users->userProfileImages[0]->user_profile) . '"
                                                        alt="image"></a>';
                            }

                        }

                        $html .= '
                                        </div>
                                        <div class="comment-details">
                                            <div class="coment-info">
                                                <div class="coment-authore-div">
                                                    <h6><a href="#">' . $userName . '</a></h6>
                                                    <span class="comment-time">' . $date . '</span>
                                                </div>
                                                <div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1">
                                                        <li class="post-option-item" id="editComment"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit comment</li>
                                                        <li class="post-option-item"><i class="fa fa-trash-o" aria-hidden="true"></i>  Delete comment</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="comment-div">
                                                <p class="comment-content">' . $comments . '</p>
                                            <button id="textarea_btn" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                            </button>
                                            </div>
                                            <ul class="coment-react">
                                                <li class="comment-like"><a href="#">Like(2)</a></li>
                                                <li><a href="javascript:void(0)" class="replay-tag">Replay</a></li>
                                            </ul>
                                        </div>';

                        if (count($comment->replies)>0) {

                            $html .= '<div class="more-comment">
                                        <a class="loadChildCmt" data-postIdd="' . $comment->page_post_id . '" data-commentId="'.$comment->id.'">More+</a>
                                    </div>';
                        }

                        $html .= '<div class="child-comment">
                        <div class="single-replay-comnt nested-comment-'.$comment->id.'"></div>
                        <div class="new-comment replay-new-comment">';

                        if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {

                            if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {

                                $html .= '<a class="new-comment-img replay-comment-img"><img
                                                        src="' . asset("storage/community/profile-picture/" . $comment->users->userProfileImages[0]->user_profile) . '"
                                                        alt="image"></a>';
                            }

                        }
                        $html .= ' <div class="new-comment-input replay-commnt-input">
                                                <input data-cmtId="' . $comment->id . '" class="cmtText" type="text"
                                                       name="cmttext"
                                                       data-userPostId="' . $comment->page_post_id . '"
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
                        'postComments' => json_encode($postComment),
                        'html' => $html
                    ];


                }

            }

//            elseif ($request->get('reqTyp') === 'userPostChildCmt') {
//
//                $postComment = CommunityUserPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
//                    ->where('page_post_id', '=', $request->get('pPostId'))
//                    ->where('page_post_comment_id', '=', 0)
//                    ->get();
//
//                $html = '';
//                if ($postComment) {
//
////                    dd($postComment);
//                    foreach ($postComment as $comment) {
////                        dd($comment);
//                        $date = Carbon::parse($comment->created_at)->diffForHumans();
//                        $userName = $comment->userPosts->users->name;
//                        $comments = $comment->comment_text;
//                        $commentId = $comment->id;
//                        $html .= '<li class="single-comment">
//                                    <!-- parent comment start  -->
//                                    <div class="parent-comment">
//                                        <div class="comment-img">';
//                        if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {
//
//                            if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {
//
//                                $html .= '<a href=""><img
//                                                        src="' . asset("storage/community/profile-picture/" . $comment->users->userProfileImages[0]->user_profile) . '"
//                                                        alt="image"></a>';
//                            }
//
//                        }
//
//                        $html .= '
//                                        </div>
//                                        <div class="comment-details">
//                                            <div class="coment-info">
//                                                <div class="coment-authore-div">
//                                                    <h6><a href="#">' . $userName . '</a></h6>
//                                                    <span class="comment-time">' . $date . '</span>
//                                                </div>
//                                                <div class="comment-option">
//                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
//                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1">
//                                                        <li class="post-option-item" id="editComment"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit comment</li>
//                                                        <li class="post-option-item"><i class="fa fa-trash-o" aria-hidden="true"></i>  Delete comment</li>
//                                                    </ul>
//                                                </div>
//                                            </div>
//                                            <div class="comment-div">
//                                                <p class="comment-content">' . $comments . '</p>
//                                            <button id="textarea_btn" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>
//                                            </button>
//                                            </div>
//                                            <ul class="coment-react">
//                                                <li class="comment-like"><a href="#">Like(2)</a></li>
//                                                <li><a href="javascript:void(0)" class="replay-tag">Replay</a></li>
//                                            </ul>
//                                        </div>';
//
//                        if (count($comment->replies)>0) {
//
//                            $html .= '<div class="more-comment">
//                                        <a class="checkCmt" data-postIdd="' . $comment->page_post_id . '">More+</a>
//                                    </div>';
//                        }
//
//                        $html .= '<div class="child-comment">
//
//                        <div class="new-comment replay-new-comment">';
//
//                        if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {
//
//                            if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {
//
//                                $html .= '<a class="new-comment-img replay-comment-img"><img
//                                                        src="' . asset("storage/community/profile-picture/" . $comment->users->userProfileImages[0]->user_profile) . '"
//                                                        alt="image"></a>';
//                            }
//
//                        }
//                        $html .= ' <div class="new-comment-input replay-commnt-input">
//                                                <input data-cmtId="' . $comment->id . '" class="cmtText" type="text"
//                                                       name="cmttext"
//                                                       data-userPostId="' . $comment->page_post_id . '"
//                                                       placeholder="Write a comment....">
//                                                <div class="attached-icon">
//                                                    <a href="#"><i class="fa fa-camera" aria-hidden="true"></i></a>
//                                                </div>
//                                            </div>
//                                        </div>
//                                    </div>
//                                </div>
//                                </li>';
//                    }
//
//
//                    $returnResult = [
//                        'status' => true,
//                        'msg' => 'Successfully Added',
//                        'postComments' => json_encode($postComment),
//                        'html' => $html
//                    ];
//
//
//                }
//
//            }
            elseif ($request->get('reqTyp') === 'userAllCmt') {

                $postComment = CommunityUserPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('user_post_id', '=', $request->get('pPostId'))
                    ->where('user_post_comment_id', '=', 0)
                    ->get();
//                dd($postComment);
                $postCount=count($postComment);
                $postComment=CommunityUserPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('user_post_id', '=', $request->get('pPostId'))
                    ->where('user_post_comment_id', '=', 0)
                    ->limit($postCount-2)->offset(2)->get();
                $html = '';
                if ($postComment) {

//                    dd($postComment);
                    foreach ($postComment as $comment) {
//                        dd($comment);
                        $date = Carbon::parse($comment->created_at)->diffForHumans();
                        $userName = $comment->userPosts->users->name;
                        $comments = $comment->comment_text;
                        $commentId = $comment->id;
                        $html .= '<li class="single-comment">
                                    <!-- parent comment start  -->
                                    <div class="parent-comment">
                                        <div class="comment-img">';
                        if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {

                            if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {

                                $html .= '<a href=""><img
                                                        src="' . asset("storage/community/profile-picture/" . $comment->users->userProfileImages[0]->user_profile) . '"
                                                        alt="image"></a>';
                            }

                        }

                        $html .= '
                                        </div>
                                        <div class="comment-details">
                                            <div class="coment-info">
                                                <div class="coment-authore-div">
                                                    <h6><a href="#">' . $userName . '</a></h6>
                                                    <span class="comment-time">' . $date . '</span>
                                                </div>
                                                <div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1">
                                                        <li class="post-option-item" id="editComment"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit comment</li>
                                                        <li class="post-option-item"><i class="fa fa-trash-o" aria-hidden="true"></i>  Delete comment</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="comment-div">
                                                <p class="comment-content">' . $comments . '</p>
                                            <button id="textarea_btn" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                            </button>
                                            </div>
                                            <ul class="coment-react">
                                                <li class="comment-like"><a href="#">Like(2)</a></li>
                                                <li><a href="javascript:void(0)" class="replay-tag">Replay</a></li>
                                            </ul>
                                        </div>';

                        if (count($comment->replies)>0) {

                            $html .= '<div class="more-comment">
                                        <a class="loadChildCmt" data-postIdd="' . $comment->user_post_id . '" data-commentId="'.$comment->id.'">More+</a>
                                    </div>';
                        }

                        $html .= '
                        <!-- child comment start  -->
                        <div class="child-comment">

                        <div class="single-replay-comnt nested-comment-'.$comment->id.'"></div>
                        <div class="new-comment replay-new-comment">';

                        if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {

                            if (!empty($comment->users->userProfileImages[0]) && isset($comment->users->userProfileImages[0]) ? $comment->users->userProfileImages[0]->user_profile : '') {

                                $html .= '<a class="new-comment-img replay-comment-img"><img
                                                        src="' . asset("storage/community/profile-picture/" . $comment->users->userProfileImages[0]->user_profile) . '"
                                                        alt="image"></a>';
                            }

                        }
                        $html .= ' <div class="new-comment-input replay-commnt-input">
                                                <input data-cmtId="' . $comment->id . '" class="cmtText" type="text"
                                                       name="cmtText"
                                                       data-userPostId="' . $comment->user_post_id . '"
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
                        'postComments' => json_encode($postComment),
                        'html' => $html
                    ];


                }

            }

            return response()->json(
                $returnResult
            );
        }
    }

}

