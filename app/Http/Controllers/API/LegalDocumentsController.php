<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Helpers\Helper;
use Notification;
use App\Notifications\EmailVerification;
use URL;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Listing;
use App\Models\ListingImages;
use App\Models\LegalDocuments;

use App\Http\Resources\ListingResource;
use App\Http\Resources\LegalDocumentsResource;


class LegalDocumentsController extends Controller
{
    public $successStatus = 200;

    public function uploadListingVisit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'listing_id'          => 'required',
            'legal_document_name'          => 'required',
            'legal_document_date'          => 'required',
            'user_type'          => 'required',
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

       
    }

}

