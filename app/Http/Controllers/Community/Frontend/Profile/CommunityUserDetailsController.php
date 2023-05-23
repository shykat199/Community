<?php

namespace App\Http\Controllers\Community\Frontend\Profile;

use App\Http\Controllers\Controller;
use App\Models\Community\Group\CommunityUserGroup;
use App\Models\Community\Page\CommunityPagePostComment;
use App\Models\Community\User\CommunityUserBan;
use App\Models\Community\User\CommunityUserDetails;
use App\Models\Community\User\CommunityUserPost;
use App\Models\Community\User_Post\CommunityUserPostComment;
use App\Models\User;
use Illuminate\Http\Request;

class CommunityUserDetailsController extends Controller
{

    public function dashboard()
    {
        $data = array();

    }

    public function index()
    {
        $data = array();

        $allBanUsers = CommunityUserBan::select('user_id')
            ->where('user_ban', '=', 1)
            ->get();
        $banUsers = [];
        foreach ($allBanUsers as $user) {
            $banUsers[] = $user->user_id;
        };

//        dd($banUsers);

//        $data['allUserDetails'] = CommunityUserDetails::join('users', 'users.id', 'community_user_details.user_id')
//            ->where('users.role', '!=', ADMIN_ROLE)
//            ->selectRaw('users.id as uId,users.name,users.email,community_user_details.*')
//            ->whereNotIn('users.id', $banUsers)
//            ->get();
        $data['allUserDetails'] = User::with('userProfileImages')->join('community_user_details', 'community_user_details.user_id', '=','users.id')
            ->whereNotIn('users.id', $banUsers)
            ->where('users.role', '!=', ADMIN_ROLE)
            ->selectRaw('users.id ,users.name,users.email,community_user_details.dob,community_user_details.phone,community_user_details.gender,
            community_user_details.relationship,community_user_details.blood,community_user_details.website,community_user_details.about_me,community_user_details.phone,
            community_user_details.city,community_user_details.created_at,community_user_details.state,community_user_details.country,community_user_details.fname,community_user_details.occupation,
            community_user_details.lname')
            ->get();

//        return $data['allUserDetails'];
        return view('admin.community-page.allUsers', $data);
    }

    public function allUsers(){
        $allUsers=User::where('id','!=',ADMIN_ROLE)->get();

        return view('admin.community-page.allUsersWithOutDetails',compact('allUsers'));
    }

    public function show(string $id)
    {
//        dd($id);

        $singleUser = CommunityUserDetails::join('users', 'users.id', 'community_user_details.user_id')
            ->where('community_user_details.user_id', '=', $id)
            ->where('community_user_details.user_id', '!=', ADMIN_ROLE)
            ->selectRaw('users.name,users.email,users.id as uId,community_user_details.*')
            ->get();
//        return $singleUser;
        return view('admin.community-page.singleUsersDetails', compact('singleUser'));
    }

    public function allUserPost(string $id)
    {
//        dd($id);

        $userPost=User::join('community_user_posts','community_user_posts.user_id','=','users.id')
            ->where('community_user_posts.user_id','=',$id)
            ->selectRaw('community_user_posts.id as uPostId,community_user_posts.post_description,community_user_posts.created_at,
            users.id as uId,users.name
            ')
            ->latest()->get();
//        return $singleUser;
        return view('admin.community-page.singleUserPost', compact('userPost'));
    }

    public function userPostComment($id){

//        $allPostComments=CommunityUserPostComment::with(['users.userProfileImages', 'replies'])->where('user_post_id','=',$id)
//            ->join('users','users.id','=','community_user_post_comments.user_id')
//            ->where('user_post_comment_id','=',0)
//            ->selectRaw('users.id as user_id,users.name as userName,
//            community_user_post_comments.id as commentId,community_user_post_comments.comment_text,
//            community_user_post_comments.created_at,community_user_post_comments.user_post_id as userPostId,
//            community_user_post_comments.user_post_comment_id')
//            ->get();

        $postComments = CommunityUserPostComment::with(['userPosts.users.userProfileImages', 'replies.users'])
            ->where('user_post_id', '=', $id)
            ->where('user_post_comment_id', '=', 0)
            ->get();

        return view('admin.community-page.commentOfPostUser',compact('postComments'));

    }



    public function userBan($id)
    {
//        dd($id);
        $userBan = CommunityUserBan::create([
            'user_id' => $id,
            'user_ban' => 1,
        ]);

        if ($userBan) {
            return redirect()->back()->with('success', 'User Ban Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Wrong');
        }

    }
    public function userDlt($id){

//        $dltUser=User::find($id)->delete();
//        if ($dltUser){
//            return redirect()->back()->with('success','Deleted Successfully')
//        }

    }

    public function allBanUsers()
    {
//        dd(1);

        $allBanUsers = CommunityUserBan::select('user_id')
            ->where('user_ban', '=', 1)
            ->get();
        $banUsers = [];
        foreach ($allBanUsers as $user) {
            $banUsers[] = $user->user_id;
        };

        $data['allUserDetails'] = CommunityUserDetails::join('users', 'users.id', 'community_user_details.user_id')
            ->where('users.role', '!=', ADMIN_ROLE)
            ->selectRaw('users.id as uId,users.name,users.email,community_user_details.*')
            ->whereIn('users.id',$allBanUsers)
            ->get();

//        return $data['allUserDetails'];

        return view('admin.community-page.allBanUsers', $data);

    }

}
