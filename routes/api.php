<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

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

Route::post('getlisting', [App\Http\Controllers\API\ListingController::class, 'getListing']);
Route::post('getlistingbyid', [App\Http\Controllers\API\ListingController::class, 'getListingById']);

Route::post('createproposal', [App\Http\Controllers\API\ProposalController::class, 'createProposal']);
Route::post('getproposal', [App\Http\Controllers\API\ProposalController::class, 'getProposal']);


Route::group(['middleware' => 'auth:api'], function() {

    Route::post('updateProfile', [App\Http\Controllers\API\UserController::class, 'updateProfile']);

    Route::post('createlisting', [App\Http\Controllers\API\ListingController::class, 'createListing']);
    Route::post('updatelisting', [App\Http\Controllers\API\ListingController::class, 'updateListing']);
    Route::post('publish-listing', [App\Http\Controllers\API\ListingController::class, 'publish_listing']);

});
