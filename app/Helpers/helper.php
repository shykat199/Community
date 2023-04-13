<?php

use App\Models\Community\Group\CommunityUserGroup;
use App\Models\Community\Page\CommunityPage;
use App\Models\User;
use App\Models\Community\User\CommunityUserFollowing;
use Illuminate\Support\Facades\DB;

function allPages()
{
    $allPages = CommunityPage::Join('users_pages', function ($q) {
        $q->on('users_pages.page_id', '=', 'community_pages.id');
        $q->where('users_pages.role', '=', 1);
    })
        ->leftJoin('community_page_follow_likes as likes', function ($q) {
            $q->on('likes.page_id', '=', 'community_pages.id');
            $q->whereRaw('likes.page_like = 1');
        })
        ->leftJoin('community_page_profile_photos as profile_photo', 'profile_photo.page_id', '=', 'community_pages.id')
        ->selectRaw('community_pages.id,community_pages.page_name,profile_photo.page_profile_photo, COUNT(likes.id) as likeCounts')
        ->groupBy('community_pages.id')
        ->inRandomOrder()->limit(5)->get();
    return $allPages;

}

function allGroups()
{
    $allGroups = CommunityUserGroup::join('community_user_group_pivots', function ($q) {
        $q->on('community_user_group_pivots.group_id', '=', 'community_user_groups.id');
        $q->where('community_user_group_pivots.user_status', '=', 1);
    })
        ->leftJoin('community_user_group_pivots as group_owner_pivots', function ($q) {
            $q->on('group_owner_pivots.group_id', 'community_user_groups.id');
            $q->where('group_owner_pivots.user_status', '=', 1);
            $q->where('group_owner_pivots.group_user_role', '=', 1);
        })
        ->leftjoin('users', 'users.id', 'group_owner_pivots.user_id')
        ->leftJoin('community_user_group_profile_photos', 'community_user_group_profile_photos.group_id', 'community_user_groups.id')
        ->selectRaw('community_user_groups.id as cGroupId,community_user_groups.group_name,
            community_user_group_profile_photos.group_profile_photo,
             COUNT(community_user_group_pivots.id) as userCount
            ')
        ->groupBy('community_user_groups.id')
        ->inRandomOrder()->limit(5)
        ->get();

    return $allGroups;

}

function allUserFollowers()
{

//    select users.id as uId,users.name as userName,community_user_followings.user_following_id,community_user_followings.user_id, myFollows.id as is_followed from `community_user_followings`
//inner join `users` on `users`.`id` = `community_user_followings`.`user_id`
//LEFT JOIN `community_user_followings` as myFollows ON community_user_followings.user_id = myFollows.user_following_id
//where `community_user_followings`.`user_following_id` = 4 and `users`.`role` != 1

    $userFollowers=CommunityUserFollowing::join('users','users.id','community_user_followings.user_id')
        ->leftjoin('community_user_followings as myFollows','myFollows.user_id','myFollows.user_following_id')
        ->where('community_user_followings.user_following_id',Auth::user()->id)
        ->where('users.role','!=',ADMIN_ROLE)
        ->selectRaw('users.id as uId,users.name as userName,community_user_followings.user_following_id,
        community_user_followings.user_id,myFollows.id as is_followed')->get();

    return $userFollowers;
}

function countFollowing(){

    $countFollower=CommunityUserFollowing::join('users','users.id','community_user_followings.user_id')
        ->where('community_user_followings.user_id',Auth::user()->id)
        ->where('users.role','!=',ADMIN_ROLE)
        ->selectRaw('COUNT(community_user_followings.user_id) as userFollowings')
        ->groupBy('community_user_followings.user_id')
        ->get();

    return $countFollower;

}

function countFollowers(){

    $countFollowers=CommunityUserFollowing::join('users','users.id','community_user_followings.user_id')
        ->where('community_user_followings.user_following_id',Auth::user()->id)
        ->where('users.role','!=',ADMIN_ROLE)
        ->selectRaw('COUNT(community_user_followings.user_id) as userFollowers')
        ->groupBy('community_user_followings.user_following_id')
        ->get();

    return $countFollowers;

}

function allRequestedFriend(){

    $requestedFriendList=User::leftjoin('community_user_friend_requests','community_user_friend_requests.sender_user_id','=','users.id')
        ->join('community_user_friend_requests as countRequest','countRequest.sender_user_id','=','users.id')
        ->where('users.id','!=',Auth::id())
        ->where('users.id','!=',ADMIN_ROLE)
        ->where('community_user_friend_requests.status','=',0)
        ->where('community_user_friend_requests.receiver_user_id','=',Auth::id())
        ->selectRaw('users.id as uId,users.name as userName,community_user_friend_requests.id as reqId')
        ->get();
    return $requestedFriendList;
}

function countRequest()
{
   $countRequest=User::join('community_user_friend_requests','community_user_friend_requests.receiver_user_id','users.id')
        ->where('community_user_friend_requests.status','=',0)
        ->where('users.id','!=',ADMIN_ROLE)
        ->where('community_user_friend_requests.receiver_user_id','=',Auth::id())
       ->select(DB::raw('COUNT(community_user_friend_requests.id) as total'))
       ->groupBy('users.id')->get();
    return $countRequest;

}

function myFriends(){
    $myFriends=User::join('community_user_friends',function ($q){
        $q->on('community_user_friends.requested_user_id','=','users.id');
        $q->where('users.id','!=',ADMIN_ROLE);
        $q->where('community_user_friends.user_id','=',Auth::id());
    })
//        ->join('community_user_friends as uFriend',function ($q){
//            $q->on('uFriend.requested_user_id','=','users.id');
//            $q->where('userFrd.user_id','=',Auth::id());
//        })
        ->selectRaw('users.id as uId,users.name as userName')
//        ->groupBy('user.id')
        ->get();
    return $myFriends;
}

