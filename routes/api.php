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

Route::post('login', [App\Http\Controllers\API\UserController::class, 'login']);
Route::post('register', [App\Http\Controllers\API\UserController::class, 'register']);
Route::post('create-listing', [App\Http\Controllers\API\UserController::class, 'create_listing']);
Route::post('create-listing', [App\Http\Controllers\API\UserController::class, 'create_listing']);
Route::post('publish-listing', [App\Http\Controllers\API\UserController::class, 'publish_listing']);
Route::post('publishlisting-bid', [App\Http\Controllers\API\UserController::class, 'publishlisting_bid']);
Route::post('get-publishlisting-bid', [App\Http\Controllers\API\UserController::class, 'getpublishlisting_bid']);

Route::group(['middleware' => 'auth:api'], function() {



});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
