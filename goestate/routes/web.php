<?php

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\TimerController;


Route::get('/', function () {
	return view('home.welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/garden-management', [LahanController::class, 'index'])->name('garden-management')->middleware('auth');
Route::post('/garden-management', [LahanController::class, 'create'])->name('create-lahan');
Route::post('/delete-lahan/{id}', [LahanController::class, 'delete'])->name('delete-lahan');
Route::post('/update-lahan', [LahanController::class, 'updateLahan'])->name('update-lahan');
Route::post('/saveSelectedCells', [MarkController::class, 'saveSelectedCells']);
Route::get('/getMarksData/{idlahan}', [MarkController::class, 'getMarksData']);
Route::delete('/deleteSelectedCells', [MarkController::class, 'deleteSelectedCells']);
Route::delete('/deleteAllCells', [MarkController::class, 'deleteAllCells']);
Route::post('/update-berat', [MarkController::class, 'updateBerat']);
Route::get('/get-total-weight/{idlahan}/{id_user}', [MarkController::class, 'getTotalWeight']);
Route::post('/saveActionTimer', [TimerController::class, 'saveActionTimer']);
Route::post('/checkActionTimer', [TimerController::class, 'checkActionTimer']);
Route::post('/updateActionTimer', [TimerController::class, 'updateActionTimer']);
Route::get('/timers/{lahanId}/{userId}', [TimerController::class, 'getTimer']);
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth', 'verified');
Route::post('/user-profile/delete-image', [UserProfileController::class, 'deleteImage'])->name('user-profile.delete-image');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
	Route::get('/{page}', [PageController::class, 'index'])->name('page');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
