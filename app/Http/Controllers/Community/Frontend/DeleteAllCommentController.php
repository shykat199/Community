<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Community\Page\CommunityPagePostComment;
use App\Models\Community\User_Post\CommunityUserPostComment;
use Illuminate\Http\Request;

class DeleteAllCommentController extends Controller
{
    public function allAjaxDelete(Request $request){


        $returnResult = [];

        if ($request->ajax()) {

            if ($request->get('reqType') ==='deleteUserPostComment'){
//                dd(1);
                $deleteUserComment=CommunityUserPostComment::where('id','=',$request->get('commentId'))->delete();
                $deleteChildCmt=CommunityUserPostComment::where('user_post_comment_id','=',$request->get('commentId'))->delete();

//                dd($deleteChildCmt);
                if ($deleteUserComment && $deleteChildCmt){
                    $returnResult = [
                        'status' => true,
                        'success'=>true,
                        'msg' => 'Successfully Deleted',
                        'postComments' => $deleteUserComment,
                    ];
                }

            }

            return response()->json(
                $returnResult
            );
        }
    }
}
