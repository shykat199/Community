<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Community\Group\CommunityUserGroupPostComment;
use App\Models\Community\Group\CommunityUserGroupPostReaction;
use App\Models\Community\Page\CommunityPagePostComment;
use App\Models\Community\Page\CommunityPagePostReaction;
use App\Models\Community\User_Post\CommunityUserPostComment;
use App\Models\Community\User_Post\CommunityUserPostReaction;
use Illuminate\Http\Request;

class AllReactionController extends Controller
{
    public function allAjax(Request $request)
    {

        $returnResult = [];

        if ($request->ajax()) {
//            dd($request->all());
            if ($request->get('reqType') === 'storePostReaction') {
                $storePostReaction = CommunityUserPostReaction::create([
                    'user_post_id' => $request->get('postId'),
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

//                dd($request->all());
                $storePostReaction = CommunityUserGroupPostReaction::create([
                    'group_post_id' => $request->get('postId'),
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

            }

            elseif ($request->get('reqType') === 'editGroupNewsFeedComment') {

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

            }


            elseif ($request->get('reqType') === 'editPageNewsFeedComment') {

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

            }
        }

        return response()->json(
            $returnResult
        );

    }
}
