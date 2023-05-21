<?php

namespace App\Http\Controllers\Community\Frontend\Post;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserPost;
use App\Models\Community\User\CommunityUserPostFileType;
use App\Models\Community\User\CommunityUserPostTag;
use App\Models\Community\User_Post\CommunityUserPostComment;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class CommunityUserPostController extends Controller
{

    public function store(Request $request)
    {
//        dd($request->file('postFile')->getClientOriginalExtension());

        if ($request->get('imageCaption') && $request->get('imageCaption') === null) {
//            dd(1);
            $userPost = CommunityUserPost::create([
                'user_id' => Auth::id(),
                'post_description' => $request->get('postMessage')
            ]);

        } else {
            $fileName = null;
            if ($request->hasFile('postFile') !== null || $request->get('imageCaption') !== null) {
//                dd(1);
                $userPost = CommunityUserPost::create([
                    'user_id' => Auth::id(),
                    'post_description' => $request->get('postMessage')
                ]);
                if ($request->hasFile('postFile')) {

                    if ($request->file('postFile')->getClientOriginalExtension() == 'mp4' ||
                        $request->file('postFile')->getClientOriginalExtension() == 'mov' || $request->file('postFile')->getClientOriginalExtension() == 'wmv' ||
                        $request->file('postFile')->getClientOriginalExtension() == 'avi' || $request->file('postFile')->getClientOriginalExtension() == 'mkv' ||
                        $request->file('postFile')->getClientOriginalExtension() == 'webm'
                    ) {
                        $fileName = Uuid::uuid() . '.'.'video'. $request->file('postFile')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/post/videos/' . $fileName, file_get_contents($request->file('postFile')));
                    } else {
                        $fileName = Uuid::uuid() . '.'.'image'. $request->file('postFile')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/post/' . $fileName, file_get_contents($request->file('postFile')));
                    }

                }
//                dd(3);
                $postImageCaption = CommunityUserPostFileType::create([
                    'post_id' => $userPost->id,
                    'post_image_video' => $fileName,
                    'caption' => $request->get('imageCaption'),
                ]);
            }
        }
        if ($request->get('tagId')) {

            $input['tagId'] = $request->input('tagId');
//                dd(is_array($input['tagId']));
            if (is_array($input['tagId'])) {
                foreach ($input['tagId'] as $key => $value) {
                    $tagUsers = CommunityUserPostTag::insert([
                        'user_id' => Auth::id(),
                        'tag_user_id' => $value,
                        'user_post_id' => $userPost->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }

        if ($userPost || $postImageCaption) {
//            toastr('dd', 'success');
            toastr()->success('Post has been posted successfully!', 'Congrats');
            return Redirect::back();
        }
        toastr()->error('An error has occurred please try again later.');

    }

    public function storeCommentOfComment(Request $request)
    {
        $html = '';
        if ($request->ajax()) {
//            dd($request->all());
            $storeComments = CommunityUserPostComment::create([
                'user_id' => Auth::id(),
                'user_post_id' => $request->get('user_post_id'),
                'user_post_comment_id' => $request->get('cmtId'),
                'comment_text' => $request->get('cmtText'),
            ]);

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
                                                            <p class="comment-content">'.$storeComments->comment_text.'</p>
                                                            <button class="textarea-btn" type="submit" style="display: none;">
                                                            <i class="fa fa-paper-plane" data-commenttext="check Child" data-cmtId="'.$storeComments->id.'" data-postId="'.$storeComments->user_post_id.' aria-hidden="true"></i>
                                                            </button>
                                                            <button class="textarea-cancel-btn" style="display: none;">Cancel</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';

                return \response()->json([
                    'status' => true,
                    'success' => true,
                    'msg' => 'Successfully Added',
                    'data' => $html
                ]);
            }
        }
    }

}
