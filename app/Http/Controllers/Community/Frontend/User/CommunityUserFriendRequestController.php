<?php

namespace App\Http\Controllers\Community\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserFriend;
use App\Models\Community\User\CommunityUserFriendRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityUserFriendRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function acceptRequest(Request $request)
    {
        if (\request()->ajax()) {
            $userFriend = false;
            $userId = $request->get('userId');
            $userName = $request->get('userName');
            $tldId = $request->get('tldId');
//            dd($request->all());
//            dd($userId,$userName);
            $updateStatus = CommunityUserFriendRequest::where('id', $tldId)->update([
                'status' => 1
            ]);

            if ($updateStatus) {
                $data = array(
                    array('user_id' => Auth::id(), 'requested_user_id' => $userId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
                    array('user_id' => $userId, 'requested_user_id' => Auth::id(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
                );
                $userFriend = CommunityUserFriend::insert($data);

            }

            if ($userFriend) {
                return \response()->json([
                    'status' => true,
                    'msg' => 'Successfully Added',
                ]);
            }
        }
    }

    public function allFriendRequest()
    {

        $userIdArray = [];
        $userIdArray[] = Auth::id();
        $userIdArray[] = ADMIN_ROLE;


//        foreach (myFriends() as $friend) {
//
//            $userIdArray[] = $friend->id;
//        }


        $allUsers = User::with(['userProfileImages', 'userCoverImages'])->whereNotIn('users.id',$userIdArray)
            ->leftJoin('community_user_profile_photos as profilePhoto', function ($q) use ($userIdArray) {
                $q->on('profilePhoto.user_id', '=', 'users.id');
                $q->where('users.id', '!=', ADMIN_ROLE);
                $q->where('users.id', '!=', Auth::id());

            })
            ->leftJoin('community_user_profile_covers as profileCover', function ($q) use ($userIdArray) {
                $q->on('profileCover.user_id', '=', 'users.id');
                $q->where('users.id', '!=', ADMIN_ROLE);
                $q->where('users.id', '!=', Auth::id());

            })
            ->leftJoin('community_user_followings as userFollowings', function ($q) use ($userIdArray) {
                $q->on('userFollowings.user_id', '=', 'users.id');
                $q->where('users.id', '!=', ADMIN_ROLE);
                $q->where('users.id', '!=', Auth::id());

            })
            ->leftJoin('community_user_followings as usersFollowers', function ($q) use ($userIdArray) {
                $q->on('userFollowings.user_following_id', '=', 'users.id');
                $q->where('users.id', '!=', Auth::id());
                $q->where('users.id', '!=', ADMIN_ROLE);

            })
            ->leftJoin('community_user_friends as f1', 'f1.user_id', '=', 'users.id')
            ->leftJoin('community_user_friends as f2', function ($q) {
                $q->on('f1.requested_user_id', '=', 'f2.requested_user_id');
                $q->where('f1.user_id', '=', Auth::id());
                $q->where('f2.user_id', '=', 'users.id');
            })
            ->leftJoin('community_user_friend_requests as friendReq', 'friendReq.sender_user_id', '=', 'users.id')
            ->leftJoin('community_user_friend_requests as friendReq1', 'friendReq1.receiver_user_id', '=', 'users.id')
            ->leftJoin('community_user_followings as following','following.user_id','=','users.id')
            ->selectRaw('users.id, users.name,profilePhoto.user_profile,profileCover.user_cover,
            COUNT(userFollowings.id) as followings,COUNT(usersFollowers.id) as followers,COUNT(f1.id) as countMutualFriend,friendReq.sender_user_id as requestedId,
           friendReq1.receiver_user_id as senderId, friendReq.id as reqId,following.user_id as followedId,following.id as userFollowingId')
            ->groupBy('users.id')
            ->orderBy('users.name', 'ASC')
            ->get();

//        return $allUsers;


        return view('community-frontend.friendSection', compact('allUsers'));
    }

    public function addFriendRequest(Request $request): \Illuminate\Http\JsonResponse
    {

        if ($request->ajax()) {
            $storeFriendRequest = CommunityUserFriendRequest::create([
                'sender_user_id' => $request->get('userId'),
                'status' => 0,
                'receiver_user_id' => Auth::id()
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => true,
            'msg' => "Friend request send",
        ]);

    }

    public function cancelFriendRequest(Request $request): \Illuminate\Http\JsonResponse
    {

        if ($request->ajax()) {
            $deleteFriendRequest = CommunityUserFriendRequest::where('id','=',$request->get('reqId'))->delete();
        }

        return response()->json([
            'success' => true,
            'status' => true,
            'msg' => "Friend request canceled",
        ]);

    }

    public function searchFriends(Request $request): \Illuminate\Http\JsonResponse
    {

        $users = User::all();
        if ($request->get('search') !== '') {


            $userIds = User::with('userProfileImages')
                ->where('users.id', '!=', ADMIN_ROLE)
                ->where('users.id', '!=', USER_ROLE)
                ->where('users.name', 'LIKE', "%{$request->get('search')}%")->pluck('id');
//            dd($userIds);

//            foreach ($userIds as $uId) {

                $users = User::with('userProfileImages')
                    ->join('community_user_friend_requests', 'community_user_friend_requests.sender_user_id', '=', 'users.id')
                    ->whereIn('community_user_friend_requests.sender_user_id',$userIds)
                    ->join('community_user_friend_requests as countRequest', 'countRequest.sender_user_id', '=', 'users.id')
                    ->whereIn('countRequest.sender_user_id',$userIds)
                    ->where('community_user_friend_requests.status', '=', 0)
                    ->where('community_user_friend_requests.receiver_user_id', '=', Auth::id())
                    ->leftJoin('community_user_friends as f1', 'f1.user_id', '=', 'users.id')
                    ->whereIn('f1.user_id',$userIds)
                    ->leftJoin('community_user_friends as f2', function ($q) use ($userIds) {
                        $q->on('f1.requested_user_id', '=', 'f2.requested_user_id');
                        $q->where('f1.user_id', '=', Auth::id());
                        $q->where('f2.user_id', '=', 'users.id');
                        $q->whereIn('f2.user_id',$userIds);
                    })
                    ->leftJoin('community_user_followings as userFollowings', function ($q) use($userIds) {
                        $q->on('userFollowings.user_id', '=', 'community_user_friend_requests.sender_user_id');
                        $q->whereIn('userFollowings.user_id',$userIds);
                    })
                    ->leftJoin('community_user_followings as usersFollowers', function ($q) use($userIds) {
                        $q->on('userFollowings.user_following_id', '=', 'community_user_friend_requests.sender_user_id');
                        $q->whereIn('usersFollowers.user_following_id',$userIds);
                    })
                    ->leftJoin('community_user_profile_photos as profilePhoto', function ($q) use($userIds) {
                        $q->on('profilePhoto.user_id', '=', 'community_user_friend_requests.sender_user_id');
                        $q->whereIn('usersFollowers.user_id',$userIds);
                        $q->where('users.id', '!=', ADMIN_ROLE);
                    })
                    ->leftJoin('community_user_profile_covers as profileCover', function ($q) use($userIds) {
                        $q->on('profileCover.user_id', '=', 'community_user_friend_requests.sender_user_id');
                        $q->whereIn('profileCover.user_id',$userIds);
                        $q->where('users.id', '!=', ADMIN_ROLE);
                    })
                    ->selectRaw('users.id,users.name as userName,community_user_friend_requests.id as reqId,COUNT(f1.id) as countMutualFriend,COUNT(userFollowings.id) as followings,COUNT(usersFollowers.id) as followers,
        profilePhoto.user_profile,profileCover.user_cover')
                    ->groupBy('users.id')
                    ->get();

//            }

//            $users = User::join('community_user_friend_requests', 'community_user_friend_requests.sender_user_id', '=', 'users.id')
//                ->join('community_user_friend_requests as countRequest', 'countRequest.sender_user_id', '=', 'users.id')
//                ->where('community_user_friend_requests.status', '=', 0)
//                ->where('community_user_friend_requests.receiver_user_id', '=', Auth::id())
//                ->leftJoin('community_user_friends as f1', 'f1.user_id', '=', 'users.id')
//                ->leftJoin('community_user_friends as f2', function ($q) {
//                    $q->on('f1.requested_user_id', '=', 'f2.requested_user_id');
//                    $q->where('f1.user_id', '=', Auth::id());
//                    $q->where('f2.user_id', '=', 'users.id');
//                })
//                ->leftJoin('community_user_followings as userFollowings', function ($q) {
//                    $q->on('userFollowings.user_id', '=', 'community_user_friend_requests.sender_user_id');
//                })
//                ->leftJoin('community_user_followings as usersFollowers', function ($q) {
//                    $q->on('userFollowings.user_following_id', '=', 'community_user_friend_requests.sender_user_id');
//                })
//                ->leftJoin('community_user_profile_photos as profilePhoto', function ($q) {
//                    $q->on('profilePhoto.user_id', '=', 'community_user_friend_requests.sender_user_id');
//                    $q->where('users.id', '!=', ADMIN_ROLE);
//                })
//                ->leftJoin('community_user_profile_covers as profileCover', function ($q) {
//                    $q->on('profileCover.user_id', '=', 'community_user_friend_requests.sender_user_id');
//                    $q->where('users.id', '!=', ADMIN_ROLE);
//                })
//                ->selectRaw('users.id,users.name as userName,community_user_friend_requests.id as reqId,COUNT(f1.id) as countMutualFriend,COUNT(userFollowings.id) as followings,COUNT(usersFollowers.id) as followers,
//        profilePhoto.user_profile,profileCover.user_cover')
//                ->where('users.name', 'LIKE', '%' . $request->get('search') . '%')
//                ->orWhere('users.id','LIKE', '%' . $request->get('search') . '%')
//                ->groupBy('users.id')
//                ->get();


        }

        dd($users);
        $html = '';
        if (count($users) > 0) {

            foreach ($users as $user) {


                $html .= '<div class="col-lg-3 col-md-6 col-12">
                                    <div class="single-profile-list">
                                        <div class="view-profile left-widget">
                                            <div class="profile-cover">';


                if (!empty($user->userCoverImages[0]) && isset($user->userCoverImages[0]) ? $user->userCoverImages [0] : '') {
                    if (!empty($user->userCoverImages[0]) && isset($user->userCoverImages[0]) ? $user->userCoverImages [0] : '') {

                        $html .= '<a href=""><img
                                                                src="' . asset("storage/community/profile-picture/" . $user->userCoverImages[0]->user_cover) . '"
                                                                alt="image"></a>';

                    } else {

                        $html .= '<a href=""><img
                                                                src="' . asset("community-frontend/assets/images/community/home/smallCover.jpg") . '"
                                                                alt="image"></a>';
                    }


                } else {
                    $html .= '<a href=""><img
                                                                src="' . asset("community-frontend/assets/images/community/home/smallCover.jpg") . '"
                                                                alt="image"></a>';

                }

                $html .= '<div class="add-friend-icon" >
                                                    <a href = "#" ><i class="fa fa-user-o" aria - hidden = "true" ></i ></a >
                                                </div >
                                            </div >
                                            <div class="profile-title d-flex align-items-center" >';

                if (!empty($user->userCoverImages[0]) && isset($user->userCoverImages[0]) ? $user->userCoverImages [0] : '') {
                    if (!empty($user->userCoverImages[0]) && isset($user->userCoverImages[0]) ? $user->userCoverImages [0] : '') {

                        $html .= '<a href=""><img
                                                                src="' . asset("storage/community/profile-picture/" . $user->userProfileImages[0]->user_profile) . '"
                                                                alt="image"></a>';

                    } else {

                        $html .= '<a href=""><img
                                                                src="' . asset("storage/community/profile-picture/ " . $user->userProfileImages[0]->user_profile) . '"
                                                                alt="image"></a>';
                    }


                } else {
                    $html .= '<a href=""><img
                                                                src="' . asset("storage/community/profile-picture/" . $user->userProfileImages[0]->user_profile) . '"
                                                                alt="image"></a>';

                }

                $html .= '<div class="profile-name" >
                                                    <h6 ><a href = "#" >' . $user->name . '</a ></h6 >
                                                    <span class="mutual-friend" >' . $user->countMutualFriend . 'Mutual Friends </span >
                                                </div >
                                            </div >
                                            <ul class="profile-statistics" >
                                                <li ><a href = "#" >
                                                        <p class="statics-count" > 0</p >
                                                        <p class="statics-name" > Likes</p >
                                                    </a ></li >
                                                <li ><a href = "#" >
                                                        <p class="statics-count" >' . $user->followings . '</p >
                                                        <p class="statics-name" > Following</p >
                                                    </a ></li >
                                            </ul >
                                            <ul class="add-msg-btn" >
                                                <li ><button type = "button" class="add-btn sendRequest" data-userId = "{{$user->id}}">' . !empty($user->requestedId) && isset($user->requestedId) ? 'Cancel Request' : "Add Friend" . '</button ></li >
                                                <li ><button type = "button" class="msg-btn" > Send Message </button ></li >
                                            </ul >
                                        </div >
                                    </div >
                                </div > ';
            }
        } else {
            $html .= '<div class="load-more mb-30">
            <a href="#">
                No Data Available
            </a>
        </div>';
        }

        return response()->json([
            'msg' => 'success',
            'status' => true,
            'employees' => $users,
            'html' => $html
        ]);
    }


}
