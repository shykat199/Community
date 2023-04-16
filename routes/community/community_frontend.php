<?php

use App\Http\Controllers\Community\Frontend\CommunityFrontendController;
use App\Http\Controllers\Community\Frontend\Post\CommunityUserPostController;
use App\Http\Controllers\Community\Frontend\User\CommunityUserFriendRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Community\Frontend\Profile\UserProfileDetailsController;
use App\Http\Controllers\Community\Frontend\Profile\UserProfileSettingController;

Route::middleware(['user'])->group(function (){

    Route::get('/home',[CommunityFrontendController::class,'index'])->name('community.index');
    Route::post('/user/following',[CommunityFrontendController::class,'addUserFollow'])->name('community.user.follow');

    //user details
    Route::post('/user-friend/accept_request',[CommunityUserFriendRequestController::class,'acceptRequest'])->name('community.user.acceptRequest');
    Route::post('/user/post',[CommunityUserPostController::class,'store'])->name('community.user.post');

    //User Profile
    Route::get('/user/my-profile',[UserProfileDetailsController::class,'index'])->name('user.my-profile');


    //User Profile Setting
    Route::get('/user/my-profile/setting',[UserProfileSettingController::class,'index'])->name('user.my-profile.setting');
    Route::post('/user/my-profile/profile-information',[UserProfileSettingController::class,'storePersonalInformation'])->name('user.my-profile.profile-information');

    //Sight Privacy Policy
    Route::get('/sight/privacy-policy',function (){
        return view('community-frontend.privacy');
    })->name('sight.privacy_policy');

    //Sight Privacy Policy
    Route::get('/sight/help-support',function (){
        return view('community-frontend.help&support');
    })->name('sight.help_support');

});

