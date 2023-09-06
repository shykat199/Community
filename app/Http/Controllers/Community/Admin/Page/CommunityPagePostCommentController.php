<?php

namespace App\Http\Controllers\Community\Admin\Page;

use App\Http\Controllers\Controller;
use App\Models\Community\Group\CommunityUserGroup;
use App\Models\Community\Group\CommunityUserGroupPostComment;
use App\Models\Community\Page\CommunityPage;
use App\Models\Community\Page\CommunityPagePost;
use App\Models\Community\Page\CommunityPagePostComment;
use Illuminate\Http\Request;

class CommunityPagePostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        dd($request->get('pagePostId'));

        $pagePostId=$request->get('pagePostId');
//        dd($pagePostId);


        $pagePostAllComments=CommunityPagePostComment::join('community_page_posts','community_page_posts.id','community_page_post_comments.page_post_id')
            ->join('users','users.id','community_page_post_comments.user_id')
            ->selectRaw('community_page_posts.*,community_page_post_comments.*,users.name')
            ->where('community_page_post_comments.page_post_id','=',$pagePostId)
            ->get();
//        return $pagePostAllComments;

        $countTotalComment=CommunityPagePostComment::join('community_page_posts','community_page_posts.id','community_page_post_comments.page_post_id')
            ->join('users','users.id','community_page_post_comments.user_id')
            ->selectRaw('community_page_posts.*,community_page_post_comments.*,users.name,COUNT(community_page_post_comments.id) as totalComments')
            ->where('community_page_post_comments.page_post_id','=',$pagePostId)
            ->groupBy('community_page_posts.id')
            ->get();

        $postedUser=CommunityPagePostComment::join('community_page_posts','community_page_posts.id','community_page_post_comments.page_post_id')
            ->join('users','users.id','community_page_posts.user_id')
            ->selectRaw('users.name,community_page_post_comments.user_id,community_page_post_comments.page_post_comment_id,community_page_posts.*')
            ->where('community_page_post_comments.page_post_id','=',$pagePostId)
            ->first();

        $postCommented=CommunityPagePostComment::join('community_page_posts','community_page_posts.id','community_page_post_comments.page_post_id')
            ->selectRaw('community_page_posts.*')
            ->where('community_page_post_comments.page_post_id','=',$pagePostId)
            ->first();
//        return $postCommented;
        return view('admin.community-page.commentOfPost',compact('pagePostAllComments','postCommented','postedUser','countTotalComment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function allPagePost($id)
    {
        $allPagePost=CommunityPage::join('community_page_posts','community_page_posts.page_id','=','community_pages.id')
            ->where('community_page_posts.page_id','=',$id)
            ->join('users','users.id','=','community_page_posts.user_id')
            ->selectRaw('community_pages.id as pId,community_pages.page_name,
            community_page_posts.id as pPostId,community_page_posts.post_description,community_page_posts.created_at,
            users.id as uId,users.name
            ')
            ->latest()->get();

        return view('admin.community-page.singlePagePost',compact('allPagePost'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function pagePostComment($id)
    {

        $allPostComments=CommunityPagePostComment::with(['users.userProfileImages', 'replies'])->where('page_post_id','=',$id)
            ->join('users','users.id','=','community_page_post_comments.user_id')
            ->where('page_post_comment_id','=',0)
            ->selectRaw('users.id as user_id,users.name as userName,
            community_page_post_comments.id,community_page_post_comments.comment_text,
            community_page_post_comments.created_at,community_page_post_comments.page_post_id as pagePostId,
            community_page_post_comments.page_post_comment_id as motherCmtId')
            ->get();

        return view('admin.community-page.commentOfPost',compact('allPostComments'));


    }

    /**
     * Display the specified resource.
     */
    public function show(CommunityPagePostComment $communityPagePostComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommunityPagePostComment $communityPagePostComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommunityPagePostComment $communityPagePostComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunityPagePostComment $communityPagePostComment)
    {
        //
    }
}
