<?php

namespace App\Http\Controllers\Community\Frontend\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\PagePostRequest;
use App\Models\Community\Group\CommunityUserGroup;
use App\Models\Community\Group\CommunityUserGroupPivot;
use App\Models\Community\Group\CommunityUserGroupPost;
use App\Models\Community\Group\CommunityUserGroupPostComment;
use App\Models\Community\Group\CommunityUserGroupPostFile;
use App\Models\Community\Group\CommunityUserGroupPostReaction;
use App\Models\Community\Page\CommunityPage;
use App\Models\Community\Page\CommunityPageCoverPhoto;
use App\Models\Community\Page\CommunityPagePost;
use App\Models\Community\Page\CommunityPagePostComment;
use App\Models\Community\Page\CommunityPagePostCommentReaction;
use App\Models\Community\Page\CommunityPagePostFileType;
use App\Models\Community\Page\CommunityPagePostReaction;
use App\Models\Community\Page\CommunityPageProfilePhoto;
use App\Models\Community\Page\UsersPage;
use App\Models\Community\User\CommunityUserPost;
use App\Models\Community\User\CommunityUserPostFileType;
use App\Models\Community\User_Post\CommunityUserPostReaction;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class CommunityUserPageController extends Controller
{
    public function index()
    {

        $allAvailablePages = CommunityPage::join('users', function ($q) {
            $q->on('users.id', '=', 'community_pages.user_id');
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
        $id = Crypt::decrypt($id);
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

        $pagePosts = CommunityPagePost::with(['users.userProfileImages', 'comments.replies', 'comments.commentsReaction'])
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
            ->get()->map(function ($q) {
                $q->setRelation('comments', $q->comments->take(2));
                return $q;
            });

        $pagePosts = $pagePosts->each(function ($item) {
            $item->comments->each(function ($comment) {
                $comment->load('users.userProfileImages');
            });
        });

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


    public function userPagePostStore(PagePostRequest $request)
    {


        if ($request->get('postMessage')) {

            if ($request->hasFile('videoFile') || $request->hasFile('photoFile')) {

                $storePagePost = CommunityPagePost::create([
                    'page_id' => \Crypt::decrypt($request->get('pageId')),
                    'user_id' => Auth::id(),
                    'post_description' => $request->get('postMessage'),
                ]);

                if ($request->hasFile('videoFile')) {

                    if ($request->file('videoFile')->getClientOriginalExtension() == 'mp4' ||
                        $request->file('videoFile')->getClientOriginalExtension() == 'mov' ||
                        $request->file('videoFile')->getClientOriginalExtension() == 'wmv' ||
                        $request->file('videoFile')->getClientOriginalExtension() == 'avi' ||
                        $request->file('videoFile')->getClientOriginalExtension() == 'mkv' ||
                        $request->file('videoFile')->getClientOriginalExtension() == 'webm'
                    ) {
                        $fileName = Uuid::uuid() . '.' . 'video' . '.' . $request->file('videoFile')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/page-post/videos/' . $fileName, file_get_contents($request->file('videoFile')));

                        $pagePostFile = CommunityPagePostFileType::create([
                            'page_post_id' => $storePagePost->id,
                            'post_comment_caption' => $request->get('imageCaption'),
                            'post_image_video' => $fileName,
                        ]);
//
                    }

                } else {

                    $fileName = Uuid::uuid() . '.' . 'image' . '.' . $request->file('photoFile')->getClientOriginalExtension();
                    $file = Storage::put('/public/community/page-post/' . $fileName, file_get_contents($request->file('photoFile')));

                    $pagePostFile = CommunityPagePostFileType::create([
                        'page_post_id' => $storePagePost->id,
                        'post_comment_caption' => $request->get('imageCaption'),
                        'post_image_video' => $fileName,
                    ]);

                }

            } else {

//                dd(2);
                $storePagePost = CommunityPagePost::create([
                    'page_id' => \Crypt::decrypt($request->get('pageId')),
                    'user_id' => Auth::id(),
                    'post_description' => $request->get('postMessage'),
                ]);
            }

        } else {

            $fileName = null;
//            dd($request->all());
            if ($request->hasFile('videoFile') || $request->hasFile('photoFile')) {
//                dd($request->all());
                $storePagePost = CommunityPagePost::create([
                    'page_id' => \Crypt::decrypt($request->get('pageId')),
                    'user_id' => Auth::id(),
                    'post_description' => $request->get('postMessage'),
                ]);


                if ($request->hasFile('videoFile')) {
//                    dd('v');
                    if ($request->file('videoFile')->getClientOriginalExtension() == 'mp4' ||
                        $request->file('videoFile')->getClientOriginalExtension() == 'mov' ||
                        $request->file('videoFile')->getClientOriginalExtension() == 'wmv' ||
                        $request->file('videoFile')->getClientOriginalExtension() == 'avi' ||
                        $request->file('videoFile')->getClientOriginalExtension() == 'mkv' ||
                        $request->file('videoFile')->getClientOriginalExtension() == 'webm'
                    ) {
                        $fileName = Uuid::uuid() . '.' . 'video' . '.' . $request->file('videoFile')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/page-post/videos/' . $fileName, file_get_contents($request->file('videoFile')));

                        $pagePostFile = CommunityPagePostFileType::create([
                            'page_post_id' => $storePagePost->id,
                            'post_comment_caption' => $request->get('imageCaption'),
                            'post_image_video' => $fileName,
                        ]);
//
                    }
                } else {
//                    dd('i');
                    $fileName = Uuid::uuid() . '.' . 'image' . '.' . $request->file('photoFile')->getClientOriginalExtension();
                    $file = Storage::put('/public/community/page-post/' . $fileName, file_get_contents($request->file('photoFile')));

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


        if ($request->ajax()) {

            if ($request->get('reqType') === 'storePostReaction') {

//                dd($request->all());

                $returnResult = [];
                $postId = $request->get('postId');
                $reaction_type = $request->get('postReaction');

                $checkReaction = CommunityPagePostReaction::where('page_post_id', '=', $postId)->where('user_id', '=', Auth::id())
                    ->first();

//                dd($checkReaction);
                if (!empty($checkReaction)) {

                    if ($reaction_type == $checkReaction->reaction_type) {


                        $deleteReaction = $checkReaction->delete();

                        if ($deleteReaction) {
                            $returnResult = [
                                'status' => true,
                                'msg' => 'Successfully Deleted',
                                'postComments' => $deleteReaction,
                                'flag' => 0
                            ];
                        }
                    } else {

                        $updatedReaction = $checkReaction->update([
                            'reaction_type' => $reaction_type
                        ]);

                        if ($updatedReaction) {
                            $returnResult = [
                                'status' => true,
                                'msg' => 'Successfully updated',
                                'postComments' => $updatedReaction,
                                'flag' => 2

                            ];
                        }
                    }

                } else {

                    $storePostReaction = CommunityPagePostReaction::create([
                        'page_post_id' => $request->get('postId'),
                        'user_id' => \Auth::id(),
                        'reaction_type' => $request->get('postReaction')
                    ]);

                    if ($storePostReaction) {
                        $returnResult = [
                            'status' => true,
                            'msg' => 'Successfully Added',
                            'postComments' => $storePostReaction,
                            'flag' => 1
                        ];
                    }
                }

                return \response()->json($returnResult);

            }


        }

    }


    public function storePagePostCommentReaction(Request $request)
    {
        $storeCommentReaction = CommunityPagePostCommentReaction::create([
            'page_post_comment_id' => $request->get('postCommentId'),
            'user_id' => Auth::id(),
            'reaction_type' => 1
        ]);
        if ($storeCommentReaction) {
            return response()->json([
                'status' => true,
                'msg' => 'Success',
                'data' => $storeCommentReaction
            ]);
        }
    }

    public function deleteUserPagePostCommentReaction(Request $request)
    {

        if ($request->ajax()) {

            $deleteReaction = CommunityPagePostCommentReaction::where('id', '=', $request->get('postCommentReactionId'))->delete();

            if ($deleteReaction) {
                return response()->json([
                    'status' => true,
                    'msg' => 'Success',
                    'data' => $deleteReaction
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


    public function storePageProfilePhoto(Request $request)
    {


//        dd($request->all());
        $fileName = null;
        if ($request->hasFile('grpProfile')) {

            $fileName = Uuid::uuid() . '.' . $request->file('grpProfile')->getClientOriginalExtension();
            $file = Storage::put('/public/community/page-post/profile/' . $fileName, file_get_contents($request->file('grpProfile')));

        }
        $storeProfilePicture = CommunityPageProfilePhoto::updateOrCreate([
            'page_id' => $request->get('pageId'),
        ],
            [
                'page_profile_photo' => $fileName,
            ]);

        if ($storeProfilePicture) {
            return \redirect()->back()->with('success', 'Profile has uploaded');
        }


    }


    public function storePageCoverPhoto(Request $request)
    {


//        dd($request->all());
        $fileName = null;
        if ($request->hasFile('grpCover')) {

            $fileName = Uuid::uuid() . '.' . $request->file('grpCover')->getClientOriginalExtension();
            $file = Storage::put('/public/community/page-post/cover/' . $fileName, file_get_contents($request->file('grpCover')));

        }
        $storeCoverPicture = CommunityPageCoverPhoto::updateOrCreate([
            'page_id' => $request->get('pageId'),
        ],
            [
                'page_cover_photo' => $fileName,
            ]);

        if ($storeCoverPicture) {
            return \redirect()->back()->with('success', 'Cover photo has uploaded');
        } else {
            return \redirect()->back()->with('error', 'Something error');
        }


    }

    public function storePagePostComment(Request $request)
    {

        if ($request->ajax()) {

            $postComment = CommunityPagePostComment::create([
                'user_id' => Auth::id(),
                'page_post_id' => $request->get('postId'),
                'comment_text' => $request->get('postComment')
            ]);
//            dd($postComment);
            $html = '';
            if ($postComment) {

                $html .= '
                        <li class="single-comment">
                            <div class="parent-comment">
                                    <div class="comment-img">';
                if (!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0]) ? $postComment->users->userProfileImages[0] : '') {
                    if (!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0]) ? $postComment->users->userProfileImages[0] : '') {
                        $html .= '<a class="new-comment-img replay-comment-img" href=""><img src="' . asset("storage/community/profile-picture/" . $postComment->users->userProfileImages[0]->user_profile) . '"
                                          alt="image"></a>';
                    } else {

                        $html .= ' <a class="new-comment-img replay-comment-img" href=""><img
                                    src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '" alt="image"></a>';

                    }

                } else {

                    $html .= ' <a class="new-comment-img replay-comment-img" href=""><img
                                    src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '" alt="image"></a>';

                }

                $html .= '</div>
                                    <div class="comment-details">
                                        <div class="coment-info">
                                            <div class="coment-authore-div">
                                                <h6><a href="#">' . Auth::user()->name . '</a></h6>
                                                <span
                                                    class="comment-time">' . \Carbon\Carbon::parse($postComment->created_at)->diffForHumans() . '</span>
                                            </div>';


                if ($postComment->user_id === Auth::id()) {
                    $html .= ' <div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn"
                                                            id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                            aria-expanded="false"><i class="fa fa-ellipsis-h"
                                                                                     aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu comment-option-dropdown"
                                                        aria-labelledby="dropdownMenuButton1">
                                                        <li class="post-option-item" id="editComment">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                            Edit Comment
                                                        </li>
                                                        <li class="post-option-item dltComment"
                                                            data-commentId="' . $postComment->id . '">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            Delete comment
                                                        </li>
                                                    </ul>
                                                </div>';
                } else {
                    $html .= ' <div class="comment-option">

                                                    <button type="button" class="dropdown-toggle comment-option-btn"
                                                            id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                            aria-expanded="false"><i class="fa fa-ellipsis-h"
                                                                                     aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu comment-option-dropdown"
                                                        aria-labelledby="dropdownMenuButton1">
                                                        <li class="post-option-item dltComment"
                                                            data-commentId="' . $postComment->id . '">
                                                            <i class="fa fa-trash-o"
                                                               aria-hidden="true"></i>
                                                            Delete comment
                                                        </li>
                                                    </ul>
                                                </div>';
                }

                $html .= '</div>
                                        <div class="comment-div">
                                            <p class="comment-content">' . $postComment->comment_text . '</p>

                                            <button  class="textarea-btn" type="submit">
                                            <i class="fa fa-paper-plane" data-commentText="' . $postComment->comment_text . '" data-cmtId="' . $postComment->id . '" data-postId="' . $postComment->page_post_id . '" aria-hidden="true"></i>
                                            </button>
                                            <button class="textarea-cancel-btn">Cancel</button>
                                        </div>
                                        <ul class="coment-react">
                                            <li class="comment-like"><a href="#">Like(0)</a></li>
                                            <li><a href="javascript:void(0)" class="replay-tag">Replay</a></li>
                                        </ul>
                                    </div>';

                if (empty($postComment->replies)) {

                    $html .= '<div class="more-comment">
                                        <a class="checkCmt" data-postIdd="' . $postComment->page_post_id . '">More+</a>
                                    </div>';
                }

                $html .= '<div class="child-comment">

                <div class="single-replay-comnt nested-comment-' . $postComment->id . '">


                </div>';

                if (empty($postComment->replies)) {
                    $html .= '<div class="more-comment mt-2">
                                                <a class="loadChildCmt" data-postIdd="' . $postComment->page_post_id . '"
                                                   data-commentId="' . $postComment->id . '">
                                                   <span class="replay-arrow">
                                                    <svg x="0" y="0" viewBox="0 0 48 48" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="m47.12 31.403-9.992-9.992a2.98 2.98 0 1 0-4.215 4.216l3.037 3.037C15.565 29.665 2.31 15.984 2.188 1.96c-.004-.507-.716-.61-.874-.144-4.922 14.579 4.03 32.89 27.427 36.201 2.266.295 4.558.519 6.868.681l-2.697 2.697a2.98 2.98 0 1 0 4.215 4.215l9.992-9.992a2.98 2.98 0 0 0 .001-4.215z" data-original="#ffcc66" class=""></path></g></svg>
                                                    </span> Replay <span class="count">(0)</span></a>
                                            </div>';
                }


                $html .= ' <div class="new-comment replay-new-comment">';

                if (!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0]) ? $postComment->users->userProfileImages[0] : '') {
                    if (!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0]) ? $postComment->users->userProfileImages[0] : '') {
                        $html .= '<a href="" class="new-comment-img replay-comment-img"><img src="' . asset("storage/community/profile-picture/" . $postComment->users->userProfileImages[0]->user_profile) . '"
                                                      alt="image"></a>';
                    } else {
                        $html .= '<a  class="new-comment-img replay-comment-img"> <img
                                    src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '" alt="image"> </a>';
                    }

                } else {

                    $html .= '<a  class="new-comment-img replay-comment-img"> <img
                                    src="' . asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg") . '" alt="image"> </a>';

                }
                $html .= ' <div class="new-comment-input replay-commnt-input">
                                                <input data-cmtId="' . $postComment->id . '" class="cmtText" type="text"
                                                       name="cmttext"
                                                       data-userPostId="' . $postComment->page_post_id . '"
                                                       placeholder="Write a comment....">
                                                <div class="attached-icon">
                                                    <a href="#"><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </li>';

                return \response()->json([
                    'status' => true,
                    'data' => $postComment,
                    'msg' => 'Successfully Added.',
                    'html' => $html
                ]);
            }

        }

    }


    public function storePagePostCommentOfComment(Request $request)
    {
        if ($request->ajax()) {
            if ($request->ajax()) {
                $storeComments = CommunityPagePostComment::create([
                    'user_id' => Auth::id(),
                    'page_post_id' => $request->get('page_post_id'),
                    'page_post_comment_id' => $request->get('cmtId'),
                    'comment_text' => $request->get('cmtText'),
                ]);

                $html = '';
                if ($storeComments) {
//
                    $html .= '<div class="single-replay-comnt ' . $storeComments->id . '">
                                                <div class="replay-coment-box comment-details">
                                                    <div class="replay-comment-img">';
//
                    if (!empty($storeComments->users->userProfileImages[0]) && isset($storeComments->users->userProfileImages[0]) ? $storeComments->users->userProfileImages[0]->user_profile : '') {
                        if (!empty($storeComments->users->userProfileImages[0]) && isset($storeComments->users->userProfileImages[0]) ? $storeComments->users->userProfileImages[0]->user_profile : '') {
                            $html .= '<a class="new-comment-img replay-comment-img" href=""><img src="' . asset("storage/community/profile-picture/" . $storeComments->users->userProfileImages[0]->user_profile) . '"
                                                                          alt="image"></a>';
                        } else {
                            $html .= '<a class="new-comment-img replay-comment-img"><img src="' . asset("community-frontend/assets/images/community/home/news-post/comment01.jpg") . '"alt="image"></a>';

                        }

                    } else {
                        $html .= '<a class="new-comment-img replay-comment-img"><img src="' . asset("community-frontend/assets/images/community/home/news-post/comment01.jpg") . '"alt="image"></a>';

                    }

                    $html .= '</div>
                                                    <div class="replay-comment-details comment-details">
                                                        <div class="replay-coment-info coment-info">
                                                            <div>
                                                                <h6><a class="replay-comnt-name" href="#">' . Auth::user()->name . '</a></h6>
                                                                <span class="replay-time-comnt">' . \Carbon\Carbon::parse($storeComments->created_at)->diffForHumans() . '</span>
                                                            </div>';

                    if ($storeComments->user_id === Auth::id()) {
                        $html .= '<div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1" style="">
                                                        <li class="post-option-item" id="editComment"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit comment</li>
                                                        <li class="post-option-item dltComment" data-commentId="' . $storeComments->id . '"><i class="fa fa-trash-o" aria-hidden="true"></i>  Delete comment</li>
                                                    </ul>
                                                </div> ';
                    } else {
                        $html .= '<div class="comment-option">
                                                    <button type="button" class="dropdown-toggle comment-option-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu comment-option-dropdown" aria-labelledby="dropdownMenuButton1" style="">
                                                        <li class="post-option-item dltComment" data-commentId="' . $storeComments->id . '"><i class="fa fa-trash-o" aria-hidden="true"></i>  Delete comment</li>
                                                    </ul>
                                                </div> ';
                    }


                    $html .= ' </div>
                                                        <div class="comment-div">
                                                            <p class="comment-content">' . $storeComments->comment_text . '</p>
                                                            <button class="textarea-btn" type="submit" style="display: none;">
                                                            <i class="fa fa-paper-plane" data-commenttext="check Child" data-cmtId="' . $storeComments->id . '" data-postId="' . $storeComments->page_post_id . '" aria-hidden="true"></i>
                                                            </button>
                                                            <button class="textarea-cancel-btn" style="display: none;">Cancel</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';

                    return \response()->json([
                        'status' => true,
                        'success' => true,
                        'msg' => 'Successfully Added',
                        'data' => $html
                    ]);
                }

            }
        }
    }

}
