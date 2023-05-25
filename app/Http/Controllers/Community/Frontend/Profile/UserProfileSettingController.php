<?php

namespace App\Http\Controllers\Community\Frontend\Profile;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserDetails;
use App\Models\Community\User_Profile\CommunityUserProfileEducation;
use App\Models\Community\User_Profile\CommunityUserProfileInterest;
use App\Models\Community\User_Profile\CommunityUserProfileLanguage;
use App\Models\Community\User_Profile\CommunityUserProfileSocialink;
use App\Models\Country;
use App\Models\SightSetting;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use Illuminate\Container\RewindableGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function MongoDB\BSON\toRelaxedExtendedJSON;

class UserProfileSettingController extends Controller
{
    public function index()
    {

        $data['allCountries'] = Country::all();
        $data['userInfo'] = CommunityUserDetails::with('users')->where('user_id', '=', Auth::id())->get()->toArray();
        $data['userLanguage'] = User::with('languages')
            ->where('id', '=', Auth::id())
            ->first();
//        dd($data);

        $data['userInterests'] = CommunityUserProfileInterest::where('user_id', '=', Auth::id())->pluck('interest_details', 'interest_name')
            ->toArray();

        $data['userSocial'] = CommunityUserProfileSocialink::where('user_id', '=', Auth::id())->pluck('link', 'name')
            ->toArray();


//        dd(1);
        return view('community-frontend.setting', $data);
    }

