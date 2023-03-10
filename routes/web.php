<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserPagesController as UPC;
use App\Http\Controllers\AuthGoogleController;
use App\Http\Controllers\TodoManagementController;
use App\Http\Controllers\StepManagementController;
use App\Http\Controllers\UserProfileController;

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



Route::prefix('/')->group(function() {
    Route::get('/', [UPC::class,'index'])->name('home');
    Route::get('faq', [UPC::class,'faq'])->name('faq');
    Route::get('terms-and-privacy', [UPC::class,'termsAndPrivacy'])->name('termsAndPrivacy');
    Route::get('contact-us', [UPC::class,'contactUs'])->name('contactUs');
    Route::post('contact-us', [UPC::class,'contactUsStore'])->name('contactUsStore');
    Route::resource('todo', TodoManagementController::class);
    Route::post('/todo/update-step-status',[TodoManagementController::class,'updateStepStatus']);
    Route::resource('step', StepManagementController::class);
    Route::get('profile',[UserProfileController::class,'index'])->name('profile');
    Route::patch('profile/{id}/update',[UserProfileController::class,'update'])->name('profile-update');
    Route::get('/generateKMeans', [UPC::class,'generateKMeans']);
    Route::prefix('test')->group(function(){
        Route::get('/1', [UPC::class,'tes']);
    });
});

Route::prefix('/auth')->group(function() {
    Route::get('/', [AuthGoogleController::class,'index'])->name('login');
    Route::get('google', [AuthGoogleController::class,'redirectToGoogle'])->name('login.google');
    Route::get('logout', [AuthGoogleController::class,'logout'])->name('logout');
    Route::get('google/callback',[AuthGoogleController::class, 'googleCallBack']);
});