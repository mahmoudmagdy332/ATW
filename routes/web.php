<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
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

Route::get('/', function () {
   /*  Log::channel('http')->info('API END POINT',[
        'user_id'=>1,
    ]); */
   /*  $response = Http::get('https://randomuser.me/api/');
    Log::channel('http')->info(json_encode($response->object()->results)); */
});
