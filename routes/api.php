<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('money',\App\Http\Controllers\MoneyController::class);
Route::resource('challenge',\App\Http\Controllers\ChallengeController::class);
Route::resource('feed',\App\Http\Controllers\FeedController::class);
Route::resource('upload',\App\Http\Controllers\UploadController::class);
Route::resource('message',\App\Http\Controllers\MessageController::class);
