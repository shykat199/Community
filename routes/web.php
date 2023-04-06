<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::prefix('dashboard')->group(function () {

    Route::get('/login/page', [AuthController::class, 'loginPage'])->name('admin.login_page');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/register/page', [AuthController::class, 'registerPage'])->name('admin.register_page');
    Route::post('/register', [AuthController::class, 'register'])->name('admin.register');

});
