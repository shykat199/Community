<?php

namespace App\Http\Middleware\community;

use App\Models\Community\User\CommunityUserBan;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        dd(Auth::user());

        if (Auth::check() && \Auth::user()->role === USER_ROLE) {

            $banUserCheck = CommunityUserBan::join('users', 'users.id', '=', 'community_user_bans.user_id')
                ->where('community_user_bans.user_id', '=', Auth::id())
                ->selectRaw('community_user_bans.user_id,community_user_bans.user_ban')
                ->first();

//                dd($banUserCheck);
            if ($banUserCheck->user_ban == 0) {
                return $next($request);
            } else {
                Auth::logout();
                return redirect()->route('admin.login')->with('error', 'You are temporarily ban.');
            }

        }

        Auth::logout();
        return redirect()->route('admin.login')->with('error', 'Please Login First');


    }
}
