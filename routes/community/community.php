<?php

use App\Http\Controllers\Community\Admin\Group\CommunityUserGroupController;
use App\Http\Controllers\Community\Admin\Page\CommunityPageController;
use App\Http\Controllers\Community\Admin\Page\CommunityPagePostCommentController;
use App\Http\Controllers\Community\Admin\Page\CommunityPagePostController;
use App\Http\Controllers\Community\Frontend\Profile\CommunityUserDetailsController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth','admin'])->prefix('/community')->group(function (){

    //Community pages Section
    Route::get('/dashboard/page',[CommunityPageController::class,'index'])->name('community.page.dashboard');
    Route::get('/pages',[CommunityPageController::class,'allPage'])->name('community.page');
    Route::get('/pages/post',[CommunityPagePostController::class,'index'])->name('community.page.posts');
    Route::get('/pages/post/comments',[CommunityPagePostCommentController::class,'index'])->name('community.page.posts.comment');
    Route::get('/pages/all-post/{id}',[CommunityPagePostCommentController::class,'allPagePost'])->name('user.page.all.post');
    Route::get('/pages/all-comment/{id}',[CommunityPagePostCommentController::class,'pagePostComment'])->name('user.group.page.post-comments');

    //Community users Section
    Route::get('/users',[CommunityUserDetailsController::class,'index'])->name('community.user');
    Route::get('/users-all',[CommunityUserDetailsController::class,'allUsers'])->name('community.all.user');
    Route::get('/users/{id}',[CommunityUserDetailsController::class,'show'])->name('community.user.show');
    Route::get('/users/ban/{id}',[CommunityUserDetailsController::class,'userBan'])->name('community.user.ban');
    Route::get('/users/delete/{id}',[CommunityUserDetailsController::class,'userDlt'])->name('community.user.delete');
    Route::get('/all-ban/users',[\App\Http\Controllers\Community\Admin\Users\UserBanController::class,'allBanUsers'])->name('community.alluser.ban');
    Route::get('/unban/user/{id}',[\App\Http\Controllers\Community\Admin\Users\UserBanController::class,'unbanUser'])->name('community.user.unban');
    Route::get('/unban/user/check-post/{id}',[CommunityUserDetailsController::class,'allUserPost'])->name('community.user.check-post');
    Route::get('/unban/user/check-comment/{id}',[CommunityUserDetailsController::class,'userPostComment'])->name('community.user.check-post-comment');


    //Community group Section
    Route::get('/dashboard/group',[CommunityUserGroupController::class,'index'])->name('community.user.group.dashboard');
    Route::get('/group',[CommunityUserGroupController::class,'allGroups'])->name('community.user.groups');
    Route::get('/group/users',[CommunityUserGroupController::class,'allGroupsUsers'])->name('community.allUser.groups');
    Route::get('/group/users/{id}',[CommunityUserGroupController::class,'allGroupsUsersDetails'])->name('community.allUser.details.groups');
    Route::get('/group/users/profile/{id}',[CommunityUserGroupController::class,'singleUserProfile'])->name('community.groups.singleUser.details');
    Route::get('/group/single/users/profile/{id}',[CommunityUserGroupController::class,'viewSingleUserProfile'])->name('community.groups.singleUser.profile');

    Route::get('/group/single/post/{id}',[CommunityUserGroupController::class,'viewGroupSinglePost'])->name('user.group.all.post');
    Route::get('/group/single/post-comments/{id}',[CommunityUserGroupController::class,'viewGroupSinglePostComments'])->name('user.group.show.post-comments');


    //Community dynamic dropdown section

    Route::get('/group/single/users/country',[CommunityUserGroupController::class,'dropdownCountry'])->name('community.user.dashboard.dropdown.country');
    Route::get('/group/single/users/state',[CommunityUserGroupController::class,'dropdownState'])->name('community.user.dashboard.dropdown.state');
    Route::get('/group/single/users/city',[CommunityUserGroupController::class,'dropdownCity'])->name('community.user.dashboard.dropdown.city');
    Route::get('/group/single/users/country-on-state',[CommunityUserGroupController::class,'getStateAjax'])->name('get.state.on-country-change');
    Route::post('/group/single/users/store-country',[CommunityUserGroupController::class,'storeCountry'])->name('store.user.country');
    Route::post('/group/single/users/update-country',[CommunityUserGroupController::class,'updateCountry'])->name('updte.user.country');
    Route::post('/group/single/users/store-state',[CommunityUserGroupController::class,'storeState'])->name('store.user.state');
    Route::post('/group/single/users/update-state',[CommunityUserGroupController::class,'updateState'])->name('updte.user.state');
    Route::post('/group/single/users/store-city',[CommunityUserGroupController::class,'storeCity'])->name('store.user.city');
    Route::get('/group/single/users/delete-country/{id}',[CommunityUserGroupController::class,'deleteCountry'])->name('user.delete.country');
    Route::post('/group/single/users/update-city',[CommunityUserGroupController::class,'updateCity'])->name('update.user.city');
    Route::get('/group/single/users/delete-state/{id}',[CommunityUserGroupController::class,'deleteState'])->name('user.delete.state');
    Route::get('/group/single/users/delete-state/{id}',[CommunityUserGroupController::class,'deleteState'])->name('user.delete.state');
    Route::get('/group/single/users/delete-city/{id}',[CommunityUserGroupController::class,'deleteCity'])->name('user.delete.city');
});



