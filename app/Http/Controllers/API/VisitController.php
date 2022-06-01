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
use App\Models\Visits;

use App\Http\Resources\ListingResource;
use App\Http\Resources\VisitResource;


class VisitController extends Controller
{
    public $successStatus = 200;

    public function uploadListingVisit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'listing_id'          => 'required',
            'visit_date'          => 'required',
            'progress'          => 'required',            
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $data = Listing::where('id',$request->listing_id)->where('status', 'approved')->first();

        if ($data != null) {
            $input = $request->all();            
            $input['user_id'] = Auth::user()->id;
            $input['listing_id']  = $input['listing_id'];
            $input['visit_date']  = $input['visit_date'];
            $input['progress']  = $input['progress'];
            $input['status']  = 'active';
            $visits = Visits::create($input);
            $visit_data = Visits::find($visits->id);

            $response_data = [
                'success' => true,
                'message' => 'Upload Listing Visit successfully!',
                'data' => new VisitResource($visit_data),
            ];
            return response()->json($response_data, $this->successStatus);
        }
        else {
            $response_data = [
                'success' => false,
                'message' => 'Listing Not Available For Visit',
            ];
            return response()->json($response_data, $this->successStatus);
        }
    }

    public function getListingVisit(Request $request)
    {       
        $validator = Validator::make($request->all(), [
            'listing_id'          => 'required',                
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $data = Visits::where('listing_id',$request->listing_id)->orderBy('id','asc')->paginate(20);

        if(count($data) > 0)
        {
            $response_data = [
                'success' => true,
                'message' =>  'Listings Visits',
                'data' => VisitResource::collection($data),
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

    public function getVisitDetails(Request $request)
    {       
        $validator = Validator::make($request->all(), [
            'id'          => 'required',                
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $data = Visits::where('id',$request->id)->orderBy('id','asc')->first();

        if($data != null)
        {
            $response_data = [
                'success' => true,
                'message' =>  'Visits Detail',
                'data' => new VisitResource($data),
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
}

