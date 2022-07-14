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
Route::post('reset-password', [App\Http\Controllers\API\UserController::class, 'resetPassword']);
Route::post('verify-reset-password-code', [App\Http\Controllers\API\UserController::class, 'verifyResetPasswordCode']);
Route::post('change-password', [App\Http\Controllers\API\UserController::class, 'changePassword']);

Route::post('send-message-email', [App\Http\Controllers\API\ChatController::class, 'sendMessageEmail']);

Route::post('getlistingbyid', [App\Http\Controllers\API\ListingController::class, 'getListingById']);

Route::post('get-listing', [App\Http\Controllers\API\ListingController::class, 'getListing']);
Route::post('get-published-listings', [App\Http\Controllers\API\ListingController::class, 'getPublishedListings']);


Route::group(['middleware' => 'auth:api'], function() {
    Route::post('get-users', [App\Http\Controllers\API\UserController::class, 'getUsers']);
    Route::post('bane-user', [App\Http\Controllers\API\UserController::class, 'baneUser']);

    
    Route::post('updateProfile', [App\Http\Controllers\API\UserController::class, 'updateProfile']);

    //Listing
    Route::post('create-listings', [App\Http\Controllers\API\ListingController::class, 'createListing']);
    Route::post('update-listing', [App\Http\Controllers\API\ListingController::class, 'updateListing']);
    Route::post('delete-listings', [App\Http\Controllers\API\ListingController::class, 'deleteListing']);
    Route::post('archive-listing-images', [App\Http\Controllers\API\ListingController::class, 'archiveListingImages']);


    Route::post('my-listings', [App\Http\Controllers\API\ListingController::class, 'myListings']);
    Route::post('publish-listing', [App\Http\Controllers\API\ListingController::class, 'publishListing']);

    //Proposal
    Route::post('send-proposal', [App\Http\Controllers\API\ProposalController::class, 'sendProposal']);
    Route::post('approve-proposal', [App\Http\Controllers\API\ProposalController::class, 'approveProposal']);
    Route::post('deny-proposal', [App\Http\Controllers\API\ProposalController::class, 'denyProposal']);
    Route::post('my-listing-proposals', [App\Http\Controllers\API\ProposalController::class, 'myListingProposals']);
    Route::post('get-proposals', [App\Http\Controllers\API\ProposalController::class, 'getProposals']);
    Route::post('get-listing-proposals', [App\Http\Controllers\API\ProposalController::class, 'getListingProposals']);
    Route::post('get-proposal-details', [App\Http\Controllers\API\ProposalController::class, 'getProposalDetails']);
    Route::post('edit-proposal', [App\Http\Controllers\API\ProposalController::class, 'editProposal']);
    Route::post('withdraw-proposal', [App\Http\Controllers\API\ProposalController::class, 'withdrawProposal']);

    //Visits
    Route::post('upload-listing-visit', [App\Http\Controllers\API\VisitController::class, 'uploadListingVisit']);
    Route::post('get-listing-visit', [App\Http\Controllers\API\VisitController::class, 'getListingVisit']);
    Route::post('get-visit-details', [App\Http\Controllers\API\VisitController::class, 'getVisitDetails']);
    Route::post('archive-visit-documents', [App\Http\Controllers\API\VisitController::class, 'archiveVisitDocuments']);
    Route::post('delete-visit', [App\Http\Controllers\API\VisitController::class, 'deleteVisit']);

    //Upload Legal Document
    Route::post('upload-legal-document', [App\Http\Controllers\API\LegalDocumentsController::class, 'uploadLegalDocument']);
    Route::post('get-legal-documents', [App\Http\Controllers\API\LegalDocumentsController::class, 'getLegalDocuments']);
    Route::post('archive-legal-documents', [App\Http\Controllers\API\LegalDocumentsController::class, 'archiveLegalDocuments']);

    //Contracts
    Route::post('assign-contract', [App\Http\Controllers\API\ContractsController::class, 'assignContract']);
    Route::post('get-contracts', [App\Http\Controllers\API\ContractsController::class, 'getContracts']);
    Route::post('get-contract-detail', [App\Http\Controllers\API\ContractsController::class, 'getContractDetail']);
    Route::post('contract-started', [App\Http\Controllers\API\ContractsController::class, 'contractStarted']);
    Route::post('contract-completed', [App\Http\Controllers\API\ContractsController::class, 'contractCompleted']);

    //Chat
    Route::post('post-comment', [App\Http\Controllers\API\ChatController::class, 'postComment']);
    Route::post('get-comments', [App\Http\Controllers\API\ChatController::class, 'getComments']);

    Route::post('send-message', [App\Http\Controllers\API\ChatController::class, 'sendMessage']);
    Route::post('get-messages', [App\Http\Controllers\API\ChatController::class, 'getMessages']);
    Route::post('seen-message', [App\Http\Controllers\API\ChatController::class, 'seenMessage']);

    //Notifications
    Route::post('get-notification', [App\Http\Controllers\API\NotificationController::class, 'getNotification']);
    Route::post('seen-notification', [App\Http\Controllers\API\NotificationController::class, 'seenNotification']);
    

    //Dashboard
    Route::post('get-dashboard', [App\Http\Controllers\API\UserController::class, 'getDashboard']);
});
