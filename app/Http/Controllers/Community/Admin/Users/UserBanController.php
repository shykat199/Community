<?php

namespace App\Http\Controllers\Community\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserBan;
use App\Models\Community\User\CommunityUserDetails;

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

        $data['allUserDetails'] = CommunityUserDetails::join('users', 'users.id', 'community_user_details.user_id')
            ->where('users.role', '!=', ADMIN_ROLE)
            ->selectRaw('users.id as uId,users.name,users.email,community_user_details.*')
            ->whereIn('users.id', $allBanUsers)
            ->get();

//        return $data['allUserDetails'];

        return view('admin.community-page.allBanUsers', $data);
    }
}
