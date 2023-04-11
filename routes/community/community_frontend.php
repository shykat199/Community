<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Community\Frontend\CommunityFrontendController;


Route::middleware(['user'])->group(function (){

    Route::get('/home',[CommunityFrontendController::class,'index'])->name('community.index');

});

