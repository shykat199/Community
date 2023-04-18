<?php

namespace App\Http\Controllers\Community\Frontend\Profile;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserDetails;
use App\Models\Community\User_Profile\CommunityUserProfileLanguage;
use Illuminate\Support\Facades\Auth;

class UserProfileDetailsController extends Controller
{
    public function index(){

        $userDetails=CommunityUserDetails::where('user_id','=',Auth::id())->first();
        $allUserLanguage=CommunityUserProfileLanguage::where('user_id','=',Auth::id())->get();


        return view('community-frontend.my-profile',compact('userDetails','allUserLanguage'));
    }
}
