<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Community\Frontend\CommunityFrontendController;
use App\Http\Controllers\Community\User\CommunityUserFriendRequestController;
use App\Http\Controllers\Community\Post\CommunityUserPostController;


Route::middleware(['user'])->group(function (){

    Route::get('/home',[CommunityFrontendController::class,'index'])->name('community.index');
    Route::post('/user/following',[CommunityFrontendController::class,'addUserFollow'])->name('community.user.follow');

    //user details
    Route::post('/user-friend/accept_request',[CommunityUserFriendRequestController::class,'acceptRequest'])->name('community.user.acceptRequest');
    Route::post('/user/post',[CommunityUserPostController::class,'store'])->name('community.user.post');

});

