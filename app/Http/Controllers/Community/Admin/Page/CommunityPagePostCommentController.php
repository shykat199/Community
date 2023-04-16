<?php

namespace App\Http\Controllers\Community\Admin\Page;

use App\Http\Controllers\Controller;
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
