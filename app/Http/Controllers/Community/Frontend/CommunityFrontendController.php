<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Community\Page\CommunityPage;
use App\Models\Community\User\CommunityUserFollowing;
use App\Models\Community\User\CommunityUserPost;
use App\Models\Community\User\CommunityUserPostFileType;
use App\Models\Community\User\CommunityUserPostTag;
use App\Models\Community\User_Post\CommunityUserPostComment;
use App\Models\Community\User_Post\CommunityUserPostReaction;
use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

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
            ->leftJoin('community_user_post_reactions as userPostReaction', function ($q) {
                $q->on('userPostReaction.user_post_id', '=', 'community_user_posts.id');
                $q->where('userPostReaction.user_id', '=', Auth::id());
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

    public function storeComment(Request $request)
    {
//        dd($request->all());

        if ($request->ajax()) {
            $storePostComment = CommunityUserPostComment::create([
                'user_id' => Auth::id(),
                'user_post_id' => $request->get('postId'),
                'comment_text' => $request->get('postComment'),
            ]);
        }

        if ($storePostComment) {
            return \response()->json([
                'status' => true,
                'success' => true,
                'data' => $storePostComment,
                'msg' => 'Successfully Added.',
            ]);
        } else {
            return \response()->json([
                'status' => true,
                'success' => false,
                'data' => $storePostComment,
                'msg' => 'Something wrong.',
            ]);
        }


//        if ($storePostComment){
//            return \redirect()->back()->with('success','Comment Posted Successfully');
//        }else{
//            return  \redirect()->back()->with('error','Something Error');
//        }

    }


    public function updatePost(Request $request)
    {
//        @dd($request->all());

        if ($request->get('imageCaption') === null && $request->hasFile('postFile1') === null) {
//            dd(1);
            $userPost = CommunityUserPost::find($request->get('postId'))->update([
//                'user_id' => Auth::id(),
                'post_description' => $request->get('postMessage')
            ]);

        } else {
//            dd(2);
            $fileName = null;
            if ($request->hasFile('postFile1') !== null || $request->get('imageCaption') !== null) {
//                dd(2);
                $userPost = CommunityUserPost::find($request->get('postId'))->update([
//                    'user_id' => Auth::id(),
                    'post_description' => $request->get('postMessage')
                ]);
//                dd(4);
                if ($request->hasFile('postFile1')) {
//                    dd(5);
                    if ($request->file('postFile1')->getClientOriginalExtension() == 'mp4' ||
                        $request->file('postFile1')->getClientOriginalExtension() == 'mov' || $request->file('postFile1')->getClientOriginalExtension() == 'wmv' ||
                        $request->file('postFile1')->getClientOriginalExtension() == 'avi' || $request->file('postFile1')->getClientOriginalExtension() == 'mkv' ||
                        $request->file('postFile1')->getClientOriginalExtension() == 'webm'
                    ) {
//                        dd(6);
                        $fileName = Uuid::uuid() . '.' . $request->file('postFile1')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/post/videos/' . $fileName, file_get_contents($request->file('postFile1')));
                    } else {
                        $fileName = Uuid::uuid() . '.' . $request->file('postFile1')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/post/' . $fileName, file_get_contents($request->file('postFile1')));
                    }

                }
//                dd($request->get('postId'));
                $postImageCaption = CommunityUserPostFileType::where('post_id', $request->get('postId'))->first()->update([
                    'post_image_video' => $fileName,
                    'caption' => $request->get('imageCaption'),
                ]);
            }
        }
//        if ($request->get('tagId')) {
//
//            $input['tagId'] = $request->input('tagId');
//                dd(is_array($input['tagId']));
//            if (is_array($input['tagId'])) {
//                foreach ($input['tagId'] as $key => $value) {
//                    $tagUsers = CommunityUserPostTag::insert([
//                        'user_id' => Auth::id(),
//                        'tag_user_id' => $value,
//                        'user_post_id' => $userPost->id,
//                        'created_at' => Carbon::now(),
//                        'updated_at' => Carbon::now(),
//                    ]);
//                }
//            }
//        }

        if ($userPost || $postImageCaption) {
//            toastr('dd', 'success');
            toastr()->success('Post has been updated successfully!', 'Congrats');
            return Redirect::back();
        }
        toastr()->error('An error has occurred please try again later.');

        $postId = $request->get('postId');
    }

    public function destroy($id)
    {

//        $postImage = $postImage->post_image_video;
//        $mediaExtension = explode('.', $postImage);
//        if ($mediaExtension[1] == 'mp4' || $mediaExtension[1] == 'mov' || $mediaExtension[1] == 'wmv' ||
//            $mediaExtension[1] == 'avi' || $mediaExtension[1] == 'mkv' || $mediaExtension[1] == 'webm'
//        ) {
//          @dd(1);
//            $dltVideo = Storage::delete('public/community/post/videos/' . $postImage);
//
//        } else {
//            $dltImag = Storage::delete('public/community/post/' . $postImage);
//
//        }

        $postImage = CommunityUserPostFileType::where('post_id', '=', $id)->first();
//        $postImage = $postImage->post_image_video;
//        dd($postImage);
        if ($postImage) {
            $postImage = $postImage->post_image_video;
//            dd($postImage);
            $mediaExtension = explode('.', $postImage);
            if ($mediaExtension[1] == 'mp4' || $mediaExtension[1] == 'mov' || $mediaExtension[1] == 'wmv' ||
                $mediaExtension[1] == 'avi' || $mediaExtension[1] == 'mkv' || $mediaExtension[1] == 'webm'
            ) {
//                @dd(1);
                $dltVideo = Storage::delete('public/community/post/videos/' . $postImage);
                $dltPostTag = CommunityUserPostTag::where('user_post_id', '=', $id)->delete();
                $dltPostComment = CommunityUserPostComment::where('user_post_id', '=', $id)->delete();
                $dltPostTag = CommunityUserPostReaction::where('user_post_id', '=', $id)->delete();
                $dltPost = CommunityUserPost::find($id)->delete();

            } else {
                $dltImag = Storage::delete('public/community/post/' . $postImage);
                $dltPostTag = CommunityUserPostTag::where('user_post_id', '=', $id)->delete();
                $dltPostComment = CommunityUserPostComment::where('user_post_id', '=', $id)->delete();
                $dltPostTag = CommunityUserPostReaction::where('user_post_id', '=', $id)->delete();
                $dltPost = CommunityUserPost::find($id)->delete();

            }
        } else {
            $dltPostTag = CommunityUserPostTag::where('user_post_id', '=', $id)->delete();
            $dltPostComment = CommunityUserPostComment::where('user_post_id', '=', $id)->delete();
            $dltPostTag = CommunityUserPostReaction::where('user_post_id', '=', $id)->delete();
            $dltPost = CommunityUserPost::find($id)->delete();
//            dd($dltPost);
        }

        if ($dltPost) {
            return Redirect::back()->with('success', 'Post Deleted Successfully');
        } else {
            return Redirect::back()->with('error', 'Something Wrong');

        }


//        return $postImage;
//        return 'deleted';

    }

}
