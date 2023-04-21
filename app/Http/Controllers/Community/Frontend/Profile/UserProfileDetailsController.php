<?php

namespace App\Http\Controllers\Community\Frontend\Profile;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserDetails;
use App\Models\Community\User\CommunityUserPostFileType;
use App\Models\Community\User_Profile\CommunityUserProfileCover;
use App\Models\Community\User_Profile\CommunityUserProfileLanguage;


use App\Models\Community\User_Profile\CommunityUserProfilePhoto;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileDetailsController extends Controller
{
    public function index()
    {

        $userDetails = CommunityUserDetails::leftJoin('users', 'users.id', 'community_user_details.user_id')
            ->leftJoin('community_user_profile_photos as userProfilePhoto', 'userProfilePhoto.user_id', 'users.id')
            ->leftJoin('community_user_profile_covers as userCoverPhoto', 'userCoverPhoto.user_id', 'users.id')
            ->where('users.id', '=', Auth::id())
            ->selectRaw('community_user_details.*,users.id as Uid,users.name,userProfilePhoto.user_profile as profilePicture,userCoverPhoto.user_cover as coverPicture')
            ->first();

        $allUserLanguage = CommunityUserProfileLanguage::where('user_id', '=', Auth::id())->get();

        $countPhoto = CommunityUserPostFileType::join('community_user_posts as userPost', function ($q) {
            $q->on('community_user_post_file_types.post_id', '=', 'userPost.id');
        })
            ->join('users', function ($q) {
                $q->on('users.id', '=', 'userPost.user_id');
                $q->where('users.id', '=', Auth::id());
            })
            ->groupBy("users.id")
            ->count();
//        return $countPhoto;
        return view('community-frontend.my-profile', compact('userDetails', 'allUserLanguage', 'countPhoto'));
    }

    public function uploadProfilePhoto(Request $request)
    {
//        dd($request->all());

        $name = null;
        if ($request->hasFile('userProfilePhoto')) {
            $name = Uuid::uuid() . '.' . $request->file('userProfilePhoto')->getClientOriginalExtension();
            $file = Storage::put('/public/community/profile-picture/' . $name, file_get_contents($request->file('userProfilePhoto')));
        }
        $uploadProfilePhoto = CommunityUserProfilePhoto::create([
            'user_id' => Auth::id(),
            'user_profile' => $name,
        ]);

        if ($uploadProfilePhoto) {
            return to_route('user.my-profile')->with('success', 'Profile Photo Upload Successfully');
        } else {
            return redirect()->back();
        }
    }

    public function uploadCoverPhoto(Request $request)
    {
//        dd($request->all());

        $name = null;
        if ($request->hasFile('userCoverPhoto')) {
            $name = Uuid::uuid() . '.' . $request->file('userCoverPhoto')->getClientOriginalExtension();
            $file = Storage::put('/public/community/cover-picture/' . $name, file_get_contents($request->file('userCoverPhoto')));
        }
        $uploadCoverPhoto = CommunityUserProfileCover::create([
            'user_id' => Auth::id(),
            'user_cover' => $name,
        ]);

        if ($uploadCoverPhoto) {
            return to_route('user.my-profile')->with('success', 'Cover Photo Upload Successfully');
        } else {
            return redirect()->back();
        }
    }
}
