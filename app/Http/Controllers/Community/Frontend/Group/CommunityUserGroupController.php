<?php

namespace App\Http\Controllers\Community\Frontend\Group;

use App\Http\Controllers\Controller;
use App\Models\Community\Group\CommunityUserGroup;
use App\Models\Community\Group\CommunityUserGroupPost;
use App\Models\Community\Group\CommunityUserGroupPostFile;
use Faker\Provider\Uuid;
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

//        return $getGroupDetails;

        return view('community-frontend.layout.singleGroupView', compact('getGroupDetails'));
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
        if ($request->get('imageCaption')===null || $request->hasFile('postFile') === null) {
            $storeGroupPost = CommunityUserGroupPost::create([
                'group_id' => $request->get('groupId'),
                'user_id' => Auth::id(),
                'post_description' => $request->get('postMessage'),
            ]);
        }
        else {

            $image = null;
            if ($request->hasFile('postFile') !== null || $request->get('imageCaption')!==null) {
                $storeGroupPost = CommunityUserGroupPost::create([
                    'group_id' => $request->get('groupId'),
                    'user_id' => Auth::id(),
                    'post_description' => $request->get('postMessage'),
                ]);

                if ($request->hasFile('postFile')) {
                    $image = Uuid::uuid() . '.' . $request->file('postFile')->getClientOriginalExtension();
                    $name = Storage::put('/public/community/group-post/' . $image, file_get_contents($request->file("postFile")));
                }

                $GroupPostFile = CommunityUserGroupPostFile::create([
                    'group_post_id' => $storeGroupPost->id,
                    'group_post_caption' => $request->get('imageCaption'),
                    'group_post_file' => $image,
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


}
