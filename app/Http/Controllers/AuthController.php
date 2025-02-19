<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLogin;
use App\Http\Requests\AdminRequest;
use App\Models\Community\User\CommunityUserBan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function loginPage()
    {

        if (Auth::check() && Auth::user()) {

            if (Auth::user()->role === ADMIN_ROLE) {

                return to_route('admin.dashboard')->with('success', 'Admin Login Successfully.');

            } elseif (Auth::user()->role === USER_ROLE) {
                return to_route('community.index');
            } else {
                return "Unauthorized User";
            }

        }

        return view('admin.auth.login');

    }

    public function registerPage()
    {

        if (Auth::check() && Auth::user()) {
            if (Auth::user()->role === ADMIN_ROLE) {

                return to_route('admin.dashboard')->with('success', 'Admin Login Successfully.');

            }
            if (Auth::user()->role === USER_ROLE) {
                return to_route('community.index');
            }
        }
        return view('admin.auth.register');


    }

    public function login(AdminLogin $request)
    {
        //dd($request->all());

        $check = $request->all();

//        dd($check);
//        $banUserCheck = CommunityUserBan::join('users', 'users.id', '=', 'community_user_bans.user_id')
////            ->where('community_user_bans.user_ban', '=', '1')
//            ->where('community_user_bans.user_id', '=', Auth::id())
//            ->selectRaw('community_user_bans.user_id,community_user_bans.user_ban')
//            ->get();

//        dd($banUserCheck);

//        $getLoggedUserDetails = User::where('email', '=', $check['email'])->select('email', 'password')->first();
////        dd($getLoggedUserDetails);
//        if ($check['email'] === $getLoggedUserDetails->email && $check['password'] === Hash::check('plain-text', $getLoggedUserDetails->password)) {
//            dd('check pass');
//        }

        if (Auth::attempt([
            'email' => $check['email'],
            'password' => $check['password']
        ])) {
//            $userAccountStatus=User::where('email','=',$request->get('email'))
//                ->where('password','=',$request->get('password'))->first();
//            $userAccountStatus=$userAccountStatus->update([
//                'account_status'=>1,
//            ]);
//            $userAccountStatus=$userAccountStatus->toSql;
//            dd($userAccountStatus);

            if (Auth::user()->role === ADMIN_ROLE) {

                return to_route('admin.dashboard')->with('success', 'Admin Login Successfully.');

            } elseif (Auth::user()->role === USER_ROLE) {


                return to_route('community.index')->with('success', 'LogIn Successfully');


            } else {
                return "Invalid User";
            }

        } else {
            return Redirect::back()->with('error', 'Wrong Credential, Try Again...');
        }
    }

    public function register(AdminRequest $request)
    {

//        dd($request->all());
//        Carbon::now().'-'.'-'.$request->get('name')

        $slug = '';

        if ($request->get('role') === ADMIN_ROLE) {
            $slug = Carbon::now()->format('d-m-Y') . '-' . 'ADMIN' . '-' . $request->get('name');
        } elseif ($request->get('role') === USER_ROLE) {
            $slug = Carbon::now()->format('d-m-Y') . '-' . 'USER' . '-' . $request->get('name');
        } elseif ($request->get('role') === SERVICE_PROVIDER_ROLE) {
            $slug = Carbon::now()->format('d-m-Y') . '-' . 'SERVICE-PROVIDER' . '-' . $request->get('name');
        } else {
            $slug = Carbon::now()->format('d-m-Y') . '-' . 'VENDOR' . '-' . $request->get('name');
        }


        $createUser = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' => $request->get('role'),
            'user_slug' => $slug,
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make($request->get('password')),

        ]);
        if ($createUser) {
            return to_route('admin.login_page')->with('success', 'User Created Successfully.');
        } else {
            return Redirect::back()->with('error', 'Some Thing Wrong.');
        }
    }

    public function logout()
    {

        Auth::logout();

        return to_route('admin.login_page')->with('success', 'Logout Successfully...');


    }
}
