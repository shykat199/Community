<?php

namespace App\Http\Controllers\Community\Frontend\Profile;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserBan;
use App\Models\Community\User\CommunityUserDetails;
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

        $data['allUserDetails'] = CommunityUserDetails::join('users', 'users.id', 'community_user_details.user_id')
            ->where('users.role', '!=', ADMIN_ROLE)
            ->selectRaw('users.id as uId,users.name,users.email,community_user_details.*')
            ->whereNotIn('users.id', $banUsers)
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

        $singleUser = CommunityUserDetails::join('users', 'users.id', 'community_user_details.user_id')
            ->where('community_user_details.id', '=', $id)
            ->where('community_user_details.user_id', '!=', ADMIN_ROLE)
            ->selectRaw('users.name,users.email,users.id as uId,community_user_details.*')
            ->get();
//        return $sigleUser;
        return view('admin.community-page.singleUsersDetails', compact('singleUser'));
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
