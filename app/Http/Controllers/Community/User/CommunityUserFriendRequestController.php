<?php

namespace App\Http\Controllers\Community\User;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserFriend;
use App\Models\Community\User\CommunityUserFriendRequest;
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
}
