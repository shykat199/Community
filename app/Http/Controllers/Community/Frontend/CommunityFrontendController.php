<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Community\Group\CommunityUserGroupPostComment;
use App\Models\Community\Page\CommunityPage;
use App\Models\Community\Page\CommunityPagePostComment;
use App\Models\Community\User\CommunityUserDetails;
use App\Models\Community\User\CommunityUserFollowing;
use App\Models\Community\User\CommunityUserPost;
use App\Models\Community\User\CommunityUserPostFileType;
use App\Models\Community\User\CommunityUserPostTag;
use App\Models\Community\User_Post\CommunityUserPostComment;
use App\Models\Community\User_Post\CommunityUserPostReaction;
use App\Models\Community\User_Profile\CommunityUserProfileEducation;
use App\Models\Community\User_Profile\CommunityUserProfileInterest;
use App\Models\Community\User_Profile\CommunityUserProfileLanguage;
use App\Models\Community\User_Profile\CommunityUserProfileSocialink;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class CommunityFrontendController extends Controller
{

    public function index()
    {

        $friendList = [];
        $friendList[] = Auth::id();
        foreach (myFriends() as $friend) {
            $friendList[] = $friend->uId;
        }

        $allUserPosts = CommunityUserPost::with(['users.userProfileImages', 'comments.replies'])
            ->join('users', function ($q) use ($friendList) {
                $q->on('users.id', '=', 'community_user_posts.user_id');
                $q->whereIn('users.id', $friendList);
            })
            ->leftJoin('community_user_post_file_types as postMedia', function ($q) {
                $q->on('postMedia.post_id', '=', 'community_user_posts.id');
            })
            ->leftJoin('community_user_post_reactions as userPostReaction', function ($q) {
                $q->on('userPostReaction.user_post_id', '=', 'community_user_posts.id');
                $q->where('userPostReaction.user_id', '=', Auth::id());
            })
            ->selectRaw("
            users.id as user_id,users.name,
            community_user_posts.post_description as postDescription,
            community_user_posts.created_at as created_at,
            postMedia.post_id as post_id,
            postMedia.post_image_video as userPostMedia,
            postMedia.caption as caption,
            community_user_posts.id as postId,
            community_user_posts.id,
            userPostReaction.reaction_type,
            userPostReaction.id as reactionId
            ")
            ->latest()
            ->get()
            ->map(function ($q) {
                $q->setRelation('comments', $q->comments->take(2));
                return $q;
            });

        $allUserPosts = $allUserPosts->each(function ($item) {
            $item->comments->each(function ($comment) {
                $comment->load('users.userProfileImages');
            });
        });

//        dd($allUserPosts);

        return view('community-frontend.index', compact('allUserPosts'));
    }

    public function showChildComments(Request $request)
    {

        if ($request->ajax()) {


            $postComments = CommunityUserPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                ->where('user_post_id', '=', $request->get('postId'))
                ->where('user_post_comment_id', '=', $request->get('cmtId'))
                ->get();
//            dd($postComments);
            $html = '';

//            dd($request->all());

            if ($request->get('reqType')==='adminUserChildComment'){

//                dd(1);
//                dd($postComments);
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
                                                        <a class="btn btn-sm btn-default btn-hover-danger dltComment" data-commentId="' . $comment->user_post_comment_id . '" href="#"><i
                                                    class="fa fa-trash text-danger"></i></a>
                                                    </div>
                                                    <a class="btn btn-sm btn-default btn-hover-primary"
                                                       href="#">Report</a>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>';

                }

                return \response()->json([
                    'status' => true,
                    'msg' => 'Successfully Added',
                    'postComments' => $postComments,
                    'html' => $html
                ]);

            }else{
//                dd(2);
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
                                                            <i class="fa fa-paper-plane" data-commentText="' . $comments . '" data-cmtId="' . $commentId . '" data-postId="' . $comment->user_post_id . '" aria-hidden="true"></i>
                                                            </button>
                                                            <button class="textarea-cancel-btn">Cancel</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';

                }

                return \response()->json([
                    'status' => true,
                    'msg' => 'Successfully Added',
                    'postComments' => $postComments,
                    'html' => $html
                ]);
            }
        }
    }


    public function addUserFollow(Request $request)
    {


        if (\request()->ajax()) {
            $userId = $request->get('userId');
            $userName = $request->get('userName');

            $communityFollower = CommunityUserFollowing::create([
                'user_following_id' => Auth::id(),
                'user_id' => $userId
            ]);

            if ($communityFollower) {
                return \response()->json([
                    'status' => true,
                    'msg' => 'Successfully Added',
                ]);
            }

        }

    }

    public
    function storeComment(Request $request)
    {
//        dd($request->all());

        if ($request->ajax()) {

            $postComment = CommunityUserPostComment::create([
                'user_id' => Auth::id(),
                'user_post_id' => $request->get('postId'),
                'user_post_comment_id' => 0,
                'comment_text' => $request->get('postComment'),
            ]);


            $html = '';
            if ($postComment) {

                $html .= '
                        <li class="single-comment">
                            <div class="parent-comment">
                                    <div class="comment-img">';
                if (!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0]) ? $postComment->users->userProfileImages[0] : '') {
                    if (!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0]) ? $postComment->users->userProfileImages[0] : '') {
                        $html .= '<a href=""><img src="' . asset("storage/community/profile-picture/" . $postComment->users->userProfileImages[0]->user_profile) . '"
                                          alt="image"></a>';
                    }

                }

                $html .= '</div>
                                    <div class="comment-details">
                                        <div class="coment-info">
                                            <div class="coment-authore-div">
                                                <h6><a href="#">' . $postComment->users->name . '</a></h6>
                                                <span
                                                    class="comment-time">' . \Carbon\Carbon::parse($postComment->created_at)->diffForHumans() . '</span>
                                            </div>';


                if ($postComment->user_id === Auth::id()) {
                    $html .= ' <div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn"
                                                            id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                            aria-expanded="false"><i class="fa fa-ellipsis-h"
                                                                                     aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu comment-option-dropdown"
                                                        aria-labelledby="dropdownMenuButton1">
                                                        <li class="post-option-item" id="editComment">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                            Edit Comment
                                                        </li>
                                                        <li class="post-option-item dltComment"
                                                            data-commentId="' . $postComment->id . '">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            Delete comment
                                                        </li>
                                                    </ul>
                                                </div>';
                } else {
                    $html .= ' <div class="comment-option">

                                                    <button type="button" class="dropdown-toggle comment-option-btn"
                                                            id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                            aria-expanded="false"><i class="fa fa-ellipsis-h"
                                                                                     aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu comment-option-dropdown"
                                                        aria-labelledby="dropdownMenuButton1">
                                                        <li class="post-option-item dltComment"
                                                            data-commentId="' . $postComment->id . '">
                                                            <i class="fa fa-trash-o"
                                                               aria-hidden="true"></i>
                                                            Delete comment
                                                        </li>
                                                    </ul>
                                                </div>';
                }

                $html .= '</div>
                                        <div class="comment-div">
                                            <p class="comment-content">' . $postComment->comment_text . '</p>

                                            <button  class="textarea-btn" type="submit">
                                            <i class="fa fa-paper-plane" data-commentText="' . $postComment->comment_text . '" data-cmtId="' . $postComment->id . '" data-postId="' . $postComment->user_post_id . '" aria-hidden="true"></i>
                                            </button>
                                            <button class="textarea-cancel-btn">Cancel</button>
                                        </div>
                                        <ul class="coment-react">
                                            <li class="comment-like"><a href="#">Like(0)</a></li>
                                            <li><a href="javascript:void(0)" class="replay-tag">Replay</a></li>
                                        </ul>
                                    </div>';

                if (empty($postComment->replies)) {

                    $html .= '<div class="more-comment">
                                        <a class="checkCmt" data-postIdd="' . $postComment->postId . '">More+</a>
                                    </div>';
                }

                $html .= '<div class="child-comment">

                <div class="single-replay-comnt nested-comment-' . $postComment->id . '">


                </div>';

                if (empty($postComment->replies)) {
                    $html .= '<div class="more-comment mt-2">
                                                <a class="loadChildCmt" data-postIdd="' . $postComment->user_post_id . '"
                                                   data-commentId="' . $postComment->id . '">
                                                   <span class="replay-arrow">
                                                    <svg x="0" y="0" viewBox="0 0 48 48" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="m47.12 31.403-9.992-9.992a2.98 2.98 0 1 0-4.215 4.216l3.037 3.037C15.565 29.665 2.31 15.984 2.188 1.96c-.004-.507-.716-.61-.874-.144-4.922 14.579 4.03 32.89 27.427 36.201 2.266.295 4.558.519 6.868.681l-2.697 2.697a2.98 2.98 0 1 0 4.215 4.215l9.992-9.992a2.98 2.98 0 0 0 .001-4.215z" data-original="#ffcc66" class=""></path></g></svg>
                                                    </span> Replay <span class="count">(0)</span></a>
                                            </div>';
                }


                $html .= ' <div class="new-comment replay-new-comment">';

                if (!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0]) ? $postComment->users->userProfileImages[0] : '') {
                    if (!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0]) ? $postComment->users->userProfileImages[0] : '') {
                        $html .= '<a href="" class="new-comment-img replay-comment-img"><img src="' . asset("storage/community/profile-picture/" . $postComment->users->userProfileImages[0]->user_profile) . '"
                                                      alt="image"></a>';
                    }
                    else{
                        $html.='<img
                                    src="'.asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg").'" alt="image">';
                    }

                }else{

                    $html.='<img
                                    src="'.asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg").'" alt="image">';

                }
                $html .= ' <div class="new-comment-input replay-commnt-input">
                                                <input data-cmtId="' . $postComment->id . '" class="cmtText" type="text"
                                                       name="cmttext"
                                                       data-userPostId="' . $postComment->user_post_id . '"
                                                       placeholder="Write a comment....">
                                                <div class="attached-icon">
                                                    <a href="#"><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </li>';

                return \response()->json([
                    'status' => true,
//                'success' => true,
                    'data' => $postComment,
                    'msg' => 'Successfully Added.',
                    'html' => $html
                ]);
            } else {


                return \response()->json([
                    'status' => true,
//                'success' => false,
                    'data' => $postComment,
                    'msg' => 'Something wrong.',
                ]);
            }
        }


