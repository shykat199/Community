<?php

namespace App\Http\Controllers\Community\Frontend\Video;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserPost;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{

    public function index()
    {
        $videoType = ['mp4', 'mov', 'avi', 'webm', 'wmv', 'mp4', 'mkv'];

        $allVideos = CommunityUserPost::with(['users.userProfileImages','comments.replies'])
            ->join('community_user_post_file_types', function ($q) use ($videoType) {
                $q->on('community_user_post_file_types.post_id', '=', 'community_user_posts.id');
            })
            ->join('users', 'users.id', '=', 'community_user_posts.user_id')
            ->leftJoin('community_user_post_reactions as userPostReaction', function ($q) {
                $q->on('userPostReaction.user_post_id', '=', 'community_user_posts.id');
                $q->where('userPostReaction.user_id', '=', Auth::id());
            })
            ->selectRaw('users.id as user_id,users.name,community_user_posts.created_at,
            community_user_posts.id,
            community_user_posts.id as pId,community_user_post_file_types.post_image_video as postMedia,
            community_user_posts.post_description,userPostReaction.reaction_type,
            userPostReaction.id as reactionId');

        foreach ($videoType as $type) {
            $allVideos = $allVideos->orWhere('community_user_post_file_types.post_image_video', 'like', "%{$type}%");
        }
        $allVideos = $allVideos->get();

        return view('community-frontend.videoSection', compact('allVideos'));
    }

}
