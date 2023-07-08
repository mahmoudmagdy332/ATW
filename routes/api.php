<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\EndPointController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>'guest:sanctum'],function(){
    Route::post('register',[AuthenticationController::class,'register']);
    Route::post('login',[AuthenticationController::class,'login']);
    Route::get('end_point',[AuthenticationController::class,'end_point']);
});


Route::group(['prefix'=>'tags'],function(){
    Route::post('/',[TagController::class,'index']);
    Route::post('/create',[TagController::class,'create']);
    Route::post('/update',[TagController::class,'update']);
    Route::post('/delete',[TagController::class,'delete']);


});

Route::group(['prefix'=>'post'],function(){
    Route::post('/',[PostController::class,'index']);
    Route::post('/create',[PostController::class,'create']);
    Route::post('/update',[PostController::class,'update']);
    Route::post('/delete',[PostController::class,'delete']);
    Route::post('/show',[PostController::class,'show']);
    Route::post('/deleted_posts',[PostController::class,'deleted_posts']);
    Route::post('/restore',[PostController::class,'restore']);
});






