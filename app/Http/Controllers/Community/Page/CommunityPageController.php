<?php

namespace App\Http\Controllers\Community\Page;

use App\Http\Controllers\Controller;
use App\Models\Community\Page\CommunityPage;
use App\Models\Community\Page\CommunityPagePost;
use App\Models\Community\Page\CommunityPagePostComment;
use App\Models\User;
use Illuminate\Http\Request;

class CommunityPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = array();

        $data['allPageCount'] = CommunityPage::count('page_name');
        $data['allPagePostCount'] = CommunityPagePost::count('id');
        $data['allPageCommentCount'] = CommunityPagePostComment::count('id');


        return view('admin.community-page.dashboard', $data);
    }

    public function allPage()
    {
        $data = array();
//        $data['allPages'] = CommunityPage::all();
//SELECT community_pages.id, community_pages.page_name, community_pages.page_details, users.name as owner_name, count(likes.id) as likeCount,
// count(follows.id) as followCount, profile_photo.page_profile_photo, cover_photo.page_cover_photo FROM `community_pages`
//JOIN users_pages ON users_pages.page_id = community_pages.id AND users_pages.role = 1
//JOIN users ON users_pages.user_id = users.id
//Left JOIN community_page_follow_likes as likes ON likes.page_id = community_pages.id AND likes.page_like = 1
//Left JOIN community_page_follow_likes as follows ON follows.page_id = community_pages.id AND follows.page_follow = 1
//LEFT JOIN community_page_profile_photos AS profile_photo ON profile_photo.page_id = community_pages.id
//LEFT JOIN community_page_cover_photos AS cover_photo ON cover_photo.page_id = community_pages.id
//group by community_pages.id

//        $data['pageOwners'] = User::join('users_pages', 'users_pages.user_id', '=', 'users.id')
//            ->join('community_pages', 'community_pages.id', '=', 'users_pages.page_id')
//            ->join('community_page_profile_photos', 'community_page_profile_photos.page_id', '=', 'community_pages.id')
//            ->join('community_page_follow_likes', 'community_page_follow_likes.id', '=', 'community_pages.id')
//            ->whereRaw('users.id=users_pages.user_id')
//            ->whereRaw('users_pages.role=1')
//            ->get();
//        dd($data['pageOwners']);

        $data['pageOwners'] = CommunityPage::Join('users_pages', function ($q) {
            $q->on('users_pages.page_id', '=', 'community_pages.id');
            $q->where('users_pages.role', '=', 1);
        })
            ->join('users', 'users.id', '=', 'users_pages.user_id')
            ->leftJoin('community_page_follow_likes as follows', function ($q) {
                $q->on('follows.page_id', '=', 'community_pages.id');
                $q->whereRaw('follows.page_follow = 1');
            })
            ->leftJoin('community_page_follow_likes as likes', function ($q) {
                $q->on('likes.page_id', '=', 'community_pages.id');
                $q->whereRaw('likes.page_like = 1');
            })
            ->leftJoin('community_page_profile_photos as profile_photo', 'profile_photo.page_id', '=', 'community_pages.id')
            ->leftJoin('community_page_cover_photos as cover_photo', 'cover_photo.page_id', '=', 'community_pages.id')
            ->selectRaw('community_pages.id,community_pages.page_name,community_pages.page_details,users.id as uId,users.name as ownerName,profile_photo.page_profile_photo
            ,cover_photo.page_cover_photo, COUNT(likes.id) as likeCounts, COUNT(follows.id) as followCounts')
            ->groupBy('community_pages.id')
            ->get();

        return view('admin.community-page.allPage', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CommunityPage $communityPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommunityPage $communityPage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommunityPage $communityPage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunityPage $communityPage)
    {
        //
    }
}