//        if ($storePostComment){
//            return \redirect()->back()->with('success','Comment Posted Successfully');
//        }else{
//            return  \redirect()->back()->with('error','Something Error');
//        }

    }

    public function storeChildComment(Request $request)
    {

        if ($request->ajax()) {

            $storeComments = CommunityUserPostComment::create([
                'user_id' => Auth::id(),
                'user_post_id' => $request->get('user_post_id'),
                'user_post_comment_id' => $request->get('cmtId'),
                'comment_text' => $request->get('cmtText'),
            ]);

            $html = '';
            if ($storeComments) {
//
                $html .= '<div class="single-replay-comnt ' . $storeComments->id . '">
                                                <div class="replay-coment-box comment-details">
                                                    <div class="replay-comment-img">';
//
                if (!empty($storeComments->users->userProfileImages[0]) && isset($storeComments->users->userProfileImages[0]) ? $storeComments->users->userProfileImages[0]->user_profile : '') {
                    if (!empty($storeComments->users->userProfileImages[0]) && isset($storeComments->users->userProfileImages[0]) ? $storeComments->users->userProfileImages[0]->user_profile : '') {
                        $html .= '<a href=""><img src="' . asset("storage/community/profile-picture/" . $storeComments->users->userProfileImages[0]->user_profile) . '"
                                                                          alt="image"></a>';
                    }

                } else {
                    $html .= '<img src="' . asset("community-frontend/assets/images/community/home/news-post/comment01.jpg") . '"alt="image">';

                }

                $html .= '</div>
                                                    <div class="replay-comment-details comment-details">
                                                        <div class="replay-coment-info coment-info">
                                                            <div>
                                                                <h6><a class="replay-comnt-name" href="#">' . Auth::user()->name . '</a></h6>
                                                                <span class="replay-time-comnt">' . \Carbon\Carbon::parse($storeComments->created_at)->diffForHumans() . '</span>
                                                            </div>';

                if ($storeComments->user_id === Auth::id()) {
                    $html .= '<div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1" style="">
                                                        <li class="post-option-item" id="editComment"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit comment</li>
                                                        <li class="post-option-item dltComment" data-commentId="' . $storeComments->id . '"><i class="fa fa-trash-o" aria-hidden="true"></i>  Delete comment</li>
                                                    </ul>
                                                </div> ';
                } else {
                    $html .= '<div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1" style="">
                                                        <li class="post-option-item dltComment" data-commentId="' . $storeComments->id . '"><i class="fa fa-trash-o" aria-hidden="true"></i>  Delete comment</li>
                                                    </ul>
                                                </div> ';
                }


                $html .= ' </div>
                                                        <div class="comment-div">
                                                            <p class="comment-content">' . $storeComments->comment_text . '</p>
                                                            <button class="textarea-btn" type="submit" style="display: none;">
                                                            <i class="fa fa-paper-plane" data-commenttext="check Child" data-cmtId="' . $storeComments->id . '" data-postId="' . $storeComments->user_post_id . ' aria-hidden="true"></i>
                                                            </button>
                                                            <button class="textarea-cancel-btn" style="display: none;">Cancel</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';

            }

            return \response()->json([
                'status' => true,
                'msg' => 'Successfully Added',
                'data' => $html
            ]);

        }

    }


    public function showComments(Request $request)
    {

        if ($request->ajax()) {

            $returnResult = [];
            $html = '';

            $postComments = CommunityUserPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                ->where('user_post_id', '=', $request->get('postId'))
                ->where('user_post_comment_id', '=', 0)
                ->get();

            if ($request->get('reqType') === "videoComments") {

                foreach ($postComments as $comment) {

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
                            $html .= '  <a href = "" class="new-comment-img replay-comment-img" >
                                            <img
                                                            src = "' . asset("storage/community/profile-picture/" . $comment->users->userProfileImages[0]->user_profile) . '"
                                                            alt = "image" ></a >';
                        }
                    } else {
                        $html .= '<a href="" class="new-comment-img replay-comment-img">
                        <img src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '"
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


                $returnResult = [
                    'status' => true,
                    'msg' => 'Successfully Added',
                    'postComments' => $postComments,
                    'html' => $html
                ];

            } else {

//                $postComments = count($postComments);
                $newPostComments = CommunityUserPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('user_post_id', '=', $request->get('postId'))
                    ->where('user_post_comment_id', '=', 0)
                    ->whereNotIn('community_user_post_comments.id', (array)json_decode($request->get('commentId'), true, 512, JSON_THROW_ON_ERROR))
                    ->latest()->get();

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
                            }
                        } else {
                            $html .= '<a href="" class="new-comment-img replay-comment-img"><img src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '"
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


    public function updatePost(Request $request)
    {
//        @dd($request->all());

        if ($request->get('imageCaption') === null && $request->hasFile('postFile1') === null) {
//            dd(1);
            $userPost = CommunityUserPost::find($request->get('postId'))->update([
//                'user_id' => Auth::id(),
                'post_description' => $request->get('postMessage')
            ]);

        } else {
//            dd(2);
            $fileName = null;
            if ($request->hasFile('postFile1') !== null || $request->get('imageCaption') !== null) {
//                dd(2);
                $userPost = CommunityUserPost::find($request->get('postId'))->update([
//                    'user_id' => Auth::id(),
                    'post_description' => $request->get('postMessage')
                ]);
//                dd(4);
                if ($request->hasFile('postFile1')) {
//                    dd(5);
                    if ($request->file('postFile1')->getClientOriginalExtension() == 'mp4' ||
                        $request->file('postFile1')->getClientOriginalExtension() == 'mov' || $request->file('postFile1')->getClientOriginalExtension() == 'wmv' ||
                        $request->file('postFile1')->getClientOriginalExtension() == 'avi' || $request->file('postFile1')->getClientOriginalExtension() == 'mkv' ||
                        $request->file('postFile1')->getClientOriginalExtension() == 'webm'
                    ) {
//                        dd(6);
                        $fileName = Uuid::uuid() . '.' . $request->file('postFile1')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/post/videos/' . $fileName, file_get_contents($request->file('postFile1')));
                    } else {
                        $fileName = Uuid::uuid() . '.' . $request->file('postFile1')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/post/' . $fileName, file_get_contents($request->file('postFile1')));
                    }

                }
//                dd($request->get('postId'));
                $postImageCaption = CommunityUserPostFileType::where('post_id', $request->get('postId'))->first()->update([
                    'post_image_video' => $fileName,
                    'caption' => $request->get('imageCaption'),
                ]);
            }
        }
//        if ($request->get('tagId')) {
//
//            $input['tagId'] = $request->input('tagId');
//                dd(is_array($input['tagId']));
//            if (is_array($input['tagId'])) {
//                foreach ($input['tagId'] as $key => $value) {
//                    $tagUsers = CommunityUserPostTag::insert([
//                        'user_id' => Auth::id(),
//                        'tag_user_id' => $value,
//                        'user_post_id' => $userPost->id,
//                        'created_at' => Carbon::now(),
//                        'updated_at' => Carbon::now(),
//                    ]);
//                }
//            }
//        }

        if ($userPost || $postImageCaption) {
//            toastr('dd', 'success');
            toastr()->success('Post has been updated successfully!', 'Congrats');
            return Redirect::back();
        }
        toastr()->error('An error has occurred please try again later.');

        $postId = $request->get('postId');
    }

    public function destroy($id)
    {

        $postImage = CommunityUserPostFileType::where('post_id', '=', $id)->first();

        if ($postImage) {
            $postImage = $postImage->post_image_video;
//            dd($postImage);
            $mediaExtension = explode('.', $postImage);
            if ($mediaExtension[2] == 'mp4' || $mediaExtension[2] == 'mov' || $mediaExtension[2] == 'wmv' ||
                $mediaExtension[2] == 'avi' || $mediaExtension[2] == 'mkv' || $mediaExtension[2] == 'webm'
            ) {
//                @dd(1);
                $dltVideo = Storage::delete('public/community/post/videos/' . $postImage);
                $dltPostTag = CommunityUserPostTag::where('user_post_id', '=', $id)->delete();
                $dltPostComment = CommunityUserPostComment::where('user_post_id', '=', $id)->delete();
                $dltPostTag = CommunityUserPostReaction::where('user_post_id', '=', $id)->delete();
                $dltPost = CommunityUserPost::find($id)->delete();

            } else {
                $dltImag = Storage::delete('public/community/post/' . $postImage);
                $dltPostTag = CommunityUserPostTag::where('user_post_id', '=', $id)->delete();
                $dltPostComment = CommunityUserPostComment::where('user_post_id', '=', $id)->delete();
                $dltPostTag = CommunityUserPostReaction::where('user_post_id', '=', $id)->delete();
                $dltPost = CommunityUserPost::find($id)->delete();

            }
        } else {
            $dltPostTag = CommunityUserPostTag::where('user_post_id', '=', $id)->delete();
            $dltPostComment = CommunityUserPostComment::where('user_post_id', '=', $id)->delete();
            $dltPostTag = CommunityUserPostReaction::where('user_post_id', '=', $id)->delete();
            $dltPost = CommunityUserPost::find($id)->delete();
//            dd($dltPost);
        }

        if ($dltPost) {
            return Redirect::back()->with('success', 'Post Deleted Successfully');
        } else {
            return Redirect::back()->with('error', 'Something Wrong');

        }


//        return $postImage;
//        return 'deleted';

    }

    public function userProfile($id)
    {
//        dd($id);
        $id = Crypt::decrypt($id);
//        dd($id);

        $data = [];

        $data['allUserDetails'] = User::with('userProfileImages')->join('community_user_details as userDetail', function ($q) use ($id) {
            $q->on('userDetail.user_id', '=', 'users.id');
            $q->where('userDetail.user_id', '=', $id);
            $q->where('userDetail.user_id', '!=', ADMIN_ROLE);
        })
            ->leftJoin('community_user_profile_covers as userCover', 'userCover.user_id', '=', 'users.id')
            ->leftJoin('community_user_profile_photos as userProfile', 'userProfile.user_id', '=', 'users.id')
            ->selectRaw('users.id,userDetail.birthplace,GROUP_CONCAT(userCover.user_cover ORDER BY userCover.created_at DESC) as user_cover,
        GROUP_CONCAT(userProfile.user_profile ORDER BY userProfile.created_at DESC) as user_profile')
            ->groupBy('users.id')
            ->first();

        $data['countFollower'] = CommunityUserFollowing::join('users', 'users.id', 'community_user_followings.user_id')
            ->where('community_user_followings.user_id', $id)
            ->where('users.role', '!=', ADMIN_ROLE)
            ->selectRaw('COUNT(community_user_followings.user_id) as userFollowings')
            ->groupBy('community_user_followings.user_id')
            ->get();

        $data['countFollowers'] = CommunityUserFollowing::join('users', 'users.id', 'community_user_followings.user_id')
            ->where('community_user_followings.user_following_id', $id)
            ->where('users.role', '!=', ADMIN_ROLE)
            ->selectRaw('COUNT(community_user_followings.user_id) as userFollowers')
            ->groupBy('community_user_followings.user_following_id')
            ->get();

        $data['myFriends'] = User::join('community_user_friends', function ($q) use ($id) {
            $q->on('community_user_friends.requested_user_id', '=', 'users.id');
            $q->where('users.id', '!=', ADMIN_ROLE);
            $q->where('community_user_friends.user_id', '=', $id);
        })
            ->leftJoin('community_user_profile_photos as profilePhoto', function ($q) {
                $q->on('profilePhoto.user_id', '=', 'community_user_friends.requested_user_id');
                $q->where('users.id', '!=', ADMIN_ROLE);
            })
            ->leftJoin('community_user_profile_covers as profileCover', function ($q) {
                $q->on('profileCover.user_id', '=', 'community_user_friends.requested_user_id');
                $q->where('users.id', '!=', ADMIN_ROLE);

            })
            ->leftJoin('community_user_followings as userFollowers', function ($q) {
                $q->on('userFollowers.user_id', '=', 'community_user_friends.requested_user_id');
            })
            ->leftJoin('community_user_followings as userFollowings', function ($q) {
                $q->on('userFollowings.user_following_id', '=', 'community_user_friends.requested_user_id');
            })
            ->leftJoin('community_user_details as userDetails', function ($q) {
                $q->on('userDetails.user_id', '=', 'users.id');
            })
            ->selectRaw('users.id as uId,users.name as userName,profilePhoto.user_id as profileUserId,profilePhoto.user_profile,
            profileCover.user_cover,COUNT(userFollowers.id) as userFollowers,COUNT(userFollowings.id) as userFollowings,userDetails.birthplace')
            ->groupBy('users.id')
            ->orderBy('users.name')
            ->get();

        $data['userDetails'] = CommunityUserDetails::leftJoin('users', 'users.id', 'community_user_details.user_id')
            ->leftJoin('community_user_profile_photos as userProfilePhoto', 'userProfilePhoto.user_id', 'users.id')
            ->leftJoin('community_user_profile_covers as userCoverPhoto', 'userCoverPhoto.user_id', 'users.id')
            ->leftJoin('community_user_profile_education as userProfileWork', function ($q) use ($id) {
                $q->on('users.id', '=', 'userProfileWork.user_id');
                $q->where('users.id', '=', $id);
                $q->where('userProfileWork.type', '=', 'w');
                $q->where('userProfileWork.is_present', '=', 1);
            })
            ->where('users.id', '=', $id)
            ->selectRaw('community_user_details.*,users.id as Uid,users.name,userProfilePhoto.user_profile as profilePicture,
            userCoverPhoto.user_cover as coverPicture,userProfileWork.designation')
            ->first();

        $data['allUserLanguage'] = CommunityUserProfileLanguage::where('user_id', '=', $id)->get();

        $data['countPhoto'] = CommunityUserPostFileType::join('community_user_posts as userPost', function ($q) use ($id) {
            $q->on('community_user_post_file_types.post_id', '=', 'userPost.id');
        })
            ->join('users', function ($q) use ($id) {
                $q->on('users.id', '=', 'userPost.user_id');
                $q->where('users.id', '=', $id);
            })
            ->groupBy("users.id")
            ->count();

        $data['userEducationDetails'] = CommunityUserProfileEducation::where('user_id', '=', $id)
            ->where('type', '=', 'e')
            ->get();

        $data['userWorkDetails'] = CommunityUserProfileEducation::where('user_id', '=', $id)
            ->where('type', '=', 'w')
            ->get();

        $data['userInterest'] = CommunityUserProfileInterest::where('user_id', '=', $id)
            ->get();

        $data['userSocialLinks'] = CommunityUserProfileSocialink::where('user_id', '=', $id)->pluck('link', 'name')->toArray();


        $allMyPosts = \App\Models\Community\User\CommunityUserPost::with(['users.userProfileImages', 'newsFeedComments.replies'])
            ->join('users', function ($q) use ($id) {
                $q->on('users.id', '=', 'community_user_posts.user_id');
                $q->where('users.id', '!=', ADMIN_ROLE);
                $q->where('users.id', '=', $id);
            })
            ->leftJoin('community_user_post_file_types as postMedia', function ($q) {
                $q->on('postMedia.post_id', '=', 'community_user_posts.id');
            })
            ->leftJoin('community_user_post_tags as userTag', function ($q) {
                $q->on('userTag.user_post_id', '=', 'community_user_posts.id');
            })
            ->leftJoin('users as taggedUser', function ($q) {
                $q->on('taggedUser.id', '=', 'userTag.tag_user_id');
            })
            ->leftJoin('community_user_post_reactions as userPostReaction', function ($q) use ($id) {
                $q->on('userPostReaction.user_post_id', '=', 'community_user_posts.id');
                $q->where('userPostReaction.user_id', '=', $id);
            })
            ->selectRaw('users.id as user_id,users.name as userName,community_user_posts.id as postId,community_user_posts.post_description as postDescription,community_user_posts.created_at,
        postMedia.post_image_video as postMediaFile, postMedia.caption as postMediaFileCaption,userTag.tag_user_id as taggedUser,
        userPostReaction.reaction_type,userPostReaction.id as reactionId,
        taggedUser.name as taggedUserName')
            ->latest()
            ->get()->map(function ($q) {
                $q->setRelation('newsFeedComments', $q->newsFeedComments->take(2));
                return $q;
            });

        $data['allMyPosts'] = $allMyPosts->each(function ($item) {
            $item->newsFeedComments->each(function ($comment) {
                $comment->load('users.userProfileImages');
            });
        });

        $data['countFriends'] = User::join('community_user_friends', 'community_user_friends.requested_user_id', 'users.id')
            ->where('users.id', '!=', ADMIN_ROLE)
            ->where('community_user_friends.user_id', '=', $id)
            ->groupBy('community_user_friends.user_id')
            ->count();

        $imgArray = [];
//        $data['imgArray']

        $allPhotos = User::join('community_user_posts as userPost', 'userPost.user_id', '=', 'users.id')
            ->where('userPost.user_id', '!=', ADMIN_ROLE)
            ->where('userPost.user_id', '=', $id)
            ->leftJoin('community_user_post_file_types as postFile', 'postFile.post_id', '=', 'userPost.id')
            ->where('postFile.post_image_video', 'LIKE', '%' . 'image' . '%')
            ->orderByDesc('postFile.id')->pluck('postFile.post_image_video')->toArray();

//dd($allPhotos);
        foreach ($allPhotos as $imgPhoto) {
            $mediaExtension = explode('.', $imgPhoto);
//dd($mediaExtension);
            if ($mediaExtension[2] === 'png' || $mediaExtension[2] === 'jpeg' || $mediaExtension[2] === 'jpg' || $mediaExtension[2] === 'gif') {
                $imgArray[] = $imgPhoto;
            }
        }


        $coverImgArray = [];
        $profileImgArray = [];
        $uploadedImage = [];
        $userPhotoAlbum = [];

        $allProfilePhotos = \App\Models\Community\User_Profile\CommunityUserProfilePhoto::where('user_id', '=', Auth::id())->select('user_profile');
        $allCoverProfilePhotos = \App\Models\Community\User_Profile\CommunityUserProfileCover::where('user_id', '=', Auth::id())->select('user_cover')
            ->unionAll($allProfilePhotos);
        $allPostImage = \App\Models\Community\User\CommunityUserPostFileType::leftJoin('community_user_posts', 'community_user_posts.id', '=', 'community_user_post_file_types.post_id')
            ->where('community_user_posts.user_id', '=', $id)
            ->where('community_user_post_file_types.post_image_video', 'LIKE', '%' . 'image' . '%')
            ->select('post_image_video as allPostMedia')
            ->unionAll($allCoverProfilePhotos)->get();

//    dd($allPostImage);

        foreach ($allPostImage as $imgPhoto) {

            $mediaExtension = explode('.', $imgPhoto->allPostMedia);
//        dd($mediaExtension);

            if ($mediaExtension[2] === 'png' || $mediaExtension[2] === 'jpeg' || $mediaExtension[2] === 'jpg' || $mediaExtension[2] === 'gif') {

                if ($mediaExtension[1] === 'cover-Photo') {
                    $coverImgArray[] = $imgPhoto->allPostMedia;
                    $userPhotoAlbum['pp'] = $coverImgArray;
//                dd($coverImgArray);
                } elseif ($mediaExtension[1] === 'profile-Photo') {
                    $profileImgArray[] = $imgPhoto->allPostMedia;
                    $userPhotoAlbum['pc'] = $profileImgArray;
                } elseif ($mediaExtension[1] === 'image') {
                    $uploadedImage[] = $imgPhoto->allPostMedia;
                    $userPhotoAlbum['img'] = $uploadedImage;
                }
            }
        }

        $data['recentlyAddedFriends'] = User::join('community_user_friends', function ($q) use ($id) {
            $q->on('community_user_friends.requested_user_id', '=', 'users.id');
            $q->where('users.id', '!=', ADMIN_ROLE);
            $q->where('community_user_friends.user_id', '=', $id);
        })
            ->leftJoin('community_user_profile_photos as profilePhoto', function ($q) {
                $q->on('profilePhoto.user_id', '=', 'community_user_friends.requested_user_id');
                $q->where('users.id', '!=', ADMIN_ROLE);
            })
            ->leftJoin('community_user_profile_covers as profileCover', function ($q) {
                $q->on('profileCover.user_id', '=', 'community_user_friends.requested_user_id');
                $q->where('users.id', '!=', ADMIN_ROLE);

            })
            ->leftJoin('community_user_followings as userFollowers', function ($q) {
                $q->on('userFollowers.user_id', '=', 'community_user_friends.requested_user_id');
            })
            ->leftJoin('community_user_followings as userFollowings', function ($q) {
                $q->on('userFollowings.user_following_id', '=', 'community_user_friends.requested_user_id');
            })
            ->leftJoin('community_user_details as userDetails', function ($q) {
                $q->on('userDetails.user_id', '=', 'users.id');
            })
            ->selectRaw('users.id as uId,users.name as userName,profilePhoto.user_id as profileUserId,profilePhoto.user_profile,
        profileCover.user_cover,COUNT(userFollowers.id) as userFollowers,COUNT(userFollowings.id) as userFollowings,userDetails.birthplace')
            ->groupBy('users.id')
            ->orderBy('community_user_friends.created_at', 'DESC')
            ->get();

        return view('community-frontend.user-profile', $data, compact('userPhotoAlbum', 'imgArray'));

    }


    public function getStateAjax(Request $request): \Illuminate\Http\JsonResponse
    {
        $requestData=[];
        if ($request->ajax()){
//            dd($request->all());
            $getStates=State::with('countries')->where('c_id','=',$request->country_id)->get();

            $requestData=[
                'status'=>true,
                'getStates'=>$getStates,
                'msg'=>'Done'
            ];
//
            if ($request->get('reqTyp')==='getCity'){

//                dd($request->all());
                $getCity=City::where('state_id','=',$request->get('state_id'))->get();
//                dd($getCity);
                $requestData=[
                    'status'=>true,
                    'getStates'=>$getCity,
                    'msg'=>'Done'
                ];
            }
        }

        return \response()->json($requestData);

    }

}
