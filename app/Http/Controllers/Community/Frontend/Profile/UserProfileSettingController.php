<?php

namespace App\Http\Controllers\Community\Frontend\Profile;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserDetails;
use App\Models\Community\User_Profile\CommunityUserProfileLanguage;
use App\Models\SightSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileSettingController extends Controller
{
    public function index()
    {
        $data['userInfo'] = CommunityUserDetails::all()->toArray();
        $data['userLanguage'] =User::with('languages')
            ->where('id','=',Auth::id())
            ->get();
//        dd($data);
        return view('community-frontend.setting', $data);
    }

    public function storePersonalInformation(Request $request)
    {

//        dd($request->all());

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
        $communityUserDetails = CommunityUserDetails::updateOrCreate([
            'user_id' => Auth::id(),
            'dob' => $request->get('dob'),
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
}
