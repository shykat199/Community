<?php

namespace App\Http\Controllers\Community\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserBan;
use App\Models\Community\User\CommunityUserDetails;
use App\Models\User;

class UserBanController extends Controller
{
    public function unbanUser($id)
    {
        $unbanUser = CommunityUserBan::where('user_id','=',$id)->update([
            'user_ban' => 0
        ]);

        if ($unbanUser) {
            return to_route('community.user')->with('success', 'User Activated Successfully');
        } else {
            return \Redirect::back()->with('error', 'Something Wrong');
        }

    }

    public function allBanUsers(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {

        $allBanUsers = CommunityUserBan::select('user_id')
            ->where('user_ban', '=', 1)
            ->get();
        $banUsers = [];
        foreach ($allBanUsers as $user) {
            $banUsers[] = $user->user_id;
        };

//        $data['allUserDetails'] = User::with('userProfileImages')->join('community_user_details', 'community_user_details.user_id','=', 'users.id')
//            ->where('users.role', '!=', ADMIN_ROLE)
//            ->selectRaw('users.id,users.name,users.email,community_user_details.*')
//            ->whereIn('users.id', $allBanUsers)
//            ->get();

        $data['allUserDetails'] = User::with('userProfileImages')->join('community_user_details', 'community_user_details.user_id', '=','users.id')
            ->whereIn('users.id', $allBanUsers)
            ->where('users.role', '!=', ADMIN_ROLE)
            ->selectRaw('users.id ,users.name,users.email,community_user_details.dob,community_user_details.phone,community_user_details.gender,
            community_user_details.relationship,community_user_details.blood,community_user_details.website,community_user_details.about_me,community_user_details.phone,
            community_user_details.city,community_user_details.created_at,community_user_details.state,community_user_details.country,community_user_details.fname,community_user_details.occupation,
            community_user_details.lname')
            ->get();

//        return $data['allUserDetails'];

        return view('admin.community-page.allBanUsers', $data);
    }
}
