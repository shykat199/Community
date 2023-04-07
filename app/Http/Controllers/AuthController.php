<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLogin;
use App\Http\Requests\AdminRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use JetBrains\PhpStorm\NoReturn;
use function MongoDB\BSON\toRelaxedExtendedJSON;
use const http\Client\Curl\AUTH_ANY;

class AuthController extends Controller
{
    public function loginPage()
    {

        if (Auth::check() && Auth::user()) {

            if (Auth::user()->role === ADMIN_ROLE) {

                return to_route('admin.dashboard')->with('success','Admin Login Successfully.');

            } elseif (Auth::user()->role === USER_ROLE) {
                //return view();
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

                return to_route('admin.dashboard')->with('success','Admin Login Successfully.');

            }
            if (Auth::user()->role === USER_ROLE) {
                return "User Dashboard";
            }
        }
        return view('admin.auth.register');


    }

    public function login(AdminLogin $request)
    {
        //dd($request->all());

        $check = $request->all();

        //dd($check);

        if (Auth::attempt([
            'email' => $check['email'],
            'password' => $check['password']
        ])) {

            if (Auth::user()->role === ADMIN_ROLE) {

                return to_route('admin.dashboard')->with('success','Admin Login Successfully.');

            } elseif (Auth::user()->role === USER_ROLE) {
                return "User Dashboard";
            } elseif (Auth::user()->role === SERVICE_PROVIDER_ROLE) {
                return to_route('admin.dashboard');
            } else {
                return "Invalid User";
            }

        } else {
            return Redirect::back()->with('error', 'Wrong Credential, Try Again...');
        }
    }

    public function register(AdminRequest $request)
    {

        //dd($request->all());

        $createUser = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' => USER_ROLE,
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
