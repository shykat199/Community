<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Community\Page\CommunityPage;
use App\Models\Community\User\CommunityUserFollowing;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityFrontendController extends Controller
{

    public function index(){

        $allUserFriendPost=User::join('community_user_posts as userPost',function ($q){
            $q->on('userPost.user_id','=','users.id');
            $q->where('users.id','!=',ADMIN_ROLE);
            $q->where('userPost.user_id','=',Auth::id());
        })
            ->leftjoin('community_user_post_file_types as postFileType',function ($q){
                $q->on('postFileType.post_id','=','userPost.id');
            })
            ->leftjoin('community_user_post_reactions as postReaction',function ($q){
                $q->on('postReaction.user_post_id','=','userPost.id');
            })
            ->join('community_user_friends as allFriends',function ($q){
                $q->on('allFriends.requested_user_id','=','users.id');
                $q->where('users.id','!=',ADMIN_ROLE);
                $q->where('allFriends.user_id','=',Auth::id());
            })

            ->selectRaw('users.name,users.id as uId,userPost.post_description as userPostDescription,
            postFileType.post_image_video as userFile,postReaction.reaction_type')
        ->toSql();
//        return $allUserFriendPost;

        return view('community-frontend.index');
    }

    public function addUserFollow(Request $request){

        if (\request()->ajax()){
            $userId=$request->get('userId');
            $userName=$request->get('userName');

            $communityFollower=CommunityUserFollowing::create([
                'user_following_id'=>Auth::id(),
                'user_id'=>$userId
            ]);

            if ($communityFollower){
                return \response()->json([
                    'status'=>true,
                    'msg'=>'Successfully Added',
                ]);
            }

        }

    }

}
