<?php

namespace App\Http\Controllers\Community\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserDetails;
use App\Models\Community\User_Post\Birthday;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function MongoDB\BSON\toRelaxedExtendedJSON;

class CommunityUserFriendBirthday extends Controller
{
    public function index()
    {

        $currentDate = \Carbon\Carbon::now();
        $todayBirthdays = User::join('community_user_friends as userFriend', function ($q) {
            $q->on('userFriend.requested_user_id', '=', 'users.id');
            $q->where('userFriend.user_id', '=', Auth::id());
            $q->where('userFriend.user_id', '!=', ADMIN_ROLE);
        })
            ->join('community_user_details as userDetails', function ($q) use ($currentDate) {
                $q->on('userDetails.user_id', '=', 'userFriend.requested_user_id');
                $q->whereRaw("DATE_FORMAT(userDetails.dob,'%m-%d') = DATE_FORMAT(now(), '%m-%d')");
            })
            ->selectRaw('users.id as Uid, users.name as userName,userDetails.dob')
            ->orderBy('userDetails.dob', 'ASC')
            ->get();

//        dd($todayBirthday);
        $myFreinds = [];
        foreach (myFriends() as $myFriend) {
            $myFreinds[] = $myFriend->uId;
        }
        $getAllBirthdays = CommunityUserDetails::join('users', function ($q) use ($myFreinds) {
            $q->on('community_user_details.user_id', '=', 'users.id');
            $q->where('users.id', '!=', ADMIN_ROLE);
            $q->whereIn('users.id', $myFreinds);
        })
            ->selectRaw('users.id as Uid,users.name,community_user_details.dob')
            ->get();
//        return $getAllBirthdays;
        return view('community-frontend.birthday-wish', compact('todayBirthdays', 'getAllBirthdays'));
    }

    public function storeMessage(Request $request)
    {

//        @dd($request->all());
        $birthdayWish = Birthday::create([
            'user_id' => Auth::id(),
            'wished_user_id' => $request->get('wished_user_id'),
            'status' => 1,
            'message' => $request->get('message'),
        ]);
        if ($birthdayWish) {
            return to_route('user.friend.birthday.wish')->with('success', 'Successfully Send Messages');
        }
    }
}
