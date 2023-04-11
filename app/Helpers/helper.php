<?php

use App\Models\Community\Group\CommunityUserGroup;
use App\Models\Community\Page\CommunityPage;

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

