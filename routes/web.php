<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\RoutesNotifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::view('/','welcome')->name('home');

//Status routes
Route::get('statuses',[StatusesController::class,'index'])->name('statuses.index');
Route::post('statuses',[StatusesController::class, 'store'])->name('statuses.store')->middleware('auth');

//Likes Routes
Route::post('statuses/{status}/likes',[StatusLikeController::class,'store'])->name('statuses.likes.store')->middleware('auth');
Route::delete('statuses/{status}/likes',[StatusLikeController::class,'destroy'])->name('statuses.likes.destroy')->middleware('auth');

// Statuses Comments routes
Route::post('statuses/{status}/comments',[StatusCommentsController::class,'store'])->name('statuses.comments.store')->middleware('auth');

Route::post('comments/{comment}/likes',[CommentLikesController::class,'store'])->name('comment.likes.store')->middleware('auth');

Auth::routes();



