<?php

namespace App\Http\Controllers\Community\Frontend\Profile;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserDetails;
use App\Models\Community\User_Profile\CommunityUserProfileLanguage;
use App\Models\SightSetting;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function MongoDB\BSON\toRelaxedExtendedJSON;

class UserProfileSettingController extends Controller
{
    public function index()
    {
        $data['userInfo'] = CommunityUserDetails::all()->toArray();
        $data['userLanguage'] = User::with('languages')
            ->where('id', '=', Auth::id())
            ->first();
//        dd($data);
        return view('community-frontend.setting', $data);
    }

    public function storePersonalInformation(Request $request)
    {



//        $data = $request->except(['_method', '_token']);
////        dd($data);
//
//        foreach ($data as $key=> $value) {
////            dd($value);
//
//            $communityUserDetails = CommunityUserDetails::updateOrCreate([
//                'key' => $key,
//            ], [
//                'value' => $value,
//            ]);
        $communityUserDetails = CommunityUserDetails::create([
            'user_id' => Auth::id(),
            'dob' => date('Y-m-d', strtotime($request->get('dob'))),
            'occupation' => $request->get('occupation'),
            'birthplace' => $request->get('address'),
            'phone' => $request->get('pnumber'),
            'gender' => $request->get('gender'),
            'relationship' => $request->get('relation'),
            'blood' => $request->get('bloodGroup'),
            'website' => $request->get('website'),
            'about_me' => $request->get('about_me'),
            'city' => $request->get('city'),
            'state' => $request->get('state'),
            'country' => $request->get('country'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'email' => $request->get('email'),
        ]);


        if ($communityUserDetails && $request->get('language')) {
            $input['language'] = $request->input('language');
            if (is_array($input['language'])) {
                foreach ($input['language'] as $value) {
                    $user = User::find(Auth::id());
                    $userLanguage = new CommunityUserProfileLanguage;
                    $userLanguage->language_name = $value;
                    $user->languages()->save($userLanguage);
                }
            }

        }

        return to_route('user.my-profile.setting')->with('success', 'Information stored successfully');

    }

    public function storeAccountInformation(Request $request)
    {

    }

    public function updatePassword(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|max:10|min:8',
        ],[
            'current_password.required'=>'Current Password Is Required',
            'new_password.required'=>'New Password Is Required',
            'new_password.max'=>'Max Length Of Password Is 10',
            'new_password.min'=>'Max Length Of Password Is 8',
       ]);

        // Match The Old Password
        if(!Hash::check($request->get('current_password'), auth()->user()->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }

        #Update the new Password
        $changePassword= User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->get('new_password'))
        ]);
       if ($changePassword){
           return redirect()->back()->with('success','Password Updated Successfully');
       }
    }

    public function accountDeactivate(Request $request){

//        dd($request->all());
        if(Hash::check($request->get('current_password'), auth()->user()->password)){

//            $userAccountStatus=User::whereId(Auth::id())->update([
//                'account_status'=>0
//            ]);
////            dd('updated');
//            if ($userAccountStatus){
                Auth::logout();
                return to_route('admin.login_page')->with('success', 'Account Deactivated Successfully');

           // }
        }


    }
}
