<?php

namespace App\Http\Controllers\Community\Frontend\Group;

use App\Http\Controllers\Controller;
use App\Models\Community\Group\CommunityUserGroup;
use App\Models\Community\Group\CommunityUserGroupPost;
use App\Models\Community\Group\CommunityUserGroupPostComment;
use App\Models\Community\Group\CommunityUserGroupPostCommentReaction;
use App\Models\Community\Group\CommunityUserGroupPostFile;
use App\Models\Community\Group\CommunityUserGroupPostReaction;
use App\Models\Community\User\CommunityUserPost;
use App\Models\Community\User\CommunityUserPostFileType;
use App\Models\Community\User\CommunityUserPostTag;
use App\Models\Community\User_Post\CommunityUserPostComment;
use App\Models\Community\User_Post\CommunityUserPostReaction;
use Faker\Provider\Uuid;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Community\Group\CommunityUserGroupPivot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class CommunityUserGroupController extends Controller
{
    public function index()
    {

        $allAvailableGroups = CommunityUserGroup::join('community_user_group_pivots as groupPivot', function ($q) {
            $q->on('groupPivot.group_id', '=', 'community_user_groups.id');
            $q->where('groupPivot.user_id', '!=', Auth::id());
        })
            ->leftJoin('community_user_group_profile_photos as groupProfile', 'groupProfile.group_id', '=', 'community_user_groups.id')
            ->leftJoin('community_user_group_cover_photos as groupCover', 'groupCover.group_id', '=', 'community_user_groups.id')
            ->selectRaw('community_user_groups.id as gId,community_user_groups.group_name as gName,
            community_user_groups.group_details as gDetails,COUNT(groupPivot.id) userCount,groupProfile.group_profile_photo as gProfile,groupCover.cover_photo as gCover,
            community_user_groups.created_at,groupPivot.user_status')
            ->groupBy('community_user_groups.id')
            ->get();

//        return $allAvailableGroups;

        $myGroups = CommunityUserGroup::join('community_user_group_pivots as groupPivot', function ($q) {

            $q->on('groupPivot.group_id', '=', 'community_user_groups.id');
            $q->where('groupPivot.user_id', '=', Auth::id());
            $q->where('groupPivot.group_user_role', '=', 1);
            $q->where('groupPivot.user_status', '=', 1);

        })
            ->leftJoin('community_user_group_profile_photos as groupProfile', 'groupProfile.group_id', '=', 'community_user_groups.id')
            ->leftJoin('community_user_group_cover_photos as groupCover', 'groupCover.group_id', '=', 'community_user_groups.id')
            ->selectRaw('community_user_groups.id as gId,community_user_groups.group_name as gName,
            community_user_groups.group_details as gDetails,COUNT(groupPivot.id) userCount,groupProfile.group_profile_photo as gProfile,
            groupCover.cover_photo as gCover,community_user_groups.created_at,groupPivot.user_status')
            ->groupBy('community_user_groups.id')
            ->get();

//        return $myGroups;

        return view('community-frontend.groupSection', compact('allAvailableGroups', 'myGroups'));
    }


    public function createGroup(Request $request)
    {

        $createGroup = CommunityUserGroup::create([
            'group_name' => $request->get('groupName'),
            'group_details' => $request->get('groupDescription'),
        ]);

        if ($createGroup) {
            $createGroupUser = CommunityUserGroupPivot::create([
                'group_id' => $createGroup->id,
                'user_id' => Auth::id(),
                'group_user_role' => 1,
                'user_status' => 1,
            ]);
        }

        if ($createGroup && $createGroupUser) {
            return \Redirect::back()->with('success', 'Group Created Successfully');
        } else {
            return \Redirect::back()->with('error', 'Something Error');
        }

    }


    public function storeUserRequest(Request $request)
    {

        $storeUser = $createGroupUser = CommunityUserGroupPivot::create([
            'group_id' => $request->get('groupId'),
            'user_id' => Auth::id(),
            'group_user_role' => 3,
            'user_status' => 0,
        ]);

        if ($storeUser) {
            return \Redirect::back()->with('success', 'Request has been send.');
        } else {
            return \Redirect::back()->with('error', 'Something Error.');
        }

    }


    public function getSingleGroupView($id)
    {
        $getGroupDetails = CommunityUserGroup::join('community_user_group_pivots as groupUserPivot', function ($q) use ($id) {
            $q->on('groupUserPivot.group_id', '=', 'community_user_groups.id');
            $q->where('groupUserPivot.group_id', '=', $id);
        })
            ->leftjoin('community_user_group_profile_photos as groupProfile', 'groupProfile.group_id', '=', 'community_user_groups.id')
            ->leftjoin('community_user_group_cover_photos as groupCover', 'groupCover.group_id', '=', 'community_user_groups.id')
            ->join('users', function ($q) {
                $q->on('groupUserPivot.user_id', '=', 'users.id');
                $q->where('users.id', '!=', ADMIN_ROLE);
                $q->where('groupUserPivot.user_status', '!=', 0);
            })
            ->selectRaw('community_user_groups.id as gId,
            community_user_groups.group_name,
            community_user_groups.group_details,
            groupProfile.group_profile_photo as groupProfile,
            groupCover.cover_photo,users.name as admin,
            COUNT(groupUserPivot.id) as userCount')
            ->groupBy('community_user_groups.id')
            ->first();


        $groupPosts = CommunityUserGroupPost::with('users.userProfileImages')
            ->join('community_user_groups as communityGroups', function ($q) use ($id) {
                $q->on('communityGroups.id', '=', 'community_user_group_posts.group_id');
                $q->where('community_user_group_posts.group_id', '=', $id);
            })
            ->join('users', 'users.id', '=', 'community_user_group_posts.user_id')
            ->leftJoin('community_user_group_post_files as userGroupPostFileType', function ($q) {
                $q->on('userGroupPostFileType.group_post_id', '=', 'community_user_group_posts.id');
            })
            ->leftJoin('community_user_group_post_reactions as postReaction', function ($q) {
                $q->on('postReaction.group_post_id', '=', 'community_user_group_posts.id');
            })
            ->selectRaw('community_user_group_posts.id as gId,communityGroups.group_name as gName,community_user_group_posts.post_description,users.id as user_id,
            users.name as userName,userGroupPostFileType.group_post_caption,userGroupPostFileType.group_post_file,
            community_user_group_posts.created_at,community_user_group_posts.id as grpPostId,postReaction.reaction_type')
            ->orderBy('community_user_group_posts.id', 'DESC')
//            ->groupBy('users.id')
            ->get();

//        return $groupPosts;

        return view('community-frontend.layout.singleGroupView', compact('getGroupDetails', 'groupPosts'));
    }

    public function acceptGroupUserInvitation(Request $request)
    {

        if ($request->ajax()) {
            $userId = $request->get('userId');
            $gId = $request->get('gId');
            $id = $request->get('id');

            $updateGroupUserStatus = CommunityUserGroupPivot::find($id)->update([
                'user_status' => 1
            ]);

            if ($updateGroupUserStatus) {
                return \response()->json([
                    'status' => true,
                    'success' => true,
                    'msg' => 'Successfully Added.',
                ]);
            } else {
                return \response()->json([
                    'status' => true,
                    'success' => false,
                    'msg' => 'Something wrong.',
                ]);
            }
        }
    }


    public function userGroupPostStore(Request $request)
    {
//        dd($request->all());
        if ($request->get('imageCaption') === null && $request->hasFile('postFile') === null) {
//            dd(1);
            $storeGroupPost = CommunityUserGroupPost::create([
                'group_id' => $request->get('groupId'),
                'user_id' => Auth::id(),
                'post_description' => $request->get('postMessage'),
            ]);
        } else {
//            dd(2);
            $fileName = null;
            if ($request->hasFile('postFile') !== null || $request->get('imageCaption') !== null) {

                $storeGroupPost = CommunityUserGroupPost::create([
                    'group_id' => $request->get('groupId'),
                    'user_id' => Auth::id(),
                    'post_description' => $request->get('postMessage'),
                ]);

                if ($request->file('postFile')->getClientOriginalExtension() == 'mp4' || $request->file('postFile')->getClientOriginalExtension() == 'mov' ||
                    $request->file('postFile')->getClientOriginalExtension() == 'wmv' || $request->file('postFile')->getClientOriginalExtension() == 'avi' ||
                    $request->file('postFile')->getClientOriginalExtension() == 'mkv' || $request->file('postFile')->getClientOriginalExtension() == 'webm'
                ) {
                    $fileName = Uuid::uuid() . '.' . $request->file('postFile')->getClientOriginalExtension();
                    $file = Storage::put('/public/community/group-post/videos/' . $fileName, file_get_contents($request->file('postFile')));
                } else {
                    $fileName = Uuid::uuid() . '.' . $request->file('postFile')->getClientOriginalExtension();
                    $file = Storage::put('/public/community/group-post/' . $fileName, file_get_contents($request->file('postFile')));
                }
//                dd(3);

                $GroupPostFile = CommunityUserGroupPostFile::create([
                    'group_post_id' => $storeGroupPost->id,
                    'group_post_caption' => $request->get('imageCaption'),
                    'group_post_file' => $fileName,
                ]);
            }

        }


        if ($storeGroupPost || $GroupPostFile) {
//            toastr('dd', 'success');
            toastr()->success('Post has been posted successfully!', 'Congrats');
            return Redirect::back();
        }
        toastr()->error('An error has occurred please try again later.');

    }

    public function storeUserGroupPostReaction(Request $request)
    {


        if ($request->ajax()) {
            $userId = Auth::id();
            $getReaction = $request->get('getReaction');
            $grpPostId = $request->get('grpPostId');

            if ($userId !== null && $getReaction !== null && $grpPostId !== null) {

                $storePostReaction = CommunityUserGroupPostReaction::create([
                    'user_id' => $userId,
                    'group_post_id' => $grpPostId,
                    'reaction_type' => $getReaction,
                ]);
            }

            if ($storePostReaction) {
                return \response()->json([
                    'status' => true,
                    'success' => true,
                    'data' => $storePostReaction,
                    'msg' => 'Successfully Added.',
                ]);
            } else {
                return \response()->json([
                    'status' => true,
                    'success' => false,
                    'data' => $storePostReaction,
                    'msg' => 'Something wrong.',
                ]);
            }
        }

    }

    public function editPost(Request $request)
    {

        if ($request->get('imageCaption') === null && $request->hasFile('postFile1') === null) {
//            dd(1);
            $userPost = CommunityUserGroupPost::find($request->get('postId'))->update([
//                'user_id' => Auth::id(),
                'post_description' => $request->get('postMessage')
            ]);

        } else {
//            dd(2);
            $fileName = null;
            if ($request->hasFile('postFile1') !== null || $request->get('imageCaption') !== null) {
//                dd(2);
                $userPost = CommunityUserGroupPost::find($request->get('postId'))->update([
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
                $postImageCaption = CommunityUserGroupPostFile::where('group_post_id', $request->get('postId'))->update([
                    'group_post_file' => $fileName,
                    'group_post_caption' => $request->get('imageCaption'),
                ]);
            }
        }

        if ($userPost || $postImageCaption) {
//            toastr('dd', 'success');
            toastr()->success('Post has been updated successfully!', 'Congrats');
            return Redirect::back();
        } else {
            toastr()->error('An error has occurred please try again later.');

        }

    }


    public function destroy(Request $request)
    {

        if ($request->ajax()) {
            $userId = $request->get('userId');
            $gId = $request->get('gId');
            $pivotId = $request->get('pivotId');

            $removeUser = CommunityUserGroupPivot::find($pivotId)->delete();
        }

        if ($removeUser) {
            return \response()->json([
                'status' => true,
                'success' => true,
                'msg' => "Successfully Deleted."
            ]);
        } else {
            return \response()->json([
                'status' => true,
                'success' => false,
                'msg' => 'Something wrong.',
            ]);
        }

    }


    public function destroyPost($id)
    {
//        dd(1);
        $postImage = CommunityUserGroupPostFile::where('group_post_id', '=', $id)->first();
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
                $dltVideo = Storage::delete('public/community/group-post/videos/' . $postImage);
                $dltPostComment = CommunityUserGroupPostComment::where('group_post_id', '=', $id)->delete();
//                $dltPostCommentReaction = CommunityUserGroupPostCommentReaction::where('group_post_id', '=', $id)->delete();
                $dltPostReaction = CommunityUserGroupPostReaction::where('group_post_id', '=', $id)->delete();
                $dltPost = CommunityUserGroupPost::find($id)->delete();

            } else {
                $dltImag = Storage::delete('public/community/group-post/' . $postImage);
                $dltPostComment = CommunityUserGroupPostComment::where('group_post_id', '=', $id)->delete();
//                $dltPostCommentReaction = CommunityUserGroupPostCommentReaction::where('group_post_id', '=', $id)->delete();
                $dltPostReaction = CommunityUserGroupPostReaction::where('group_post_id', '=', $id)->delete();
                $dltPost = CommunityUserGroupPost::find($id)->delete();

            }
        } else {
            $dltPostComment = CommunityUserGroupPostComment::where('group_post_id', '=', $id)->delete();
//          dltPostCommentReaction = CommunityUserGroupPostCommentReaction::where('group_post_id', '=', $id)->delete();
            $dltPostReaction = CommunityUserGroupPostReaction::where('group_post_id', '=', $id)->delete();
            $dltPost = CommunityUserGroupPost::find($id)->delete();
//            dd($dltPost);
        }

        if ($dltPost) {
            return Redirect::back()->with('success', 'Post Deleted Successfully');
        } else {
            return Redirect::back()->with('error', 'Something Wrong');

        }

    }


}
