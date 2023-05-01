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

        $allUserPosts = CommunityUserPost::with('users.userProfileImages')
            ->join('users', function ($q) use ($friendList) {
                $q->on('users.id', '=', 'community_user_posts.user_id');
                $q->whereIn('users.id', $friendList);
            })
            ->leftJoin('community_user_post_file_types as postMedia', function ($q) {
                $q->on('postMedia.post_id', '=', 'community_user_posts.id');
            })

            ->leftJoin('community_user_post_reactions as userPostReaction',function ($q){
                $q->on('userPostReaction.user_post_id','=','community_user_posts.id');
                $q->where('userPostReaction.user_id','=',Auth::id());
            })

//            ->leftJoin('community_user_profile_photos as profilePhoto', function ($q) {
//                $q->on('profilePhoto.user_id', '=', 'users.id');
//            })
//            ->selectRaw("
//            GROUP_CONCAT( DISTINCT users.id ORDER BY users.id DESC ) as uId,GROUP_CONCAT( DISTINCT users.name ORDER BY users.id DESC) as name,
//            GROUP_CONCAT( DISTINCT community_user_posts.post_description ORDER BY community_user_posts.id DESC) as postDescription,
//            GROUP_CONCAT( DISTINCT community_user_posts.created_at ORDER BY community_user_posts.id DESC) as created_at,
//            GROUP_CONCAT( DISTINCT postMedia.post_id ORDER BY postMedia.id DESC) as post_id,
//            GROUP_CONCAT( DISTINCT postMedia.post_image_video ORDER BY postMedia.id DESC) as userPostMedia,
//            GROUP_CONCAT( DISTINCT postMedia.caption ORDER BY postMedia.id DESC) as caption,
//            GROUP_CONCAT( DISTINCT community_user_posts.id ORDER BY community_user_posts.id DESC) as postId,
//            GROUP_CONCAT( DISTINCT profilePhoto.user_profile ORDER BY profilePhoto.id DESC) as user_profile")

            ->selectRaw("
            users.id as user_id,users.name,
            community_user_posts.post_description as postDescription,
            community_user_posts.created_at as created_at,
            postMedia.post_id as post_id,
            postMedia.post_image_video as userPostMedia,
            postMedia.caption as caption,
            community_user_posts.id as postId,
            userPostReaction.reaction_type,
            userPostReaction.id as reactionId
            ")
            ->latest()
            ->get();

//        return $allUserPosts;

        return view('community-frontend.index', compact('allUserPosts'));
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
