<?php

namespace App\Http\Controllers\Community\Frontend\Page;

use App\Http\Controllers\Controller;
use App\Models\Community\Group\CommunityUserGroup;
use App\Models\Community\Group\CommunityUserGroupPivot;
use App\Models\Community\Group\CommunityUserGroupPost;
use App\Models\Community\Group\CommunityUserGroupPostComment;
use App\Models\Community\Group\CommunityUserGroupPostFile;
use App\Models\Community\Group\CommunityUserGroupPostReaction;
use App\Models\Community\Page\CommunityPage;
use App\Models\Community\Page\CommunityPagePost;
use App\Models\Community\Page\CommunityPagePostComment;
use App\Models\Community\Page\CommunityPagePostCommentReaction;
use App\Models\Community\Page\CommunityPagePostFileType;
use App\Models\Community\Page\CommunityPagePostReaction;
use App\Models\Community\Page\UsersPage;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class CommunityUserPageController extends Controller
{
    public function index()
    {

        $allAvailablePages = CommunityPage::join('users', function ($q) {
            $q->on('users.id', '=', 'community_pages.user_id');
            $q->where('community_pages.user_id', '!=', Auth::id());
        })
            ->leftJoin('community_page_profile_photos as pageProfile', 'pageProfile.page_id', '=', 'community_pages.id')
            ->leftJoin('community_page_cover_photos as pageCover', 'pageCover.page_id', '=', 'community_pages.id')
            ->selectRaw('community_pages.id as pId,community_pages.page_name as pName,pageProfile.page_profile_photo as pProfile,pageCover.page_cover_photo as pCover,
            community_pages.created_at')
            ->get();

//        return $allAvailablePages;

        $myPages = CommunityPage::join('users', function ($q) {
            $q->on('users.id', '=', 'community_pages.user_id');
            $q->where('community_pages.user_id', '=', Auth::id());
        })
            ->leftJoin('community_page_profile_photos as pageProfile', 'pageProfile.page_id', '=', 'community_pages.id')
            ->leftJoin('community_page_cover_photos as pageCover', 'pageCover.page_id', '=', 'community_pages.id')
            ->selectRaw('community_pages.id as pId,community_pages.page_name as pName,pageProfile.page_profile_photo as pProfile,pageCover.page_cover_photo as pCover,
            community_pages.created_at')
            ->get();

//        return $myPages;

        return view('community-frontend.pageSection', compact('allAvailablePages', 'myPages'));
    }


    public function createPage(Request $request)
    {

        $createPage = CommunityPage::create([
            'page_name' => $request->get('pageName'),
            'page_details' => $request->get('pageDescription'),
            'user_id' => Auth::id(),
        ]);

        if ($createPage) {
            return \Redirect::back()->with('success', 'Page Created Successfully');
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


    public function getSinglePageView($id)
    {
        $getPageDetails = CommunityPage::join('users', function ($q) use ($id) {
            $q->on('users.id', '=', 'community_pages.user_id');
            $q->where('community_pages.id', '=', $id);
        })
            ->leftjoin('community_page_profile_photos as pageProfile', 'pageProfile.page_id', '=', 'community_pages.id')
            ->leftjoin('community_page_cover_photos as pageCover', 'pageCover.page_id', '=', 'community_pages.id')
//            ->join('users', function ($q) {
//                $q->on('groupUserPivot.user_id', '=', 'users.id');
//                $q->where('users.id', '!=', ADMIN_ROLE);
//                $q->where('groupUserPivot.user_status', '!=', 0);
//            })
            ->selectRaw('community_pages.id as pId,
            community_pages.page_name,
            community_pages.page_details,
            pageProfile.page_profile_photo as pageProfile,
            pageCover.page_cover_photo as pageCover,
            users.name as admin')
            ->first();

//        return $getPageDetails;

        $pagePosts = CommunityPagePost::with('users.userProfileImages')
            ->join('community_pages as communityPages', function ($q) use ($id) {
                $q->on('communityPages.id', '=', 'community_page_posts.page_id');
                $q->where('community_page_posts.page_id', '=', $id);
            })
            ->join('users', 'users.id', '=', 'community_page_posts.user_id')
            ->leftJoin('community_page_post_file_types as userPagePostFileType', function ($q) {
                $q->on('userPagePostFileType.page_post_id', '=', 'community_page_posts.id');
            })
            ->leftJoin('community_page_post_reactions as postReaction', function ($q) {
                $q->on('postReaction.page_post_id', '=', 'community_page_posts.id');
            })
            ->selectRaw('community_page_posts.id as pId,communityPages.page_name as pName,community_page_posts.post_description,users.id as user_id,
            users.name as userName,userPagePostFileType.post_comment_caption,userPagePostFileType.post_image_video,
            community_page_posts.created_at,community_page_posts.id as pagePostId,postReaction.reaction_type')
            ->orderBy('community_page_posts.id', 'DESC')
//            ->groupBy('users.id')
            ->get();

//        return $pagePosts;

        return view('community-frontend.layout.singlePageView', compact('getPageDetails', 'pagePosts'));
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

    public function updatePagePost(Request $request)
    {

//        dd($request->all());

        if ($request->get('imageCaption') === null && $request->hasFile('postFile1') === null) {
//            dd(1);
            $userPost = CommunityPagePost::find($request->get('postId'))->update([
//                'user_id' => Auth::id(),
                'post_description' => $request->get('postMessage')
            ]);

        } else {
//            dd(2);
            $fileName = null;
            if ($request->hasFile('postFile1') !== null || $request->get('imageCaption') !== null) {
//                dd(2);
                $userPost = CommunityPagePost::find($request->get('postId'))->update([
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
//                    dd(4);
                        $fileName = Uuid::uuid() . '.' . $request->file('postFile')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/page-post/videos/' . $fileName, file_get_contents($request->file('postFile')));
                    } else {
//                    dd(5,$fileName);
                        $fileName = Uuid::uuid() . '.' . $request->file('postFile')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/page-post/' . $fileName, file_get_contents($request->file('postFile')));
                    }

                    $postImageCaption = CommunityPagePostFileType::where('page_post_id', $request->get('postId'))->update([
                        'post_image_video' => $fileName,
                        'post_comment_caption' => $request->get('imageCaption'),
                    ]);
                }
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


    public function userPagePostStore(Request $request)
    {
//        dd($request->all());
//      dd($request->get('pa    geId'));
        if ($request->get('imageCaption') && $request->get('imageCaption') === null) {
//            dd(1);
            $storePagePost = CommunityPagePost::create([
                'page_id' => $request->get('pageId'),
                'user_id' => Auth::id(),
                'post_description' => $request->get('postMessage'),
            ]);
        } else {
//            dd(2);
            $fileName = null;
            if ($request->hasFile('postFile') !== null || $request->get('imageCaption') !== null) {
//                dd(3);
                $storePagePost = CommunityPagePost::create([
                    'page_id' => $request->get('pageId'),
                    'user_id' => Auth::id(),
                    'post_description' => $request->get('postMessage'),
                ]);
                if ($request->hasFile('postFile')) {

                    if ($request->file('postFile')->getClientOriginalExtension() == 'mp4' || $request->file('postFile')->getClientOriginalExtension() == 'mov' ||
                        $request->file('postFile')->getClientOriginalExtension() == 'wmv' || $request->file('postFile')->getClientOriginalExtension() == 'avi' ||
                        $request->file('postFile')->getClientOriginalExtension() == 'mkv' || $request->file('postFile')->getClientOriginalExtension() == 'webm'
                    ) {
//                    dd(4);
                        $fileName = Uuid::uuid() . '.' . $request->file('postFile')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/page-post/videos/' . $fileName, file_get_contents($request->file('postFile')));
                    } else {
//                    dd(5,$fileName);
                        $fileName = Uuid::uuid() . '.' . $request->file('postFile')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/page-post/' . $fileName, file_get_contents($request->file('postFile')));
                    }
                    $pagePostFile = CommunityPagePostFileType::create([
                        'page_post_id' => $storePagePost->id,
                        'post_comment_caption' => $request->get('imageCaption'),
                        'post_image_video' => $fileName,
                    ]);
                }
            }

        }


        if ($storePagePost || $pagePostFile) {
//            toastr('dd', 'success');
            toastr()->success('Post has been posted successfully!', 'Congrats');
            return Redirect::back();
        }
        toastr()->error('An error has occurred please try again later.');


    }

    public function storeUserPagePostReaction(Request $request)
    {

        $storePostReaction = '';

        if ($request->ajax()) {
            $userId = Auth::id();
            $getReaction = $request->get('getReaction');
            $pagePostId = $request->get('pagePostId');

//            @dd($request->all());
            if ($userId !== null && $getReaction !== null && $pagePostId !== null) {

                $storePostReaction = CommunityPagePostReaction::create([
                    'user_id' => $userId,
                    'page_post_id' => $pagePostId,
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

    public function destroyPagePost($id)
    {
//        dd($id);

        $postImage = CommunityPagePostFileType::where('page_post_id', '=', $id)->first();
//        $postImage = $postImage->post_image_video;
//        dd($postImage);
        if ($postImage !== null) {
//            dd(1);
            $postImage = $postImage->post_image_video;
//            dd($postImage);
            $mediaExtension = explode('.', $postImage);

            if ($mediaExtension[1] == 'mp4' || $mediaExtension[1] == 'mov' || $mediaExtension[1] == 'wmv' ||
                $mediaExtension[1] == 'avi' || $mediaExtension[1] == 'mkv' || $mediaExtension[1] == 'webm'
            ) {
//                @dd(1);
                $dltVideo = Storage::delete('public/community/page-post/videos/' . $postImage);
                $dltPostComment = CommunityPagePostComment::where('page_post_id', '=', $id)->delete();
                $dltPostFile = CommunityPagePostFileType::where('page_post_id', '=', $id)->delete();
//                $dltPostCommentReaction = CommunityUserGroupPostCommentReaction::where('group_post_id', '=', $id)->delete();
                $dltPostReaction = CommunityPagePostReaction::where('page_post_id', '=', $id)->delete();
                $dltPost = CommunityPagePost::find($id)->delete();

            } else {
                $dltImag = Storage::delete('public/community/group-post/' . $postImage);
                $dltPostComment = CommunityPagePostComment::where('page_post_id', '=', $id)->delete();
                $dltPostFile = CommunityPagePostFileType::where('page_post_id', '=', $id)->delete();
//                $dltPostCommentReaction = CommunityUserGroupPostCommentReaction::where('group_post_id', '=', $id)->delete();
                $dltPostReaction = CommunityPagePostReaction::where('page_post_id', '=', $id)->delete();
                $dltPost = CommunityPagePost::find($id)->delete();

            }
        } else {
//            dd(2);
            $dltPostComment = CommunityPagePostComment::where('page_post_id', '=', $id)->delete();
            $dltPostFile = CommunityPagePostFileType::where('page_post_id', '=', $id)->delete();
//                $dltPostCommentReaction = CommunityUserGroupPostCommentReaction::where('group_post_id', '=', $id)->delete();
            $dltPostReaction = CommunityPagePostReaction::where('page_post_id', '=', $id)->delete();
            $dltPost = CommunityPagePost::find($id)->delete();
//            dd($dltPost);
        }

        if ($dltPost) {
            return Redirect::back()->with('success', 'Post Deleted Successfully');
        } else {
            return Redirect::back()->with('error', 'Something Wrong');

        }


    }
}