    public function storePersonalInformation(Request $request)
    {

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
        ], [
            'current_password.required' => 'Current Password Is Required',
            'new_password.required' => 'New Password Is Required',
            'new_password.max' => 'Max Length Of Password Is 10',
            'new_password.min' => 'Max Length Of Password Is 8',
        ]);

        // Match The Old Password
        if (!Hash::check($request->get('current_password'), auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }

        #Update the new Password
        $changePassword = User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->get('new_password'))
        ]);
        if ($changePassword) {
            return redirect()->back()->with('success', 'Password Updated Successfully');
        }
    }

    public function accountDeactivate(Request $request)
    {

//        dd($request->all());
        if (Hash::check($request->get('current_password'), auth()->user()->password)) {

//            $userAccountStatus=User::whereId(Auth::id())->update([
//                'account_status'=>0
//            ]);
//            dd('updated');
//            if ($userAccountStatus){
            Auth::logout();
            return to_route('admin.login_page')->with('success', 'Account Deactivated Successfully');

            // }
        }


    }

    public function userSlag(Request $request)
    {


//        dd($slug);

        $checkSlug = User::select('id', 'user_slug')->where('user_slug', '=', $request->get('userSlag'))->first();

//        dd($checkSlug);

        if ($checkSlug === null) {
//            dd($slug);
            $updateUserSlag = User::find(Auth::id())->update([
                'user_slug' => $request->get('userSlag')
            ]);
        } elseif ($checkSlug->user_slug !== null) {
//            dd('1');
            return redirect()->back()->with('error', 'Name is already taken');
        } else {
//            dd('new create');

            $slug = '';
//        dd($request->all());


            if (Auth::user()->role === ADMIN_ROLE) {
                $slug = Carbon::now()->format('d-m-Y') . '-' . 'ADMIN' . '-' . Auth::user()->name;
            } elseif (Auth::user()->role === USER_ROLE) {
                $slug = Carbon::now()->format('d-m-Y') . '-' . 'USER' . '-' . Auth::user()->name;
            } elseif (Auth::user()->role === SERVICE_PROVIDER_ROLE) {
                $slug = Carbon::now()->format('d-m-Y') . '-' . 'SERVICE-PROVIDER' . '-' . Auth::user()->name;
            } else {
                $slug = Carbon::now()->format('d-m-Y') . '-' . 'VENDOR' . '-' . Auth::user()->name;
            }
            $userSlug = User::updateOrCreate([
                'id' => Auth::id()
            ], [
                'user_slug' => $slug
            ]);
        }

//        dd($userSlug);

        if ($updateUserSlag || $userSlug) {
            return redirect()->back()->with('success', 'Successfully Done');
        } else {
            return redirect()->back()->with('error', 'Something Wrong');
        }


    }


    public function storeUserEducation(Request $request)
    {
//        dd($request->all());

        if ($request->get('is_present') === 'on') {
            $storeEducation = CommunityUserProfileEducation::create([
                'user_id' => Auth::id(),
                'type' => 'e',
                'degree_name' => $request->get('degreeName'),
                'institute' => $request->get('instituteName'),
                'description' => $request->get('institute'),
                'starting_date' => Carbon::parse($request->get('startingDate'))->format('Y-m-d'),
                'ending_date' => Carbon::parse($request->get('passingDate'))->format('Y-m-d'),
                'is_present' => 1,
            ]);
        } else {
            $storeEducation = CommunityUserProfileEducation::create([
                'user_id' => Auth::id(),
                'type' => 'e',
                'degree_name' => $request->get('degreeName'),
                'institute' => $request->get('instituteName'),
                'description' => $request->get('institute'),
                'starting_date' => Carbon::parse($request->get('startingDate'))->format('Y-m-d'),
                'ending_date' => Carbon::parse($request->get('passingDate'))->format('Y-m-d'),
                'is_present' => 0,
            ]);
        }

        if ($storeEducation) {
            return \Redirect::back()->with('success', 'Successfully added...');
        }
    }

    public function editUserEducation($id)
    {

        $data['userInfo'] = CommunityUserDetails::all()->toArray();
        $data['userLanguage'] = User::with('languages')
            ->where('id', '=', Auth::id())
            ->first();
//        dd($data);

        $data['userInterests'] = CommunityUserProfileInterest::where('user_id', '=', Auth::id())->pluck('interest_details', 'interest_name')
            ->toArray();

        $data['userEducation'] = CommunityUserProfileEducation::find($id);


        return view('community-frontend.setting_education', $data);

    }

    public function updateUserEducation(Request $request, $id)
    {

        if ($request->get('is_present') === 'on') {
            $storeEducation = CommunityUserProfileEducation::where('id', $id)->update([
                'user_id' => Auth::id(),
                'type' => 'e',
                'degree_name' => $request->get('degreeName'),
                'institute' => $request->get('instituteName'),
                'description' => $request->get('institute'),
                'starting_date' => Carbon::parse($request->get('startingDate'))->format('Y-m-d'),
                'ending_date' => Carbon::parse($request->get('passingDate'))->format('Y-m-d'),
                'is_present' => 1,
            ]);
        } else {
            $storeEducation = CommunityUserProfileEducation::where('id', $id)->update([
                'user_id' => Auth::id(),
                'type' => 'e',
                'degree_name' => $request->get('degreeName'),
                'institute' => $request->get('instituteName'),
                'description' => $request->get('institute'),
                'starting_date' => Carbon::parse($request->get('startingDate'))->format('Y-m-d'),
                'ending_date' => Carbon::parse($request->get('passingDate'))->format('Y-m-d'),
                'is_present' => 0,
            ]);
        }

        if ($storeEducation) {
            return to_route('user.my-profile')->with('success', 'Successfully added...');
        }


    }

    public function storeUserWork(Request $request)
    {
        if ($request->get('is_present') === 'on') {
            $storeWork = CommunityUserProfileEducation::create([
                'user_id' => Auth::id(),
                'type' => 'w',
                'designation' => $request->get('designation'),
                'institute' => $request->get('companyName'),
                'description' => $request->get('company'),
                'starting_date' => Carbon::parse($request->get('startingDate'))->format('Y-m-d'),
                'ending_date' => Carbon::parse($request->get('passingDate'))->format('Y-m-d'),
                'is_present' => 1,
            ]);
        } else {
            $storeWork = CommunityUserProfileEducation::create([
                'user_id' => Auth::id(),
                'type' => 'w',
                'designation' => $request->get('designation'),
                'institute' => $request->get('companyName'),
                'description' => $request->get('company'),
                'starting_date' => Carbon::parse($request->get('startingDate'))->format('Y-m-d'),
                'ending_date' => Carbon::parse($request->get('passingDate'))->format('Y-m-d'),
                'is_present' => 0,
            ]);

        }

        if ($storeWork) {
            return \Redirect::back()->with('success', 'Successfully added...');
        }

    }

    public function editUserWork($id)
    {

        $data['userInfo'] = CommunityUserDetails::all()->toArray();
        $data['userLanguage'] = User::with('languages')
            ->where('id', '=', Auth::id())
            ->first();
//        dd($data);

        $data['userInterests'] = CommunityUserProfileInterest::where('user_id', '=', Auth::id())->pluck('interest_details', 'interest_name')
            ->toArray();

        $data['userWork'] = CommunityUserProfileEducation::find($id);


        return view('community-frontend.setting_work', $data);

    }

    public function updateUserWork(Request $request, $id)
    {
        if ($request->get('is_present') === 'on') {
            $storeWork = CommunityUserProfileEducation::where('id', $id)->update([
                'user_id' => Auth::id(),
                'type' => 'w',
                'designation' => $request->get('designation'),
                'institute' => $request->get('companyName'),
                'description' => $request->get('company'),
                'starting_date' => Carbon::parse($request->get('startingDate'))->format('Y-m-d'),
                'ending_date' => Carbon::parse($request->get('passingDate'))->format('Y-m-d'),
                'is_present' => 1,
            ]);
        } else {
            $storeWork = CommunityUserProfileEducation::where('id', $id)->update([
                'user_id' => Auth::id(),
                'type' => 'w',
                'designation' => $request->get('designation'),
                'institute' => $request->get('companyName'),
                'description' => $request->get('company'),
                'starting_date' => Carbon::parse($request->get('startingDate'))->format('Y-m-d'),
                'ending_date' => Carbon::parse($request->get('passingDate'))->format('Y-m-d'),
                'is_present' => 0,
            ]);
        }

        if ($storeWork) {
            return to_route('user.my-profile')->with('success', 'Successfully added...');
        }

    }

    public function storeInterest(Request $request)
    {

        $data = $request->except(['_method', '_token']);
//        dd($data);
        foreach ($data as $key => $value) {
            $userInterest = CommunityUserProfileInterest::updateOrCreate([
                'interest_name' => $key,
                'user_id' => Auth::id(),
            ], [
                'interest_details' => $value
            ]);
        }

        if ($userInterest) {
            return redirect()->back()->with('success', 'Added Successfully');
        }

    }


    public function storeSocialLinks(Request $request)
    {

        $data = $request->except(['_method', '_token']);
//        dd($data);
        foreach ($data as $key => $value) {
            $userSocial = CommunityUserProfileSocialink::updateOrCreate([
                'name' => $key,
                'user_id' => Auth::id(),
            ], [
                'link' => $value
            ]);
        }

        if ($userSocial) {
            return redirect()->back()->with('success', 'Added Successfully');
        }

    }


}
