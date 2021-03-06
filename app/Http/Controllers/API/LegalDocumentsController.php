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
use App\Models\LegalDocumentImages;

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
        if($input['percentage'] != null) {        
            $legalDocumentPercentage = LegalDocuments::where('user_id', Auth::user()->id)
                                                    ->where('listing_id', $input['listing_id'])
                                                    ->where('user_type', $input['user_type'])
                                                    ->where('document_type', $input['document_type'])->sum('percentage');

            if($input['percentage'] > (100 - $legalDocumentPercentage)) {
                $response_data = [
                    'success' => false,
                    'message' => 'percentage has been exceed'                   
                ];
                return response()->json($response_data);
            }            
        }

        
        $input['user_id'] = Auth::user()->id;
        $input['listing_id'] = $input['listing_id'];
        //$input['legal_document_date'] = $input['legal_document_date'];
        $input['user_type'] = $input['user_type'];
        $input['status'] = 'active';
        $input['document_type'] = $input['document_type'];
        $input['notes'] = $input['notes'] ?? null;
        $input['percentage'] = $input['percentage'] ?? 0;
        $legaldocuments = LegalDocuments::create($input);


        $files = $request->file('legal_document');
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();

            $filename = Str::random(20) . $extension;
            Storage::disk('local')->put('/public/ListingDocuments/' . $request->listing_id . '/' . $request->user_type . '/' . $filename, File::get($file));
            
            LegalDocumentImages::create([
                'listing_document_id' => $legaldocuments->id,
                'legal_document_name' => $file->getClientOriginalName(),
                'legal_document_path' => $filename,
                'legal_document_date' => $input['legal_document_date'],
                'status' => 'active'
            ]);
        }

        $data = LegalDocuments::select('listing_id')->where('listing_id', $request->listing_id)
        ->distinct()->get();

        $response_data = [
            'success' => true,
            'message' =>  'Upload Legal Documents successfully!',
            'user' => LegalResource::collection($data),
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

        if(count($data) > 0) {
            $response_data = [
                'success' => true,
                'message' =>  'Legal Documents',
                'data' => LegalResource::collection($data),
            ];
            return response()->json($response_data, $this->successStatus);
        } else {
            $response_data = [
                'success' => false,
                'message' => 'Data Not Found',
            ];
            return response()->json($response_data, $this->successStatus);
        }
    }

    public function archiveLegalDocuments(Request $request) {
        $validator = Validator::make($request->all(), [
            'document_id'     => 'required',
            'image_url'     => 'required',
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $image_url = explode('/', $request->image_url);
        $image_ = $image_url[count($image_url) - 1];

        $user = Auth::user();
        $legalDocuments = LegalDocumentImages::where('listing_document_id', $request->document_id)->where('status','active')
                                             ->where('legal_document_path', $image_);

        if($user->role_id == 1 || $user->role_id == 2) {
            $userType = ($user->role_id == 1 ? 'client' : 'contractor');

            $legalDocuments = $legalDocuments->with('getLegalDocuments')->whereHas('getLegalDocuments', function($query) use($userType) {
                $query->where('user_type', $userType);
            });        
        }

        $legalDocuments = $legalDocuments->get();
        if(count($legalDocuments) > 0) {
            
            $rows_affect = LegalDocumentImages::where(['listing_document_id' => $request->document_id, 'legal_document_path' => $image_, 'status' => 'active'])
                ->update(['status' => 'delete']);

            if($rows_affect > 0) {
                $response_data = [
                    'success' => true,
                    'message' => 'Legal Document archive successfully!',                    
                ];
                return response()->json($response_data, $this->successStatus);
            } else {
                $response_data = [
                    'success' => false,
                    'message' => 'Data Not Found',
                ];
                return response()->json($response_data, $this->successStatus);
            }
        } else {
            $response_data = [
                'success' => false,
                'message' => 'Data Not Found',
            ];
            return response()->json($response_data, $this->successStatus);
        }

    }

}

