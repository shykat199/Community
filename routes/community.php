<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Community\Page\CommunityPageController;

Route::prefix('/community')->group(function (){

    Route::get('/pages',[CommunityPageController::class,'index'])->name('community.page');

});
