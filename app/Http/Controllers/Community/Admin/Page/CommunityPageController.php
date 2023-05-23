<?php

namespace App\Http\Controllers\Community\Admin\Page;

use App\Http\Controllers\Controller;
use App\Models\Community\Page\CommunityPage;
use App\Models\Community\Page\CommunityPagePost;
use App\Models\Community\Page\CommunityPagePostComment;
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
            ->selectRaw('community_pages.id,community_pages.page_name,community_pages.page_details,users.id as uId,users.name as ownerName,
            profile_photo.page_profile_photo
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
