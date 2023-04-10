<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Community\Frontend\CommunityFrontendController;

Route::get('/',[CommunityFrontendController::class,'index'])->name('community.index');
