<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Community\Page\CommunityPageController;
use App\Http\Controllers\Community\Page\CommunityPagePostController;
use App\Http\Controllers\Community\Page\CommunityPagePostCommentController;
use App\Http\Controllers\Community\User\CommunityUserDetailsController;
use App\Http\Controllers\Community\Group\CommunityUserGroupController;
use App\Http\Controllers\Community\User\CommunityUserFriendRequestController;


Route::middleware(['auth','admin'])->prefix('/community')->group(function (){
    //Community pages Section
    Route::get('/dashboard/page',[CommunityPageController::class,'index'])->name('community.page.dashboard');
    Route::get('/pages',[CommunityPageController::class,'allPage'])->name('community.page');
    Route::get('/pages/post',[CommunityPagePostController::class,'index'])->name('community.page.posts');
    Route::get('/pages/post/comments',[CommunityPagePostCommentController::class,'index'])->name('community.page.posts.comment');

    //Community users Section
    Route::get('/users',[CommunityUserDetailsController::class,'index'])->name('community.user');
    Route::get('/users/{id}',[CommunityUserDetailsController::class,'show'])->name('community.user.show');


    //Community group Section
    Route::get('/dashboard/group',[CommunityUserGroupController::class,'index'])->name('community.user.group.dashboard');
    Route::get('/group',[CommunityUserGroupController::class,'allGroups'])->name('community.user.groups');
    Route::get('/group/users',[CommunityUserGroupController::class,'allGroupsUsers'])->name('community.allUser.groups');
    Route::get('/group/users/{id}',[CommunityUserGroupController::class,'allGroupsUsersDetails'])->name('community.allUser.details.groups');
    Route::get('/group/users/profile/{id}',[CommunityUserGroupController::class,'singleUserProfile'])->name('community.groups.singleUser.details');
    Route::get('/group/single/users/profile/{id}',[CommunityUserGroupController::class,'viewSingleUserProfile'])->name('community.groups.singleUser.profile');



});



