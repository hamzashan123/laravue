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


Route::post('getlistingbyid', [App\Http\Controllers\API\ListingController::class, 'getListingById']);

Route::post('get-proposals', [App\Http\Controllers\API\ProposalController::class, 'getProposals']);
Route::post('getproposal', [App\Http\Controllers\API\ProposalController::class, 'getProposal']);


Route::post('get-listing', [App\Http\Controllers\API\ListingController::class, 'getListing']);
Route::post('get-published-listings', [App\Http\Controllers\API\ListingController::class, 'getPublishedListings']);

Route::post('get-listing-visit', [App\Http\Controllers\API\VisitController::class, 'getListingVisit']);
Route::post('get-visit-details', [App\Http\Controllers\API\VisitController::class, 'getVisitDetails']);


Route::group(['middleware' => 'auth:api'], function() {

    Route::post('updateProfile', [App\Http\Controllers\API\UserController::class, 'updateProfile']);
    
    //Listing
    Route::post('create-listings', [App\Http\Controllers\API\ListingController::class, 'createListing']);
    Route::post('update-listing', [App\Http\Controllers\API\ListingController::class, 'updateListing']);
    Route::post('delete-listings', [App\Http\Controllers\API\ListingController::class, 'deleteListing']);


    Route::post('my-listings', [App\Http\Controllers\API\ListingController::class, 'myListings']);
    Route::post('publish-listing', [App\Http\Controllers\API\ListingController::class, 'publishListing']);

    //Proposal
    Route::post('send-proposal', [App\Http\Controllers\API\ProposalController::class, 'sendProposal']);
    Route::post('approve-proposal', [App\Http\Controllers\API\ProposalController::class, 'approveProposal']);
    Route::post('deny-proposal', [App\Http\Controllers\API\ProposalController::class, 'denyProposal']);
    Route::post('my-listing-proposals', [App\Http\Controllers\API\ProposalController::class, 'myListingProposals']);
    

    //Visits
    Route::post('upload-listing-visit', [App\Http\Controllers\API\VisitController::class, 'uploadListingVisit']);


    //Upload Legal Document
    Route::post('upload-legal-document', [App\Http\Controllers\API\LegalDocumentsController::class, 'uploadLegalDocument']);
    
    
    
});
