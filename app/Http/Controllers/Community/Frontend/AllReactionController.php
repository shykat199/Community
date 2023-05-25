<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Community\Group\CommunityUserGroupPostComment;
use App\Models\Community\Group\CommunityUserGroupPostReaction;
use App\Models\Community\Page\CommunityPagePostComment;
use App\Models\Community\Page\CommunityPagePostReaction;
use App\Models\Community\User\CommunityUserPostFileType;
use App\Models\Community\User_Post\CommunityUserPostComment;
use App\Models\Community\User_Post\CommunityUserPostReaction;
use App\Models\Community\User_Profile\CommunityUserProfileCover;
use App\Models\Community\User_Profile\CommunityUserProfilePhoto;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllReactionController extends Controller
{
    public function allAjax(Request $request)
    {

        $returnResult = [];

        if ($request->ajax()) {
//            dd($request->all());
            if ($request->get('reqType') === 'storePostReaction') {

//                dd($request->all());

                $returnResult = [];
                $postId = $request->get('postId');
                $reaction_type = $request->get('postReaction');

                $checkReaction = CommunityUserPostReaction::where('user_post_id', '=', $postId)->where('user_id', '=', Auth::id())
                    ->first();

//                dd($checkReaction);
                if (!empty($checkReaction)) {
//                    dd(1);
                    if ($reaction_type == $checkReaction->reaction_type) {

//                        dd(2);
                        $deleteReaction = $checkReaction->delete();

                        if ($deleteReaction) {
                            $returnResult = [
                                'status' => true,
                                'msg' => 'Successfully Deleted',
                                'postComments' => $deleteReaction,
                                'flag' => 0
                            ];
                        }
                    } else {
//                        dd(3);

                        $updatedReaction = $checkReaction->update([
                            'reaction_type' => $reaction_type
                        ]);

                        if ($updatedReaction) {
                            $returnResult = [
                                'status' => true,
                                'msg' => 'Successfully updated',
                                'postComments' => $updatedReaction,
                                'flag' => 2

                            ];
                        }
                    }

                } else {

//                    dd('add reaction');
//                    dd('vbn');

                    $storePostReaction = CommunityUserPostReaction::create([
                        'user_post_id' => $request->get('postId'),
                        'user_id' => \Auth::id(),
                        'reaction_type' => $request->get('postReaction')
                    ]);

                    if ($storePostReaction) {
                        $returnResult = [
                            'status' => true,
                            'msg' => 'Successfully Added',
                            'postComments' => $storePostReaction,
                            'flag' => 1
                        ];
                    }
                }

                return \response()->json($returnResult);

            }
            elseif ($request->get('reqType') === 'storePagePostReaction') {
                $storePostReaction = CommunityPagePostReaction::create([
                    'page_post_id' => $request->get('postId'),
                    'user_id' => \Auth::id(),
                    'reaction_type' => $request->get('postReaction')
                ]);


                if ($storePostReaction) {
                    $returnResult = [
                        'status' => true,
                        'msg' => 'Successfully Added',
                        'postComments' => json_encode($storePostReaction)
                    ];
                }
            }

            elseif ($request->get('reqType') === 'storeGroupPostReaction') {


                $returnResult = [];
                $postId = $request->get('postId');
                $reaction_type = $request->get('postReaction');

                $checkReaction = CommunityUserGroupPostReaction::where('group_post_id', '=', $postId)->where('user_id', '=', Auth::id())
                    ->first();

//                dd($checkReaction);
                if (!empty($checkReaction)) {
//                    dd(1);
                    if ($reaction_type == $checkReaction->reaction_type) {

//                        dd(2);
                        $deleteReaction = $checkReaction->delete();

                        if ($deleteReaction) {
                            $returnResult = [
                                'status' => true,
                                'msg' => 'Successfully Deleted',
                                'postComments' => $deleteReaction,
                                'flag' => 0
                            ];
                        }
                    } else {
//                        dd(3);

                        $updatedReaction = $checkReaction->update([
                            'reaction_type' => $reaction_type
                        ]);

                        if ($updatedReaction) {
                            $returnResult = [
                                'status' => true,
                                'msg' => 'Successfully updated',
                                'postComments' => $updatedReaction,
                                'flag' => 2

                            ];
                        }
                    }

                } else {
                    $storePostReaction = CommunityUserGroupPostReaction::create([
                        'group_post_id' => $request->get('postId'),
                        'user_id' => \Auth::id(),
                        'reaction_type' => $request->get('postReaction')
                    ]);

                    if ($storePostReaction) {
                        $returnResult = [
                            'status' => true,
                            'msg' => 'Successfully Added',
                            'postComments' => $storePostReaction,
                            'flag' => 1
                        ];
                    }
                }

                return \response()->json($returnResult);

            } // Edit Comment Section

            elseif ($request->get('reqType') === 'editUserNewsFeedComment') {

//                dd($request->all());
                $editUserCmt = CommunityUserPostComment::where('id', '=', $request->get('cmtId'))->where('user_post_id', '=', $request->get('postId'))->update([
                    'comment_text' => $request->get('postText')
                ]);

                if ($editUserCmt) {
//                    $getUpdatedData = CommunityUserPostComment::where('id', '=', $request->get('cmtId'))->where('user_post_id', '=', $request->get('postId'))->first();

                    $returnResult = [
                        'status' => true,
                        'msg' => 'Successfully Added',
                        'postComments' => $editUserCmt
                    ];
                }

            } elseif ($request->get('reqType') === 'editGroupNewsFeedComment') {

//                dd($request->all());
                $editGroupCmt = CommunityUserGroupPostComment::where('id', '=', $request->get('cmtId'))->where('group_post_id', '=', $request->get('postId'))->update([
                    'comment_text' => $request->get('postText')
                ]);

                if ($editGroupCmt) {
//                    $getUpdatedData = CommunityUserPostComment::where('id', '=', $request->get('cmtId'))->where('user_post_id', '=', $request->get('postId'))->first();

                    $returnResult = [
                        'status' => true,
                        'msg' => 'Successfully Added',
                        'postComments' => $editGroupCmt
                    ];
                }

            } elseif ($request->get('reqType') === 'editPageNewsFeedComment') {

//                dd($request->all());
                $editPageCmt = CommunityPagePostComment::where('id', '=', $request->get('cmtId'))->where('page_post_id', '=', $request->get('postId'))->update([
                    'comment_text' => $request->get('postText')
                ]);

                if ($editPageCmt) {
//                    $getUpdatedData = CommunityUserPostComment::where('id', '=', $request->get('cmtId'))->where('user_post_id', '=', $request->get('postId'))->first();

                    $returnResult = [
                        'status' => true,
                        'msg' => 'Successfully Added',
                        'postComments' => $editPageCmt
                    ];
                }

            } elseif ($request->get('reqType') === 'removePostReaction') {

//                dd($request->all());
                $dltPostReaction = CommunityUserPostReaction::where('id', '=', $request->get('reactionId'))->where('user_id', '=', Auth::id())
                    ->where('user_post_id', '=', $request->get('postId'))
                    ->delete();
//                dd($dltPostReaction);

                if ($dltPostReaction) {
//                    $getUpdatedData = CommunityUserPostComment::where('id', '=', $request->get('cmtId'))->where('user_post_id', '=', $request->get('postId'))->first();

                    $returnResult = [
                        'status' => true,
                        'msg' => 'Successfully deleted',
                        'postComments' => $dltPostReaction
                    ];
                }

            } elseif ($request->get('imgType') === 'img') {
                $allPostImg = CommunityUserPostFileType::leftJoin('community_user_posts', 'community_user_posts.id', '=', 'community_user_post_file_types.post_id')
                    ->where('community_user_posts.user_id', '=', Auth::id())
                    ->where('community_user_post_file_types.post_image_video', 'LIKE', '%' . 'image' . '%')
                    ->select('post_image_video as allPostMedia')->get();
                $html = '';

//                dd($allPostImg);

                if ($allPostImg) {
                    foreach ($allPostImg as $image) {

                        $html .= '<div class="col-lg-3 col-md-4 col-6">
                                            <div class="single-gallary-photo">';
                        if (!empty($image) && isset($image) ? $image : '') {
                            $html .= ' <a href="#">
                             <img src="' . asset('storage/community/post/' . $image->allPostMedia) . '" alt="image">
                                                                    </a>';
                        } else {
                            $html .= '<a href=""><img src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '" alt="image"></a>';
                        }
                        $html .= ' <ul class="icon-list">
                                                    <li>
                                                        <a href="#">
                                                                <span class="icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M407.672 280.596c-21.691-15.587-45.306-27.584-70.182-35.778C370.565 219.986 392 180.449 392 136 392 61.01 330.991 0 256 0S120 61.01 120 136c0 44.504 21.488 84.084 54.633 108.911-30.368 9.998-58.863 25.555-83.803 46.069-45.732 37.617-77.529 90.086-89.532 147.743-3.762 18.066.745 36.622 12.363 50.908C25.222 503.847 42.365 512 60.693 512H267c11.046 0 20-8.954 20-20s-8.954-20-20-20H60.693c-8.538 0-13.689-4.766-15.999-7.606-3.989-4.905-5.533-11.29-4.236-17.519 20.756-99.695 108.691-172.521 210.24-174.977a137.229 137.229 0 0 0 10.643-.002c44.466 1.052 86.883 15.236 122.988 41.182 8.969 6.446 21.467 4.399 27.913-4.569 6.446-8.97 4.4-21.467-4.57-27.913zm-146.803-48.718a263.128 263.128 0 0 0-9.709.001C200.465 229.35 160 187.312 160 136c0-52.935 43.065-96 96-96s96 43.065 96 96c0 51.302-40.45 93.334-91.131 95.878z" fill="#000000" data-original="#000000"></path><path d="m455.285 427 50.857-50.857c7.811-7.811 7.811-20.475 0-28.285-7.811-7.811-20.474-7.811-28.284 0L427 398.715l-50.858-50.858c-7.811-7.811-20.474-7.811-28.284 0-7.81 7.811-7.811 20.475 0 28.285L398.715 427l-50.857 50.857c-7.811 7.811-7.811 20.475 0 28.285A19.933 19.933 0 0 0 362 512a19.936 19.936 0 0 0 14.142-5.857L427 455.285l50.858 50.858A19.936 19.936 0 0 0 492 512a19.936 19.936 0 0 0 14.142-5.857c7.811-7.811 7.811-20.475 0-28.285L455.285 427z" fill="#000000" data-original="#000000"></path></g></svg>
                                                                </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                                <span class="icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M28 24v-4a1 1 0 0 0-2 0v4a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-4a1 1 0 0 0-2 0v4a3 3 0 0 0 3 3h18a3 3 0 0 0 3-3zm-6.38-5.22-5 4a1 1 0 0 1-1.24 0l-5-4a1 1 0 0 1 1.24-1.56l3.38 2.7V6a1 1 0 0 1 2 0v13.92l3.38-2.7a1 1 0 1 1 1.24 1.56z" data-name="Download" fill="#000000" data-original="#000000"></path></g></svg>
                                                                </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>';

                    }
                }

                $returnResult = [
                    'status' => true,
                    'html' => $html,
                    'msg' => 'Successfully Added',
                    'postComments' => $allPostImg,
                    'reqTyp' => 'img'

                ];


            } elseif ($request->get('imgType') === 'pc') {
//                dd(1);
                $allPostImg = CommunityUserProfileCover::where('community_user_profile_covers.user_id', '=', Auth::id())
                    ->select('user_cover as allPostMedia')->get();
//                dd($allPostImg);
                $html = '';

//                dd($allPostImg);

                if ($allPostImg) {
                    foreach ($allPostImg as $image) {

                        $html .= ' <div class="col-lg-3 col-md-4 col-6">
                                            <div class="single-gallary-photo">';
                        if (!empty($image) && isset($image) ? $image : '') {
                            $html .= ' <a href="#">
                             <img src="' . asset('storage/community/cover-picture/' . $image->allPostMedia) . '" alt="image">
                                                                    </a>';
                        } else {
                            $html .= '<a href=""><img src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '" alt="image"></a>';
                        }
                        $html .= ' <ul class="icon-list">
                                                    <li>
                                                        <a href="#">
                                                                <span class="icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M407.672 280.596c-21.691-15.587-45.306-27.584-70.182-35.778C370.565 219.986 392 180.449 392 136 392 61.01 330.991 0 256 0S120 61.01 120 136c0 44.504 21.488 84.084 54.633 108.911-30.368 9.998-58.863 25.555-83.803 46.069-45.732 37.617-77.529 90.086-89.532 147.743-3.762 18.066.745 36.622 12.363 50.908C25.222 503.847 42.365 512 60.693 512H267c11.046 0 20-8.954 20-20s-8.954-20-20-20H60.693c-8.538 0-13.689-4.766-15.999-7.606-3.989-4.905-5.533-11.29-4.236-17.519 20.756-99.695 108.691-172.521 210.24-174.977a137.229 137.229 0 0 0 10.643-.002c44.466 1.052 86.883 15.236 122.988 41.182 8.969 6.446 21.467 4.399 27.913-4.569 6.446-8.97 4.4-21.467-4.57-27.913zm-146.803-48.718a263.128 263.128 0 0 0-9.709.001C200.465 229.35 160 187.312 160 136c0-52.935 43.065-96 96-96s96 43.065 96 96c0 51.302-40.45 93.334-91.131 95.878z" fill="#000000" data-original="#000000"></path><path d="m455.285 427 50.857-50.857c7.811-7.811 7.811-20.475 0-28.285-7.811-7.811-20.474-7.811-28.284 0L427 398.715l-50.858-50.858c-7.811-7.811-20.474-7.811-28.284 0-7.81 7.811-7.811 20.475 0 28.285L398.715 427l-50.857 50.857c-7.811 7.811-7.811 20.475 0 28.285A19.933 19.933 0 0 0 362 512a19.936 19.936 0 0 0 14.142-5.857L427 455.285l50.858 50.858A19.936 19.936 0 0 0 492 512a19.936 19.936 0 0 0 14.142-5.857c7.811-7.811 7.811-20.475 0-28.285L455.285 427z" fill="#000000" data-original="#000000"></path></g></svg>
                                                                </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                                <span class="icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M28 24v-4a1 1 0 0 0-2 0v4a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-4a1 1 0 0 0-2 0v4a3 3 0 0 0 3 3h18a3 3 0 0 0 3-3zm-6.38-5.22-5 4a1 1 0 0 1-1.24 0l-5-4a1 1 0 0 1 1.24-1.56l3.38 2.7V6a1 1 0 0 1 2 0v13.92l3.38-2.7a1 1 0 1 1 1.24 1.56z" data-name="Download" fill="#000000" data-original="#000000"></path></g></svg>
                                                                </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>';

                    }
                }

                $returnResult = [
                    'status' => true,
                    'html' => $html,
                    'msg' => 'Successfully Added',
                    'postComments' => $allPostImg,
                    'reqTyp' => 'pc'

                ];

            } elseif ($request->get('imgType') === 'pp') {

                $allPostImg = CommunityUserProfilePhoto::where('community_user_profile_photos.user_id', '=', Auth::id())
                    ->where('community_user_profile_photos.user_profile', 'LIKE', '%' . 'profile-Photo' . '%')
                    ->select('user_profile as allPostMedia')->get();
//                dd($allPostImg);
                $html = '';

//                dd($allPostImg);

                if ($allPostImg) {
                    foreach ($allPostImg as $image) {

                        $html .= '<div class="col-lg-3 col-md-4 col-6">
                                            <div class="single-gallary-photo">';
                        if (!empty($image) && isset($image) ? $image : '') {
                            $html .= ' <a href="#">
                             <img src="' . asset('storage/community/profile-picture/' . $image->allPostMedia) . '" alt="image">
                                                                    </a>';
                        } else {
                            $html .= '<a href=""><img src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '" alt="image"></a>';
                        }
                        $html .= ' <ul class="icon-list">
                                                    <li>
                                                        <a href="#">
                                                                <span class="icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M407.672 280.596c-21.691-15.587-45.306-27.584-70.182-35.778C370.565 219.986 392 180.449 392 136 392 61.01 330.991 0 256 0S120 61.01 120 136c0 44.504 21.488 84.084 54.633 108.911-30.368 9.998-58.863 25.555-83.803 46.069-45.732 37.617-77.529 90.086-89.532 147.743-3.762 18.066.745 36.622 12.363 50.908C25.222 503.847 42.365 512 60.693 512H267c11.046 0 20-8.954 20-20s-8.954-20-20-20H60.693c-8.538 0-13.689-4.766-15.999-7.606-3.989-4.905-5.533-11.29-4.236-17.519 20.756-99.695 108.691-172.521 210.24-174.977a137.229 137.229 0 0 0 10.643-.002c44.466 1.052 86.883 15.236 122.988 41.182 8.969 6.446 21.467 4.399 27.913-4.569 6.446-8.97 4.4-21.467-4.57-27.913zm-146.803-48.718a263.128 263.128 0 0 0-9.709.001C200.465 229.35 160 187.312 160 136c0-52.935 43.065-96 96-96s96 43.065 96 96c0 51.302-40.45 93.334-91.131 95.878z" fill="#000000" data-original="#000000"></path><path d="m455.285 427 50.857-50.857c7.811-7.811 7.811-20.475 0-28.285-7.811-7.811-20.474-7.811-28.284 0L427 398.715l-50.858-50.858c-7.811-7.811-20.474-7.811-28.284 0-7.81 7.811-7.811 20.475 0 28.285L398.715 427l-50.857 50.857c-7.811 7.811-7.811 20.475 0 28.285A19.933 19.933 0 0 0 362 512a19.936 19.936 0 0 0 14.142-5.857L427 455.285l50.858 50.858A19.936 19.936 0 0 0 492 512a19.936 19.936 0 0 0 14.142-5.857c7.811-7.811 7.811-20.475 0-28.285L455.285 427z" fill="#000000" data-original="#000000"></path></g></svg>
                                                                </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                                <span class="icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M28 24v-4a1 1 0 0 0-2 0v4a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-4a1 1 0 0 0-2 0v4a3 3 0 0 0 3 3h18a3 3 0 0 0 3-3zm-6.38-5.22-5 4a1 1 0 0 1-1.24 0l-5-4a1 1 0 0 1 1.24-1.56l3.38 2.7V6a1 1 0 0 1 2 0v13.92l3.38-2.7a1 1 0 1 1 1.24 1.56z" data-name="Download" fill="#000000" data-original="#000000"></path></g></svg>
                                                                </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>';

                    }
                }

                $returnResult = [
                    'status' => true,
                    'html' => $html,
                    'msg' => 'Successfully Added',
                    'postComments' => $allPostImg,
                    'reqTyp' => 'pp'

                ];

            }


        }

        return response()->json(
            $returnResult
        );

    }
}
