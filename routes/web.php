<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Community\Frontend\CommunityFrontendController;
use App\Http\Controllers\Community\Frontend\DeleteAllCommentController;
use App\Http\Controllers\Community\Frontend\GetCommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
require base_path('routes/community/community.php');
require base_path('routes/community/community_frontend.php');

Route::get('/login', [AuthController::class, 'loginPage'])->name('admin.login_page');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::get('/register/page', [AuthController::class, 'registerPage'])->name('admin.register_page');
Route::post('/register', [AuthController::class, 'register'])->name('admin.register');

Route::middleware(['auth'])->group(function(){
    Route::get('/admin/dashboard',[AdminDashboardController::class,'dashboard'])->name('admin.dashboard');
    Route::get('get/user/post/child-comments',[CommunityFrontendController::class,'showChildComments'])->name('user.load.child.comment');
    Route::get('/user/get-all-comments',[GetCommentController::class,'getAllComments'])->name('users.get-all-comments');
    Route::get('/user/delete-all-comments',[DeleteAllCommentController::class,'allAjaxDelete'])->name('user.delete.comments');
});
