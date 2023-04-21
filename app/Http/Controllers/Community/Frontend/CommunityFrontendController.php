<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Community\Page\CommunityPage;
use App\Models\Community\User\CommunityUserFollowing;
use App\Models\Community\User\CommunityUserPost;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityFrontendController extends Controller
{

    public function index()
    {

        $friendList = [];
        $friendList[] = Auth::id();
        foreach (myFriends() as $friend) {
            $friendList[] = $friend->uId;
        }
//        dd($friendList);
        $allUserPosts = CommunityUserPost::join('users', function ($q) use ($friendList) {
            $q->on('users.id', '=', 'community_user_posts.user_id');
            $q->whereIn('users.id', $friendList);
        })
            ->leftJoin('community_user_post_file_types as postMedia', function ($q) {
                $q->on('postMedia.post_id', '=', 'community_user_posts.id');
            })
            ->leftJoin('community_user_profile_photos as profilePhoto', function ($q) {
                $q->on('profilePhoto.user_id', '=', 'users.id');
                $q->where('users.id', '!=', ADMIN_ROLE);
            })
            ->leftJoin('community_user_profile_covers as profileCover', function ($q) {
                $q->on('profileCover.user_id', '=', 'users.id');
                $q->where('users.id', '!=', ADMIN_ROLE);

            })
//            ->leftJoin('community_user_post_reactions as postReaction',function ($q){
//                $q->on('postReaction.user_post_id','=','community_user_posts.id');
//            })
            ->selectRaw('users.id as uId,users.name,community_user_posts.post_description as postDescription,community_user_posts.created_at,
            postMedia.post_id,postMedia.post_image_video as userPostMedia,postMedia.caption,profilePhoto.user_profile,
        profileCover.user_cover')
//            ->whereIn('users.id',$friendList)
//            ->groupBy('users.id')
            ->get();

//        return $allUserPosts;

        return view('community-frontend.index',compact('allUserPosts'));
    }

    public function addUserFollow(Request $request)
    {

        if (\request()->ajax()) {
            $userId = $request->get('userId');
            $userName = $request->get('userName');

            $communityFollower = CommunityUserFollowing::create([
                'user_following_id' => Auth::id(),
                'user_id' => $userId
            ]);

            if ($communityFollower) {
                return \response()->json([
                    'status' => true,
                    'msg' => 'Successfully Added',
                ]);
            }

        }

    }

}
