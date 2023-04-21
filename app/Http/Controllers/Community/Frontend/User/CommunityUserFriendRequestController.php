<?php

namespace App\Http\Controllers\Community\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserFriend;
use App\Models\Community\User\CommunityUserFriendRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityUserFriendRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function acceptRequest(Request $request)
    {
        if (\request()->ajax()){
            $userFriend=false;
            $userId=$request->get('userId');
            $userName=$request->get('userName');
            $tldId=$request->get('tldId');
//            dd($request->all());
//            dd($userId,$userName);
            $updateStatus=CommunityUserFriendRequest::where('id',$tldId)->update([
                'status'=>1
            ]);

            if ($updateStatus){
                $data=array(
                    array('user_id'=>Auth::id(),'requested_user_id'=>$userId,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()),
                    array('user_id'=>$userId,'requested_user_id'=>Auth::id(),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()),
                );
                $userFriend=CommunityUserFriend::insert($data);
//                $userFriend2=CommunityUserFriend::create([
//                    'user_id'=>$userId,
//                    'requested_user_id'=>Auth::id(),
//                ]);
            }

            if ($userFriend){
                return \response()->json([
                    'status'=>true,
                    'msg'=>'Successfully Added',
                ]);
            }
        }
    }

    public function allFriendRequest(){

        $allRequestedUser=User::join('community_user_friend_requests as requestedUser',function ($q){
            $q->on('requestedUser.sender_user_id','=','users.id');
            $q->where('requestedUser.receiver_user_id','=',Auth::id());
            $q->where('requestedUser.status','=',0);
        })
            ->leftJoin('community_user_profile_photos as profilePhoto', function ($q) {
                $q->on('profilePhoto.user_id', '=', 'requestedUser.sender_user_id');
                $q->where('users.id', '!=', ADMIN_ROLE);
            })
            ->leftJoin('community_user_profile_covers as profileCover', function ($q) {
                $q->on('profileCover.user_id', '=', 'requestedUser.sender_user_id');
                $q->where('users.id', '!=', ADMIN_ROLE);
            })
            ->join('community_user_followings as userFollowings',function ($q){
                $q->on('userFollowings.user_id','=','requestedUser.sender_user_id');
            })
            ->leftJoin('community_user_followings as usersFollowers',function ($q){
                $q->on('userFollowings.user_following_id','=','requestedUser.sender_user_id');
            })
            ->selectRaw('users.id as uId, users.name,requestedUser.id as reqId,profilePhoto.user_profile,profileCover.user_cover,
            COUNT(userFollowings.id) as followings,COUNT(usersFollowers.id) as followers')
            ->groupBy('users.id')
            ->get();


        $userIdArray=[];
        $userIdArray[]=Auth::id();
        $userIdArray[]=ADMIN_ROLE;
        foreach (myFriends() as $friend){
            $userIdArray[]=$friend->uId;
        }
//        dd($userIdArray);
        $allUsers=User::whereNotIn('users.id',$userIdArray)
        ->leftJoin('community_user_profile_photos as profilePhoto', function ($q) use($userIdArray) {
            $q->on('profilePhoto.user_id', '=', 'users.id');
            $q->where('users.id', '!=', ADMIN_ROLE);
            $q->where('users.id', '!=', Auth::id());

        })
            ->leftJoin('community_user_profile_covers as profileCover', function ($q) use($userIdArray){
                $q->on('profileCover.user_id', '=', 'users.id');
                $q->where('users.id', '!=', ADMIN_ROLE);
                $q->where('users.id', '!=', Auth::id());

            })
            ->leftJoin('community_user_followings as userFollowings',function ($q) use($userIdArray){
                $q->on('userFollowings.user_id','=','users.id');
                $q->where('users.id', '!=', ADMIN_ROLE);
                $q->where('users.id', '!=', Auth::id());

            })
            ->leftJoin('community_user_followings as usersFollowers',function ($q) use($userIdArray){
                $q->on('userFollowings.user_following_id','=','users.id');
                $q->where('users.id', '!=', Auth::id());

            })
            
            ->selectRaw('users.id as uId, users.name,profilePhoto.user_profile,profileCover.user_cover,
            COUNT(userFollowings.id) as followings,COUNT(usersFollowers.id) as followers')
            ->groupBy('users.id')
            ->orderBy('users.name','ASC')
            ->get();

//        return $allUsers;



        return view('community-frontend.friendSection',compact('allRequestedUser','allUsers'));
    }
}
