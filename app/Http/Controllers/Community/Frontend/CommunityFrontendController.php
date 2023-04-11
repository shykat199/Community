<?php

namespace App\Http\Controllers\Community\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Community\Page\CommunityPage;
use Illuminate\Support\Facades\Auth;

class CommunityFrontendController extends Controller
{

    public function index(){

        return view('community-frontend.index');
    }

}
