<?php

namespace App\Http\Controllers\Community\User;

use App\Http\Controllers\Controller;
use App\Models\Community\Page\CommunityPage;
use App\Models\Community\User\CommunityUserDetails;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\StrictSessionHandler;

class CommunityUserDetailsController extends Controller
{

    public function dashboard(){
        $data=array();


    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=array();
        $data['allUserDetails']=CommunityUserDetails::join('users','users.id','community_user_details.user_id')
            ->where('users.role','!=',ADMIN_ROLE)
            ->selectRaw('users.id as uId,users.name,users.email,community_user_details.*')
            ->get();
        return view('admin.community-page.allUsers',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $singleUser=CommunityUserDetails::join('users','users.id','community_user_details.user_id')
            ->where('community_user_details.id','=',$id)
            ->where('community_user_details.user_id','!=',ADMIN_ROLE)
            ->selectRaw('users.name,users.email,users.id as uId,community_user_details.*')
            ->get();
//        return $sigleUser;
        return view('admin.community-page.singleUsersDetails',compact('singleUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommunityUserDetails $communityUserDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommunityUserDetails $communityUserDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunityUserDetails $communityUserDetails)
    {
        //
    }
}
