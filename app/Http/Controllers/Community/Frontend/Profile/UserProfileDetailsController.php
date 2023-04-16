<?php

namespace App\Http\Controllers\Community\Frontend\Profile;

use App\Http\Controllers\Controller;

class UserProfileDetailsController extends Controller
{
    public function index(){
        return view('community-frontend.my-profile');
    }
}
