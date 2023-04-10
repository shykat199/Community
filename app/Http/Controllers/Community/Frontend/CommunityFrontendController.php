<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;

class CommunityFrontendController extends Controller
{

    public function index(){
        return view('community-frontend.layout.frontend_auth');
    }

}
