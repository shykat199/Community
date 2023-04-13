<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Community\Page\CommunityPage;
use App\Models\Community\User\CommunityUserFollowing;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityFrontendController extends Controller
{

    public function index(){

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
