<?php

use App\Http\Controllers\Community\Frontend\CommunityFrontendController;
use App\Http\Controllers\Community\Frontend\Post\CommunityUserPostController;
use App\Http\Controllers\Community\Frontend\User\CommunityUserFriendRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Community\Frontend\Profile\UserProfileDetailsController;
use App\Http\Controllers\Community\Frontend\Profile\UserProfileSettingController;
use App\Http\Controllers\Community\Frontend\User\CommunityUserFriendBirthday;
use App\Http\Controllers\Community\Frontend\Group\CommunityUserGroupController;
use App\Http\Controllers\Community\Frontend\Page\CommunityUserPageController;
use App\Http\Controllers\Community\Frontend\Video\VideoController;
use App\Http\Controllers\Community\Frontend\GetCommentController;
use App\Http\Controllers\Community\Frontend\AllReactionController;

Route::middleware(['user'])->group(function (){

    Route::get('/home',[CommunityFrontendController::class,'index'])->name('community.index');
    Route::post('/user/following',[CommunityFrontendController::class,'addUserFollow'])->name('community.user.follow');
    Route::get('/user/post/delete/{id}',[CommunityFrontendController::class,'destroy'])->name('community.user.post.delete');
    Route::post('/user/post/update',[CommunityFrontendController::class,'updatePost'])->name('community.user.post.update');
    Route::post('/user/post/comments',[CommunityFrontendController::class,'storeComment'])->name('community.user.post.comment');
    Route::get('get/user/post/comments',[CommunityFrontendController::class,'showComments'])->name('user.post.comment');
    Route::get('get/user/post/child-comments',[CommunityFrontendController::class,'showChildComments'])->name('user.load.child.comment');
    Route::get('user/post/reaction',[CommunityFrontendController::class,'storeReaction'])->name('user.post.reaction');

    //user details
    Route::post('/user-friend/accept_request',[CommunityUserFriendRequestController::class,'acceptRequest'])->name('community.user.acceptRequest');
    Route::post('/user/post',[CommunityUserPostController::class,'store'])->name('community.user.post');
    Route::post('/user/store/post-comment',[CommunityUserPostController::class,'storeCommentOfComment'])->name('community.user.store.commentsOfComments');


    //User Profile
    Route::get('/user/my-profile',[UserProfileDetailsController::class,'index'])->name('user.my-profile');
    Route::post('/user/my-profile/upload-profile-photo',[UserProfileDetailsController::class,'uploadProfilePhoto'])->name('community.user.upload.user.profile.photo');
    Route::post('/user/my-profile/upload-cover-photo',[UserProfileDetailsController::class,'uploadCoverPhoto'])->name('community.user.upload.user.cover.photo');



    //User Profile Setting
    Route::get('/user/my-profile/setting',[UserProfileSettingController::class,'index'])->name('user.my-profile.setting');
    Route::post('/user/my-profile/profile-information',[UserProfileSettingController::class,'storePersonalInformation'])->name('user.my-profile.profile-information');
//    Route::post('/user/my-profile/account-information',[UserProfileSettingController::class,'storeAccountInformation'])->name('user.my-profile.account-information');
    Route::post('/user/my-profile/update-password',[UserProfileSettingController::class,'updatePassword'])->name('user.my-profile.update-password');
    Route::post('/user/my-profile/deactivate-account',[UserProfileSettingController::class,'accountDeactivate'])->name('user.my-profile.deactivate-account');
    Route::post('/user/my-profile/education',[UserProfileSettingController::class,'storeUserEducation'])->name('user.my-profile.profile.education');
    Route::get('/user/my-profile/edit_education/{id}',[UserProfileSettingController::class,'editUserEducation'])->name('user.my-profile.profile.edit.education');
    Route::post('/user/my-profile/update_education/{id}',[UserProfileSettingController::class,'updateUserEducation'])->name('user.my-profile.update.profile.education');
    Route::post('/user/my-profile/work',[UserProfileSettingController::class,'storeUserWork'])->name('user.my-profile.profile.work');
    Route::get('/user/my-profile/edit_work/{id}',[UserProfileSettingController::class,'editUserWork'])->name('user.my-profile.edit.profile.work');
    Route::post('/user/my-profile/update_work/{id}',[UserProfileSettingController::class,'updateUserWork'])->name('user.my-profile.update.profile.work');
    Route::post('/user/my-profile/user_interest',[UserProfileSettingController::class,'storeInterest'])->name('user.my-profile.profile.interest');
    Route::get('/user/my-profile/edit_user_interest',[UserProfileSettingController::class,'editInterest'])->name('user.my-profile.profile.edit.interest');
    Route::post('/user/my-profile/user_social',[UserProfileSettingController::class,'storeSocialLinks'])->name('user.my-profile.profile.social');
//    Route::get('/user/my-profile/edit_user_interest',function (){
//        return view('community-frontend.setting');
//    })->name('user.my-profile.profile.edit.interest');

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


    //Video Section
    Route::get('/user/videos',[VideoController::class,'index'])->name('user.all.videos');


    //Friend Section
    Route::get('/user/friends',[CommunityUserFriendRequestController::class,'allFriendRequest'])->name('all.requested.friend.users');


    //Group Section
    Route::get('/user/all-groups',[CommunityUserGroupController::class,'index'])->name('user.all.groups');
    Route::post('/user/create_group',[CommunityUserGroupController::class,'createGroup'])->name('user.create.groups');
    Route::post('/user/join/group',[CommunityUserGroupController::class,'storeUserRequest'])->name('user.join.groups');
    Route::get('/user/group/{id}',[CommunityUserGroupController::class,'getSingleGroupView'])->name('user.group.details');
    Route::get('/user/group-post/delete/{id}',[CommunityUserGroupController::class,'destroyPost'])->name('community.group.post.delete');
    Route::post('/user/group-post/update',[CommunityUserGroupController::class,'editPost'])->name('community.group.post.update');
    Route::post('/user/group/accept-user-invitation',[CommunityUserGroupController::class,'acceptGroupUserInvitation'])->name('user.group.accept.invitation');
    Route::post('/user/group/post',[CommunityUserGroupController::class,'userGroupPostStore'])->name('user.group.post.store');
    Route::post('/user/group/post/reaction',[CommunityUserGroupController::class,'storeUserGroupPostReaction'])->name('user.group.post.reaction');
    Route::post('/user/group/remove',[CommunityUserGroupController::class,'destroy'])->name('user.group.remove');
    Route::post('/user/group/upload-cover-photo',[CommunityUserGroupController::class,'storeGroupCoverPhoto'])->name('user.group.cover.upload');
    Route::post('/user/group/upload-profile-photo',[CommunityUserGroupController::class,'storeGroupProfilePhoto'])->name('user.group.profile.upload');
    Route::post('/user/group/store/post-commentOfComment',[CommunityUserGroupController::class,'storeGroupPostCommentOfComment'])->name('community.user.store.group.commentsOfComments');
    Route::post('/user/group/store/post-comment',[CommunityUserGroupController::class,'storeGroupPostComment'])->name('community.store.user.group.post.comment');




    //Page Section
    Route::get('/users/all-pages',[CommunityUserPageController::class,'index'])->name('user.all.pages');
    Route::post('/user/create_page',[CommunityUserPageController::class,'createPage'])->name('user.create.pages');
    Route::get('/user/page/{id}',[CommunityUserPageController::class,'getSinglePageView'])->name('user.page.details');
    Route::get('/user/page/post-dlt/{id}',[CommunityUserPageController::class,'destroyPagePost'])->name('user.page.post.dlt');
    Route::post('/user/page/post',[CommunityUserPageController::class,'userPagePostStore'])->name('user.page.post.store');
    Route::post('/user/page/post/update',[CommunityUserPageController::class,'updatePagePost'])->name('user.page.post.update');
    Route::post('/user/page/post/reaction',[CommunityUserPageController::class,'storeUserPagePostReaction'])->name('user.page.post.reaction');
    Route::post('/user/page/upload-profile-photo',[CommunityUserPageController::class,'storePageProfilePhoto'])->name('user.page.profile.upload');
    Route::post('/user/page/upload-cover-photo',[CommunityUserPageController::class,'storePageCoverPhoto'])->name('user.page.cover.upload');
    Route::post('/user/page/store/post-comments',[CommunityUserPageController::class,'storePagePostComment'])->name('community.store.user.page.post.comment');
    Route::post('/user/page/store/post-commentOfComment',[CommunityUserPageController::class,'storePagePostCommentOfComment'])->name('community.user.store.page.commentsOfComments');


    //get all Comments........
    Route::get('/user/get-all-comments',[GetCommentController::class,'getAllComments'])->name('users.get-all-comments');
    Route::post('/user/store-all-reactions',[AllReactionController::class,'storeReaction'])->name('user.post-all.reaction');

});

