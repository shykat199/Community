<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Community\Group\CommunityUserGroupPostComment;
use App\Models\Community\Page\CommunityPagePostComment;
use App\Models\Community\User_Post\CommunityUserPostComment;
use Illuminate\Http\Request;

class DeleteAllCommentController extends Controller
{
    public function allAjaxDelete(Request $request){


        $returnResult = [];

        if ($request->ajax()) {

            if ($request->get('reqType') ==='deleteUserPostComment'){
//                dd($request->all());
                $deleteUserComment=CommunityUserPostComment::where('user_post_comment_id','=',$request->get('commentId'))->get();

                $deleteChildCmt=CommunityUserPostComment::where('id','=',$request->get('commentId'))->get();
//                dd($deleteChildCmt);

//                dd($deleteChildCmt);
                if ($deleteUserComment || $deleteChildCmt){
                    $returnResult = [
                        'status' => true,
                        'success'=>true,
                        'msg' => 'Successfully Deleted',
                        'postComments' => $deleteUserComment,
                    ];
                }

            }

            elseif ($request->get('reqType') ==='deletePagePostComment'){
//                dd(1);
                $deletePagePostComment=CommunityPagePostComment::where('id','=',$request->get('commentId'))->delete();
                $deleteChildCmt=CommunityPagePostComment::where('page_post_comment_id','=',$request->get('commentId'))->delete();

//                dd($deleteChildCmt);
                if ($deletePagePostComment || $deleteChildCmt){
                    $returnResult = [
                        'status' => true,
                        'success'=>true,
                        'msg' => 'Successfully Deleted',
                        'postComments' => $deletePagePostComment,
                    ];
                }

            }

            elseif ($request->get('reqType') ==='deleteGroupPostComment'){
//                dd(1);
                $deleteGroupPostComment=CommunityUserGroupPostComment::where('id','=',$request->get('commentId'))->delete();
                $deleteChildCmt=CommunityUserGroupPostComment::where('group_post_comment_id','=',$request->get('commentId'))->delete();

//                dd($deleteChildCmt);
                if ($deleteGroupPostComment || $deleteChildCmt){
                    $returnResult = [
                        'status' => true,
                        'success'=>true,
                        'msg' => 'Successfully Deleted',
                        'postComments' => $deleteGroupPostComment,
                    ];
                }

            }

            return response()->json(
                $returnResult
            );
        }
    }
}
