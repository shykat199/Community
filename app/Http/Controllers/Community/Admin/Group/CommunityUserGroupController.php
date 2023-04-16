<?php

namespace App\Http\Controllers\Community\Admin\Group;

use App\Http\Controllers\Controller;
use App\Models\Community\Group\CommunityUserGroup;
use App\Models\Community\User\CommunityUserDetails;
use App\Models\User;

class CommunityUserGroupController extends Controller
{

    public function commonQuery(){
        $allGroups=CommunityUserGroup::join('community_user_group_pivots',function ($q){
            $q->on('community_user_group_pivots.group_id','=','community_user_groups.id');
            $q->where('community_user_group_pivots.user_status','=',1);
        })
            ->leftJoin('community_user_group_pivots as group_owner_pivots',function ($q){
                $q->on('group_owner_pivots.group_id','community_user_groups.id');
                $q->where('group_owner_pivots.user_status','=',1);
                $q->where('group_owner_pivots.group_user_role','=',1);
            })
            ->leftjoin('users','users.id','group_owner_pivots.user_id')

            ->leftJoin('community_user_group_profile_photos','community_user_group_profile_photos.group_id','community_user_groups.id')
            ->leftJoin('community_user_group_cover_photos','community_user_group_cover_photos.group_id','community_user_groups.id')

            ->selectRaw('community_user_groups.id as cGroupId,community_user_groups.group_name,community_user_groups.group_details,
            community_user_group_cover_photos.cover_photo,community_user_group_cover_photos.cover_photo,
            users.id as uId,users.name as ownerName, COUNT(community_user_group_pivots.id) as userCount
            ')
            ->groupBy('community_user_groups.id')
            ->get();
        return $allGroups;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.community-group.dashboard');
    }

    public function allGroups()
    {
        $allGroups=$this->commonQuery();

        return view('admin.community-group.allGroup',compact('allGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function allGroupsUsers()
    {
        $allGroups=$this->commonQuery();
        return view('admin.community-group.allUsers',compact('allGroups'));
    }

    public function allGroupsUsersDetails($id)
    {
//        dd($id);
        $allGroupUser=User::join('community_user_group_pivots','community_user_group_pivots.user_id','=','users.id')

            ->join('community_user_groups',function ($q) use ($id){
                $q->on('community_user_groups.id','=','community_user_group_pivots.group_id');
                $q->where('community_user_group_pivots.group_id','=',$id);
                $q->where('community_user_group_pivots.user_status','!=',0);
            })
            ->where('users.id','!=',ADMIN_ROLE)
            ->selectRaw('users.id as uId,users.name,users.email,
            community_user_group_pivots.group_user_role,community_user_groups.id as gId,community_user_groups.group_name,community_user_groups.group_details,community_user_groups.group_name')
            ->orderBy('community_user_group_pivots.group_user_role','ASC')
            ->get();
//        return $allGroupUser;

        return view('admin.community-group.allGroupUsers',compact('allGroupUser'));
    }

    public function singleUserProfile($id){

        $singleUser=CommunityUserDetails::join('users','users.id','community_user_details.user_id')
            ->where('community_user_details.user_id','=',$id)
            ->selectRaw('users.id as uId,users.name,users.email,community_user_details.*')
            ->get();
//        return $singleUser;
        return view('admin.community-group.singleUsersDetails',compact('singleUser'));
    }

    public function viewSingleUserProfile($id){
        return "User Profile";
    }

}
