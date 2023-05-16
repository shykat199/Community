<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Community\Page\CommunityPage;
use App\Models\Community\Page\CommunityPagePostComment;
use App\Models\Community\User\CommunityUserFollowing;
use App\Models\Community\User\CommunityUserPost;
use App\Models\Community\User\CommunityUserPostFileType;
use App\Models\Community\User\CommunityUserPostTag;
use App\Models\Community\User_Post\CommunityUserPostComment;
use App\Models\Community\User_Post\CommunityUserPostReaction;
use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return view('community-frontend.index', compact('allUserPosts'));
    }


    public function showComments(Request $request)
    {

        if ($request->ajax()) {

            $postComments = CommunityUserPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                ->where('user_post_id', '=', $request->get('postId'))
                ->where('user_post_comment_id', '=', 0)
                ->get();
//            dd($postComments);
            $html = '';

            foreach ($postComments as $comment) {
                $date = Carbon::parse($comment->created_at)->diffForHumans();
                $userName = $comment->userPosts->users->name;
                $comments = $comment->comment_text;
                $commentId = $comment->id;
                $userProfilePicture = $comment->users->userProfileImages[0]->user_profile;
                $html .= '
                     <li class="single-comment">
                            <div class="comment-img">
                                <a href="#">';

                if (isset($userProfilePicture)) {
                    $html .= ' <img src="' . asset("storage/community/profile-picture/$userProfilePicture") . '" alt="image">
                                </a>';
                } else {
                    $html .= '<img src="' . asset("community-frontend/assets/images/community/home/news-post/comment01.jpg") . '"alt="image">';

                }

                $html .= '</a>
                            </div>
                            <div class="comment-details">
                                <div class="coment-info">
                                    <h6><a href="#">' . $userName . '</a></h6>
                                    <span class="comment-time">' . $date . '</span>
                                </div>
                                <p class="comment-content">' . $comments . '</p>
                                <ul class="coment-react">
                                    <li class="comment-like"><a href="#">Like(2)</a></li>
                                    <li><a href="javascript:void(0)" class="replay-tag">Replay</a></li>
                                </ul>';

                if ($comment->replies) {

                    $html .= '<div class="comment-parent-' . $comment->id . '">';

                    foreach ($comment->replies as $reply) {
                        $html .=
                            '<div class="single-replay-comnt">
                                                        <div class="replay-coment-box">
                                                            <div class="replay-comment-img">
                                                                <a href="#">';
                        if (isset($userProfilePicture)) {
                            $html .= '<img src="' . asset("storage/community/profile-picture/$userProfilePicture") . '" alt="image">';
                        } else {
                            $html .= '<img src="' . asset("community-frontend/assets/images/community/home/news-post/comment01.jpg") . '"alt="image">';
                        }

                        $html .= '</a>
                                                </div>
                                                            <div class="replay-comment-details">
                                                                <div class="replay-coment-info">
                                                                    <h6><a class="replay-comnt-name" href="#">' . $reply->users->name . '</a></h6>
                                                                    <span class="replay-time-comnt">' . Carbon::parse($reply->created_at)->diffForHumans() . '</span>
                                                                </div>
                                                                <p class="comment-content">' . $reply->comment_text . '</p>

                                                            </div>
                                                        </div>
                                                    </div>';
                    }
                    $html .= '</div>';

                    $html .= '<div class="new-comment replay-new-comment">
                                                            <a class="new-comment-img replay-comment-img" href="#">';
                    if ($userProfilePicture) {
                        $html .= '<img src="' . asset("storage/community/profile-picture/$userProfilePicture") . '"alt="image">';
                    } else {
                        $html .= '<img src="' . asset("community-frontend/assets/images/community/home/news-post/comment01.jpg") . '"alt="image">';
                    }

                    $html .= '</a><div class="new-comment-input replay-commnt-input">
                                                            <input data-cmtId="' . $comment->id . '" class="cmtText" type="text" name="cmttext" data-userPostId="' . $comment->user_post_id . '" placeholder="Write a comment....">
                                                                <div class="attached-icon">
                                                                    <a href="#"><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>';

                }
                $html .= '</li>';
            }

//            $html=view('community-frontend.index',['postComments'=>$postComments])->render();

            if ($postComments) {

                return \response()->json([
                    'status' => true,
                    'msg' => 'Successfully Added',
                    'postComments' => json_encode($postComments),
                    'html' => $html
                ]);
            }

        }


//        return $postComments;
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

                return \response()->json([
                    'status' => true,
                    'msg' => 'Successfully Added',
                    'postComments' => json_encode($postComments),
                    'html' => $html
                ]);
            }
        }
    }


    public
    function addUserFollow(Request $request)
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
//                'user_post_comment_id' => 0,
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
                                            </div>
                                            <div class="comment-option">
                                                <button type="button" class="dropdown-toggle comment-option-btn"
                                                        id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                        aria-expanded="false"><i class="fa fa-ellipsis-h"
                                                                                 aria-hidden="true"></i></button>
                                                <ul class="dropdown-menu comment-option-dropdown"
                                                    aria-labelledby="dropdownMenuButton1">
                                                    <li class="post-option-item" id="editComment"><i
                                                            class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                        comment
                                                    </li>
                                                    <li class="post-option-item"><i class="fa fa-trash-o"
                                                                                    aria-hidden="true"></i> Delete
                                                        comment
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="comment-div">
                                            <p class="comment-content">' . $postComment->comment_text . '</p>
                                            <button id="textarea_btn" type="submit"><i class="fa fa-paper-plane"
                                                                                       aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <ul class="coment-react">
                                            <li class="comment-like"><a href="#">Like(2)</a></li>
                                            <li><a href="javascript:void(0)" class="replay-tag">Replay</a></li>
                                        </ul>
                                    </div>';

                if (empty($postComment->replies)) {

                    $html .= '<div class="more-comment">
                                        <a class="checkCmt" data-postIdd="' . $postComment->postId . '">More+</a>
                                    </div>';
                }

                $html .= '<div class="child-comment">

                        <div class="new-comment replay-new-comment">';

                if (!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0]) ? $postComment->users->userProfileImages[0] : '') {
                    if (!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0]) ? $postComment->users->userProfileImages[0] : '') {
                        $html .= '<a href=""><img src="' . asset("storage/community/profile-picture/" . $postComment->users->userProfileImages[0]->user_profile) . '"
                                                      alt="image"></a>';
                    }

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


    public
    function updatePost(Request $request)
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

    public
    function destroy($id)
    {

//        $postImage = $postImage->post_image_video;
//        $mediaExtension = explode('.', $postImage);
//        if ($mediaExtension[1] == 'mp4' || $mediaExtension[1] == 'mov' || $mediaExtension[1] == 'wmv' ||
//            $mediaExtension[1] == 'avi' || $mediaExtension[1] == 'mkv' || $mediaExtension[1] == 'webm'
//        ) {
//          @dd(1);
//            $dltVideo = Storage::delete('public/community/post/videos/' . $postImage);
//
//        } else {
//            $dltImag = Storage::delete('public/community/post/' . $postImage);
//
//        }

        $postImage = CommunityUserPostFileType::where('post_id', '=', $id)->first();
//        $postImage = $postImage->post_image_video;
//        dd($postImage);
        if ($postImage) {
            $postImage = $postImage->post_image_video;
//            dd($postImage);
            $mediaExtension = explode('.', $postImage);
            if ($mediaExtension[1] == 'mp4' || $mediaExtension[1] == 'mov' || $mediaExtension[1] == 'wmv' ||
                $mediaExtension[1] == 'avi' || $mediaExtension[1] == 'mkv' || $mediaExtension[1] == 'webm'
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

}
