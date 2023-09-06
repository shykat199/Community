<?php

namespace App\Http\Controllers\Community\Frontend\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupPostRequest;
use App\Models\Community\Group\CommunityUserGroup;
use App\Models\Community\Group\CommunityUserGroupCoverPhoto;
use App\Models\Community\Group\CommunityUserGroupPost;
use App\Models\Community\Group\CommunityUserGroupPostComment;
use App\Models\Community\Group\CommunityUserGroupPostCommentReaction;
use App\Models\Community\Group\CommunityUserGroupPostFile;
use App\Models\Community\Group\CommunityUserGroupPostReaction;
use App\Models\Community\Group\CommunityUserGroupProfilePhoto;
use App\Models\Community\Page\CommunityPageCoverPhoto;
use App\Models\Community\User\CommunityUserPost;
use App\Models\Community\User\CommunityUserPostFileType;
use App\Models\Community\User\CommunityUserPostTag;
use App\Models\Community\User_Post\CommunityUserPostComment;
use App\Models\Community\User_Post\CommunityUserPostReaction;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Community\Group\CommunityUserGroupPivot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class CommunityUserGroupController extends Controller
{
    public function index()
    {

        $allAvailableGroups = CommunityUserGroup::join('community_user_group_pivots as groupPivot', function ($q) {
            $q->on('groupPivot.group_id', '=', 'community_user_groups.id');

        })
            ->leftJoin('community_user_group_profile_photos as groupProfile', 'groupProfile.group_id', '=', 'community_user_groups.id')
            ->leftJoin('community_user_group_cover_photos as groupCover', 'groupCover.group_id', '=', 'community_user_groups.id')
            ->selectRaw('community_user_groups.id as gId,community_user_groups.group_name as gName,
            community_user_groups.group_details as gDetails,COUNT(groupPivot.id) userCount,groupProfile.group_profile_photo as gProfile,groupCover.cover_photo as gCover,
            community_user_groups.created_at,groupPivot.user_status,groupPivot.group_user_role')
            ->groupBy('community_user_groups.id')
            ->get();

//        return $allAvailableGroups;

        $myGroups = CommunityUserGroup::join('community_user_group_pivots as groupPivot', function ($q) {

            $q->on('groupPivot.group_id', '=', 'community_user_groups.id');
            $q->where('groupPivot.user_id', '=', Auth::id());
            $q->where('groupPivot.group_user_role', '=', 1);
            $q->where('groupPivot.user_status', '=', 1);

        })
            ->leftJoin('community_user_group_profile_photos as groupProfile', 'groupProfile.group_id', '=', 'community_user_groups.id')
            ->leftJoin('community_user_group_cover_photos as groupCover', 'groupCover.group_id', '=', 'community_user_groups.id')
            ->selectRaw('community_user_groups.id as gId,community_user_groups.group_name as gName,
            community_user_groups.group_details as gDetails,COUNT(groupPivot.id) userCount,groupProfile.group_profile_photo as gProfile,
            groupCover.cover_photo as gCover,community_user_groups.created_at,groupPivot.user_status')
            ->groupBy('community_user_groups.id')
            ->get();

//        return $myGroups;

        return view('community-frontend.groupSection', compact('allAvailableGroups', 'myGroups'));
    }


    public function createGroup(Request $request)
    {

        $createGroup = CommunityUserGroup::create([
            'group_name' => $request->get('groupName'),
            'group_details' => $request->get('groupDescription'),
        ]);

        if ($createGroup) {
            $createGroupUser = CommunityUserGroupPivot::create([
                'group_id' => $createGroup->id,
                'user_id' => Auth::id(),
                'group_user_role' => 1,
                'user_status' => 1,
            ]);
        }

        if ($createGroup && $createGroupUser) {
            return \Redirect::back()->with('success', 'Group Created Successfully');
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


    public function getSingleGroupView($id)
    {
        $id=Crypt::decrypt($id);
        $getGroupDetails = CommunityUserGroup::join('community_user_group_pivots as groupUserPivot', function ($q) use ($id) {
            $q->on('groupUserPivot.group_id', '=', 'community_user_groups.id');
            $q->where('groupUserPivot.group_id', '=', $id);
        })
            ->leftjoin('community_user_group_profile_photos as groupProfile', 'groupProfile.group_id', '=', 'community_user_groups.id')
            ->leftjoin('community_user_group_cover_photos as groupCover', 'groupCover.group_id', '=', 'community_user_groups.id')
            ->join('users', function ($q) {
                $q->on('groupUserPivot.user_id', '=', 'users.id');
                $q->where('users.id', '!=', ADMIN_ROLE);
                $q->where('groupUserPivot.user_status', '!=', 0);
            })
            ->selectRaw('community_user_groups.id as gId,
            community_user_groups.group_name,
            community_user_groups.group_details,
            groupProfile.group_profile_photo as groupProfile,
            groupCover.cover_photo,users.name as admin,
            COUNT(groupUserPivot.id) as userCount')
            ->groupBy('community_user_groups.id')
            ->first();


        $groupPosts = CommunityUserGroupPost::with(['users.userProfileImages', 'comments.replies','comments.commentsReaction'])
            ->join('community_user_groups as communityGroups', function ($q) use ($id) {
                $q->on('communityGroups.id', '=', 'community_user_group_posts.group_id');
                $q->where('community_user_group_posts.group_id', '=', $id);
            })
            ->join('users', 'users.id', '=', 'community_user_group_posts.user_id')
            ->leftJoin('community_user_group_post_files as userGroupPostFileType', function ($q) {
                $q->on('userGroupPostFileType.group_post_id', '=', 'community_user_group_posts.id');
            })
            ->leftJoin('community_user_group_post_reactions as postReaction', function ($q) {
                $q->on('postReaction.group_post_id', '=', 'community_user_group_posts.id');
            })
            ->selectRaw('community_user_group_posts.id as gId,communityGroups.group_name as gName,community_user_group_posts.post_description,users.id as user_id,
            users.name as userName,userGroupPostFileType.group_post_caption,userGroupPostFileType.group_post_file,
            community_user_group_posts.created_at,community_user_group_posts.id as grpPostId,postReaction.reaction_type')
            ->orderBy('community_user_group_posts.id', 'DESC')
//            ->groupBy('users.id')
            ->get()->map(function ($q) {
                $q->setRelation('comments', $q->comments->take(2));
                return $q;
            });

        $groupPosts = $groupPosts->each(function ($item) {
            $item->comments->each(function ($comment) {
                $comment->load('users.userProfileImages');
            });
        });

//        return $groupPosts;

        return view('community-frontend.layout.singleGroupView', compact('getGroupDetails', 'groupPosts'));
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


    public function userGroupPostStore(GroupPostRequest $request)
    {
        if ($request->get('postMessage')) {

            if ($request->hasFile('videoFile') || $request->hasFile('photoFile')) {

                $storeGroupPost = CommunityUserGroupPost::create([
                'group_id' => \Crypt::decrypt($request->get('groupId')),
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
                        $file = Storage::put('/public/community/group-post/videos/' . $fileName, file_get_contents($request->file('videoFile')));

                        $GroupPostFile = CommunityUserGroupPostFile::create([
                            'group_post_id' => $storeGroupPost->id,
                            'group_post_file' => $fileName,
                            'group_post_caption' => $request->get('imageCaption'),
                        ]);
//
                    }

                }

                else {

                    $fileName = Uuid::uuid() . '.' . 'image' . '.' . $request->file('photoFile')->getClientOriginalExtension();
                    $file = Storage::put('/public/community/group-post/' . $fileName, file_get_contents($request->file('photoFile')));

                    $GroupPostFile = CommunityUserGroupPostFile::create([
                        'group_post_id' => $storeGroupPost->id,
                        'group_post_file' => $fileName,
                        'group_post_caption' => $request->get('imageCaption'),
                    ]);

                }

            }

            else {

                $storeGroupPost = CommunityUserGroupPost::create([
                'group_id' => \Crypt::decrypt($request->get('groupId')),
                'user_id' => Auth::id(),
                'post_description' => $request->get('postMessage'),
            ]);
            }

        }

        else {

            $fileName = null;
//            dd($request->all());
            if ($request->hasFile('videoFile')  || $request->hasFile('photoFile')  ) {
//                dd($request->all());
                $storeGroupPost = CommunityUserGroupPost::create([
                'group_id' => \Crypt::decrypt($request->get('groupId')),
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
                        $file = Storage::put('/public/community/group-post/videos/' . $fileName, file_get_contents($request->file('videoFile')));

                        $GroupPostFile = CommunityUserGroupPostFile::create([
                            'group_post_id' => $storeGroupPost->id,
                            'group_post_file' => $fileName,
                            'group_post_caption' => $request->get('imageCaption'),
                        ]);
//
                    }
                } else {
                    $fileName = Uuid::uuid() . '.' . 'image' . '.' . $request->file('photoFile')->getClientOriginalExtension();
                    $file = Storage::put('/public/community/group-post/' . $fileName, file_get_contents($request->file('photoFile')));

                    $GroupPostFile = CommunityUserGroupPostFile::create([
                        'group_post_id' => $storeGroupPost->id,
                        'group_post_file' => $fileName,
                        'group_post_caption' => $request->get('imageCaption'),
                    ]);
                }

            }
        }


        if ($storeGroupPost || $GroupPostFile) {
            toastr()->success('Post has been posted successfully!', 'Congrats');
            return Redirect::back();
        }else{
            toastr()->error('An error has occurred please try again later.');
            return Redirect::back();
        }

    }


    public function storeGroupCoverPhoto(Request $request)
    {
//        dd($request->all());

        $fileName = null;
        if ($request->hasFile('grpCover')) {

            $fileName = Uuid::uuid() . '.' . $request->file('grpCover')->getClientOriginalExtension();
            $file = Storage::put('/public/community/group-post/cover/' . $fileName, file_get_contents($request->file('grpCover')));

        }
        $storeCoverPicture = CommunityUserGroupCoverPhoto::updateOrCreate([
            'group_id' => $request->get('grpId'),
        ],
            [
                'cover_photo' => $fileName,
            ]);

        if ($storeCoverPicture) {
            return \redirect()->back()->with('success', 'Cover photo has uploaded');
        } else {
            return \redirect()->back()->with('error', 'Something error');
        }
    }

    public function storeGroupProfilePhoto(Request $request)
    {

//        dd($request->all());
        $fileName = null;
        if ($request->hasFile('grpProfile')) {

            $fileName = Uuid::uuid() . '.' . $request->file('grpProfile')->getClientOriginalExtension();
            $file = Storage::put('/public/community/group-post/profile/' . $fileName, file_get_contents($request->file('grpProfile')));

        }
        $storeProfilePicture = CommunityUserGroupProfilePhoto::updateOrCreate([
            'group_id' => $request->get('grpId'),
        ],
            [
                'group_profile_photo' => $fileName,
            ]);

        if ($storeProfilePicture) {
            return \redirect()->back()->with('success', 'Profile photo has uploaded');
        } else {
            return \redirect()->back()->with('error', 'Something error');
        }
    }


    public function storeGroupPostCommentOfComment(Request $request)
    {

        if ($request->ajax()) {
            $storeComments = CommunityUserGroupPostComment::create([
                'user_id' => Auth::id(),
                'group_post_id' => $request->get('group_post_id'),
                'group_post_comment_id' => $request->get('cmtId'),
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
                        $html .= '<a class="new-comment-img replay-comment-img" href="">
                            <img src="' . asset("storage/community/profile-picture/" . $storeComments->users->userProfileImages[0]->user_profile) . '"
                                                                          alt="image">
                                                                          </a>';
                    }else {
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
                                                            <p class="comment-content">'.$storeComments->comment_text.'</p>
                                                            <button class="textarea-btn" type="submit" style="display: none;">
                                                            <i class="fa fa-paper-plane" data-commenttext="check Child" data-cmtid="9" data-postid="7" aria-hidden="true"></i>
                                                            </button>
                                                            <button class="textarea-cancel-btn" style="display: none;">Cancel</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';

            }

            return \response()->json([
                'status' => true,
                'msg' => 'Successfully Added',
                'data' => $html,
                'storeComments'=>$storeComments,
            ]);

        }

    }


    public function storeGroupPostComment(Request $request)
    {
        if ($request->ajax()) {

            $postComment = CommunityUserGroupPostComment::create([
                'user_id' => Auth::id(),
                'group_post_id' => $request->get('postId'),
//                'group_post_comment_id'=>0,
                'comment_text' => $request->get('postComment')
            ]);

            $html = '';
            if ($postComment) {

                $html .= '
                        <li class="single-comment">
                            <div class="parent-comment">
                                    <div class="comment-img">';
                if (!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0]) ? $postComment->users->userProfileImages[0] : '') {
                    if (!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0]) ? $postComment->users->userProfileImages[0] : '') {
                        $html .= '<a  class="new-comment-img replay-comment-img" href="">
                                    <img  src="' . asset("storage/community/profile-picture/" . $postComment->users->userProfileImages[0]->user_profile) . '"
                                          alt="image">
                                          </a>';
                    }else{
                        $html .='<a class="new-comment-img replay-comment-img"> <img
                                    src="'.asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg").'"
                                    alt="image"></a>';
                    }

                }else{
                    $html .=' <a class="new-comment-img replay-comment-img"><img
                                    src="'.asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg").'"
                                    alt="image"></a>';
                }

                $html .= '</div>
                                    <div class="comment-details">
                                        <div class="coment-info">
                                            <div class="coment-authore-div">
                                                <h6><a href="#">' . $postComment->users->name . '</a></h6>
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
                                            <i class="fa fa-paper-plane" data-commentText="' . $postComment->comment_text . '" data-cmtId="' . $postComment->id . '" data-postId="' . $postComment->group_post_id . '" aria-hidden="true"></i>
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
                                        <a class="checkCmt" data-postIdd="' . $postComment->id . '">More+</a>
                                    </div>';
                }

                $html .= '<div class="child-comment">

                <div class="single-replay-comnt nested-comment-' . $postComment->id . '">


                </div>';

                if (empty($postComment->replies)) {
                    $html .= '<div class="more-comment mt-2">
                                                <a class="loadChildCmt" data-postIdd="' . $postComment->group_post_id . '"
                                                   data-commentId="' . $postComment->id . '">
                                                   <span class="replay-arrow">
                                                    <svg x="0" y="0" viewBox="0 0 48 48" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="m47.12 31.403-9.992-9.992a2.98 2.98 0 1 0-4.215 4.216l3.037 3.037C15.565 29.665 2.31 15.984 2.188 1.96c-.004-.507-.716-.61-.874-.144-4.922 14.579 4.03 32.89 27.427 36.201 2.266.295 4.558.519 6.868.681l-2.697 2.697a2.98 2.98 0 1 0 4.215 4.215l9.992-9.992a2.98 2.98 0 0 0 .001-4.215z" data-original="#ffcc66" class=""></path></g></svg>
                                                    </span> Replay <span class="count">(0)</span></a>
                                            </div>';
                }


                $html .= ' <div class="new-comment replay-new-comment">';

                if (!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0]) ? $postComment->users->userProfileImages[0] : '') {
                    if (!empty($postComment->users->userProfileImages[0]) && isset($postComment->users->userProfileImages[0]) ? $postComment->users->userProfileImages[0] : '') {
                        $html .= '<a class="new-comment-img replay-comment-img" href=""><img src="' . asset("storage/community/profile-picture/" . $postComment->users->userProfileImages[0]->user_profile) . '"
                                                      alt="image"></a>';
                    }else{
                        $html .='<a class="new-comment-img replay-comment-img"> <img
                                    src="'.asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg").'"
                                    alt="image"></a>';
                    }

                }else{
                    $html .='<a class="new-comment-img replay-comment-img"> <img
                                    src="'.asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg").'"
                                    alt="image"></a>';
                }
                $html .= ' <div class="new-comment-input replay-commnt-input">
                                                <input data-cmtId="' . $postComment->id . '" class="cmtText" type="text"
                                                       name="cmttext"
                                                       data-userPostId="' . $postComment->group_post_id . '"
                                                       placeholder="Write a comment....">
                                                <div class="attached-icon">
                                                    <a href="#"><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </li>';
            }
        }

        return \response()->json([
            'status' => true,
            'success' => true,
            'msg' => 'Successfully Added',
            'data' => $html
        ]);
    }

    public function storeUserGroupPostReaction(Request $request)
    {


        if ($request->ajax()) {
            $userId = Auth::id();
            $getReaction = $request->get('getReaction');
            $grpPostId = $request->get('grpPostId');

            if ($userId !== null && $getReaction !== null && $grpPostId !== null) {

                $storePostReaction = CommunityUserGroupPostReaction::create([
                    'user_id' => $userId,
                    'group_post_id' => $grpPostId,
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

    public function storeCommentReaction(Request $request){

        if ($request->ajax()){
            $storeGroupCommentReaction=CommunityUserGroupPostCommentReaction::create([
                'user_id'=>Auth::id(),
                'group_post_comment_id'=>$request->get('postCommentId'),
                'reaction_type'=>1
            ]);

            if ($storeGroupCommentReaction){
                return \response()->json([
                    'msg'=>'Success',
                    'status'=>true,
                    'data'=>$storeGroupCommentReaction
                ]);
            }
        }

    }

    public function removeCommentReaction(Request $request){
        if ($request->ajax()){
            $dltCommentReaction=CommunityUserGroupPostCommentReaction::where('id','=',$request->get('postCommentReactionId'))->delete();

            if ($dltCommentReaction){
                return \response()->json([
                    'msg'=>'Success',
                    'status'=>true,
                    'data'=>$dltCommentReaction
                ]);
            }
        }
    }

    public function editPost(Request $request)
    {

        if ($request->get('imageCaption') === null && $request->hasFile('postFile1') === null) {
//            dd(1);
            $userPost = CommunityUserGroupPost::find($request->get('postId'))->update([
//                'user_id' => Auth::id(),
                'post_description' => $request->get('postMessage')
            ]);

        } else {
//            dd(2);
            $fileName = null;
            if ($request->hasFile('postFile1') !== null || $request->get('imageCaption') !== null) {
//                dd(2);
                $userPost = CommunityUserGroupPost::find($request->get('postId'))->update([
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
//                        dd(6);
                        $fileName = Uuid::uuid() . '.' . $request->file('postFile1')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/post/videos/' . $fileName, file_get_contents($request->file('postFile1')));
                    } else {
                        $fileName = Uuid::uuid() . '.' . $request->file('postFile1')->getClientOriginalExtension();
                        $file = Storage::put('/public/community/post/' . $fileName, file_get_contents($request->file('postFile1')));
                    }

                }
//                dd($request->get('postId'));
                $postImageCaption = CommunityUserGroupPostFile::where('group_post_id', $request->get('postId'))->update([
                    'group_post_file' => $fileName,
                    'group_post_caption' => $request->get('imageCaption'),
                ]);
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


    public function destroyPost($id)
    {
//        dd(1);
        $postImage = CommunityUserGroupPostFile::where('group_post_id', '=', $id)->first();
//        $postImage = $postImage->post_image_video;
//        dd($postImage);
        if ($postImage) {
            $postImage = $postImage->post_image_video;
//            dd($postImage);
            $mediaExtension = explode('.', $postImage);
            if ($mediaExtension[1] == 'mp4' || $mediaExtension[1] == 'mov' || $mediaExtension[1] == 'wmv' ||
                $mediaExtension[1] == 'avi' || $mediaExtension[1] == 'mkv' || $mediaExtension[1] == 'webm'
            ) {
//                @dd(1);
                $dltVideo = Storage::delete('public/community/group-post/videos/' . $postImage);
                $dltPostComment = CommunityUserGroupPostComment::where('group_post_id', '=', $id)->delete();
//                $dltPostCommentReaction = CommunityUserGroupPostCommentReaction::where('group_post_id', '=', $id)->delete();
                $dltPostReaction = CommunityUserGroupPostReaction::where('group_post_id', '=', $id)->delete();
                $dltPost = CommunityUserGroupPost::find($id)->delete();

            } else {
                $dltImag = Storage::delete('public/community/group-post/' . $postImage);
                $dltPostComment = CommunityUserGroupPostComment::where('group_post_id', '=', $id)->delete();
//                $dltPostCommentReaction = CommunityUserGroupPostCommentReaction::where('group_post_id', '=', $id)->delete();
                $dltPostReaction = CommunityUserGroupPostReaction::where('group_post_id', '=', $id)->delete();
                $dltPost = CommunityUserGroupPost::find($id)->delete();

            }
        } else {
            $dltPostComment = CommunityUserGroupPostComment::where('group_post_id', '=', $id)->delete();
//          dltPostCommentReaction = CommunityUserGroupPostCommentReaction::where('group_post_id', '=', $id)->delete();
            $dltPostReaction = CommunityUserGroupPostReaction::where('group_post_id', '=', $id)->delete();
            $dltPost = CommunityUserGroupPost::find($id)->delete();
//            dd($dltPost);
        }

        if ($dltPost) {
            return Redirect::back()->with('success', 'Post Deleted Successfully');
        } else {
            return Redirect::back()->with('error', 'Something Wrong');

        }

    }


}
