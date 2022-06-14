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
use App\Http\Resources\LegalResource;


class LegalDocumentsController extends Controller
{
    public $successStatus = 200;

    public function uploadLegalDocument(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'listing_id'            => 'required',
            'legal_document'        => 'required',
            'legal_document_date'   => 'required',
            'user_type'             => 'required',
            'document_type'         => 'required',
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $files_count = $request->file('legal_document');
        if (!is_array($files_count)) {
            $response_data = [
                'success' => false,
                'message' => 'legal_document Parameter must be an array',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['listing_id'] = $input['listing_id'];
        $input['legal_document_date'] = $input['legal_document_date'];
        $input['user_type'] = $input['user_type'];
        $input['status'] = 'active';
        $input['document_type'] = $input['document_type'];
        $input['notes'] = $input['notes'] ?? null;
        $input['percentage'] = $input['percentage'] ?? 0;


        $files = $request->file('legal_document');
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();

            $filename = Str::random(20) . $extension;
            Storage::disk('local')->put('/public/ListingDocuments/' . $request->listing_id . '/' . $request->user_type . '/' . $filename, File::get($file));

            $input['legal_document_name'] = $file->getClientOriginalName();
            $input['legal_document_path'] = $filename;
            LegalDocuments::create($input);
        }

        $data = LegalDocuments::select('listing_id')->where('listing_id', $request->listing_id)
        ->distinct()->get();

        $response_data = [
            'success' => true,
            'message' =>  'Upload Legal Documents successfully!',
            'data' => LegalResource::collection($data),
        ];
        return response()->json($response_data, $this->successStatus);
    }

    public function getLegalDocuments(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'listing_id'            => 'required',
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $data = LegalDocuments::select('listing_id')->where('listing_id', $request->listing_id)
        ->distinct()->get();

        $response_data = [
            'success' => true,
            'message' =>  'Legal Documents',
            'data' => LegalResource::collection($data),
        ];
        return response()->json($response_data, $this->successStatus);

    }

}

