<?php

namespace App\Http\Controllers\Community\Frontend\Profile;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserDetails;
use Illuminate\Http\Request;

class CommunityUserDetailsController extends Controller
{

    public function dashboard(){
        $data=array();


    }

    public function index()
    {
        $data=array();
        $data['allUserDetails']=CommunityUserDetails::join('users','users.id','community_user_details.user_id')
            ->where('users.role','!=',ADMIN_ROLE)
            ->selectRaw('users.id as uId,users.name,users.email,community_user_details.*')
            ->get();
        return view('admin.community-page.allUsers',$data);
    }

    public function show(string $id)
    {

        $singleUser=CommunityUserDetails::join('users','users.id','community_user_details.user_id')
            ->where('community_user_details.id','=',$id)
            ->where('community_user_details.user_id','!=',ADMIN_ROLE)
            ->selectRaw('users.name,users.email,users.id as uId,community_user_details.*')
            ->get();
//        return $sigleUser;
        return view('admin.community-page.singleUsersDetails',compact('singleUser'));
    }


}
