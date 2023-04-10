<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Community\Page\CommunityPageController;
use App\Http\Controllers\Community\Page\CommunityPagePostController;
use App\Http\Controllers\Community\Page\CommunityPagePostCommentController;
use App\Http\Controllers\Community\User\CommunityUserDetailsController;

Route::prefix('/community')->group(function (){
    //Community pages Section
    Route::get('/dashboard/page',[CommunityPageController::class,'index'])->name('community.page.dashboard');
    Route::get('/pages',[CommunityPageController::class,'allPage'])->name('community.page');
    Route::get('/pages/post',[CommunityPagePostController::class,'index'])->name('community.page.posts');
    Route::get('/pages/post/comments',[CommunityPagePostCommentController::class,'index'])->name('community.page.posts.comment');

    //Community users Section
    Route::get('/users',[CommunityUserDetailsController::class,'index'])->name('community.user');
    Route::get('/users/{id}',[CommunityUserDetailsController::class,'show'])->name('community.user.show');

});



