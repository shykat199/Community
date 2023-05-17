<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Community\Group\CommunityUserGroupPostReaction;
use App\Models\Community\Page\CommunityPagePostReaction;
use App\Models\Community\User_Post\CommunityUserPostReaction;
use Illuminate\Http\Request;

class AllReactionController extends Controller
{
    public function storeReaction(Request $request)
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
            }
        }

        return response()->json(
            $returnResult
        );

    }
}
