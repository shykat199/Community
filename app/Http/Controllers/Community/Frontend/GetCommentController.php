<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Community\Group\CommunityUserGroupPostComment;
use App\Models\Community\User_Post\CommunityUserPostComment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GetCommentController extends Controller
{
    public function getAllComments(Request $request)
    {

//        dd($request->all());
        if ($request->ajax()) {

            if ($request->get('reqTyp') === 'grpCmt') {

                $postComments = CommunityUserGroupPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
                    ->where('group_post_id', '=', $request->get('gPostId'))
                    ->where('group_post_comment_id', '=', 0)
                    ->get();
//            dd($postComments);
                $html = '';

                foreach ($postComments as $comment) {
//                    dd($comment->userPosts->users->userProfileImages[0]->user_profile);
                    $date = Carbon::parse($comment->created_at)->diffForHumans();
                    $userName = $comment->userPosts->users->name;
                    $comments = $comment->comment_text;
                    $commentId = $comment->id;
                    $userProfilePicture = $comment->userPosts->users->userProfileImages[0]->user_profile;
//                    dd($comment);
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
                                                            <input data-cmtId="' . $comment->id . '" class="cmtText" type="text" name="cmttext" data-userPostId="' . $comment->group_post_id . '" placeholder="Write a comment....">
                                                                <div class="attached-icon">
                                                                    <a href="#"><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>';

                    }
                    $html .= '</li>';
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
        }

        return response()->json(
            $returnResult
        );

    }
}
