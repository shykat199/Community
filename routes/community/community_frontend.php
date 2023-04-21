<?php

use App\Http\Controllers\Community\Frontend\CommunityFrontendController;
use App\Http\Controllers\Community\Frontend\Post\CommunityUserPostController;
use App\Http\Controllers\Community\Frontend\User\CommunityUserFriendRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Community\Frontend\Profile\UserProfileDetailsController;
use App\Http\Controllers\Community\Frontend\Profile\UserProfileSettingController;
use App\Http\Controllers\Community\Frontend\User\CommunityUserFriendBirthday;

Route::middleware(['user'])->group(function (){

    Route::get('/home',[CommunityFrontendController::class,'index'])->name('community.index');
    Route::post('/user/following',[CommunityFrontendController::class,'addUserFollow'])->name('community.user.follow');

    //user details
    Route::post('/user-friend/accept_request',[CommunityUserFriendRequestController::class,'acceptRequest'])->name('community.user.acceptRequest');
    Route::post('/user/post',[CommunityUserPostController::class,'store'])->name('community.user.post');

    //User Profile
    Route::get('/user/my-profile',[UserProfileDetailsController::class,'index'])->name('user.my-profile');
    Route::post('/user/my-profile/upload-profile-photo',[UserProfileDetailsController::class,'uploadProfilePhoto'])->name('community.user.upload.user.profile.photo');
    Route::post('/user/my-profile/upload-cover-photo',[UserProfileDetailsController::class,'uploadCoverPhoto'])->name('community.user.upload.user.cover.photo');


    //User Profile Setting
    Route::get('/user/my-profile/setting',[UserProfileSettingController::class,'index'])->name('user.my-profile.setting');
    Route::post('/user/my-profile/profile-information',[UserProfileSettingController::class,'storePersonalInformation'])->name('user.my-profile.profile-information');
    Route::post('/user/my-profile/account-information',[UserProfileSettingController::class,'storeAccountInformation'])->name('user.my-profile.account-information');
    Route::post('/user/my-profile/update-password',[UserProfileSettingController::class,'updatePassword'])->name('user.my-profile.update-password');
    Route::post('/user/my-profile/deactivate-account',[UserProfileSettingController::class,'accountDeactivate'])->name('user.my-profile.deactivate-account');

    //Sight Privacy Policy
    Route::get('/sight/privacy-policy',function (){
        return view('community-frontend.privacy');
    })->name('sight.privacy_policy');

    //Sight Privacy Policy
    Route::get('/sight/help-support',function (){
        return view('community-frontend.help&support');
    })->name('sight.help_support');


    //Birthday Routes
    Route::get('/user/friends-birthday',[CommunityUserFriendBirthday::class,'index'])->name('user.friend.birthday.wish');
    Route::post('/user/friends-birthday/wish',[CommunityUserFriendBirthday::class,'storeMessage'])->name('user.friend.birthday.wishMessage');


    //Friend Section
    Route::get('/user/friends',[CommunityUserFriendRequestController::class,'allFriendRequest'])->name('all.requested.friend.users');
});

