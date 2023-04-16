<?php

namespace App\Http\Controllers\Community\Admin\Page;

use App\Http\Controllers\Controller;
use App\Models\Community\Page\CommunityPagePost;

class CommunityPagePostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allPagePosts=CommunityPagePost::join('users','users.id','community_page_posts.user_id')
            ->join('community_pages','community_pages.id','community_page_posts.page_id')
            ->selectRaw('users.id as uId,users.name,community_pages.id as pageId,community_pages.page_name,community_page_posts.*')
            ->get();
        //return $allGroupPosts;

        return view('admin.community-page.allPagePosts',compact('allPagePosts'));

    }


    public function destroy(CommunityPagePost $communityPagePost)
    {
        //
    }
}
