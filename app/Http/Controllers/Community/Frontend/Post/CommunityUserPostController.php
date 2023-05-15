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
                        $fileName = Uuid::uuid() . '.' . $request->file('postFile')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/post/videos/' . $fileName, file_get_contents($request->file('postFile')));
                    } else {
                        $fileName = Uuid::uuid() . '.' . $request->file('postFile')->getClientOriginalExtension();
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
//                dd($storeComments->users->userProfileImages[0]->user_profile);
                $userProfileImages = $storeComments->users->userProfileImages[0]->user_profile;
                $html .= '<div class="single-replay-comnt">
                                    <div class="replay-coment-box">
                                        <div class="replay-comment-img">
                                            <a href="#">';

                if (isset($storeComments->users->userProfileImages)) {
                    $html .= ' <img src="' . asset("storage/community/profile-picture/$userProfileImages") . '" alt="image">';
                } else {
                    $html .= '<img src="' . asset("community-frontend/assets/images/community/home/news-post/comment01.jpg") . '"alt="image">';
                }

                $html .= '</a>
                                        </div>
                                        <div class="replay-comment-details">
                                            <div class="replay-coment-info">
                                                <h6><a class="replay-comnt-name" href="#">' . Auth::user()->name . '</a></h6>
                                                <span class="replay-time-comnt">' . Carbon::parse($storeComments->created_at)->diffForHumans() . '</span>
                                            </div>
                                            <p class="comment-content">' . $storeComments->comment_text . '</p>
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
