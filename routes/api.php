<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AmazonChimeController;
use App\Http\Controllers\AuthenticationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// authentication routes

Route::group(['prefix'=>'auth'],function(){
    Route::post('/login-user',[AuthenticationController::class, 'login']);
    Route::post('/register-user',[AuthenticationController::class, 'registerUser']);
    Route::post('/refresh-token',[AuthenticationController::class, 'refreshAccessToken']);
});




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/create-meeting',[AmazonChimeController::class,'createMeetingWithAttendee']);
Route::post('/find-meeting',[AmazonChimeController::class,'findMeetingById']);
Route::post('/find-attendee-meeting',[AmazonChimeController::class,'findAttendeeMeetingById']);
Route::post('/create-attendee-meeting',[AmazonChimeController::class,'createAttendeInDB']);



