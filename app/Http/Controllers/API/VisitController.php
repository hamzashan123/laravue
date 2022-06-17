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
use App\Models\VisitImages;

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
            'percentage'          => 'required',            
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $visitPercentage = Visits::where('user_id', Auth::user()->id)->where('listing_id', $request->listing_id)->sum('percentage');
        if($request->percentage > (100 - $visitPercentage)) {
            $response_data = [
                'success' => false,
                'message' => 'percentage has been exceed'                   
            ];
            return response()->json($response_data);
        }

        $data = Listing::where('id',$request->listing_id)->where('status', 'pre_contract')->first();

        if ($data != null) {
            $input = $request->all();
            $input['user_id'] = Auth::user()->id;
            $input['listing_id']  = $input['listing_id'];
            $input['visit_date']  = $input['visit_date'];
            $input['percentage']  = $input['percentage'];
            $input['visit_summary']  = $input['visit_summary'] ?? '';
            $input['visit_detail']  = $input['visit_detail'] ?? '';
            $input['status']  = 'active';

            $visits = Visits::create($input);
            

            //region Visit Images
            if($request->hasfile('images'))
            {
                $files = $request->file('images');
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $image = Str::random(20) . ".png";
                    Storage::disk('local')->put('/public/Visit/' . $visits->id . '/images/' . $image, File::get($file));
                    VisitImages::create([
                        'visit_id' => $visits->id,
                        'image'  => $image,
                        'status' => 'active'
                    ]);
                }
            }
            //endregion

        $visit_data = Visits::find($visits->id);

            $response_data = [
                'success' => true,
                'message' => 'Upload Listing Visit successfully!',
                'data' => new VisitResource($visit_data),
                'percentage' => ($visitPercentage + $request->percentage),
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

        $visitPercentage = Visits::where('user_id', Auth::user()->id)->where('listing_id', $request->listing_id)->sum('percentage');
        $data = Visits::where('listing_id',$request->listing_id)->orderBy('id','asc')->paginate(20);

        if(count($data) > 0)
        {
            $response_data = [
                'success' => true,
                'message' =>  'Listings Visits',
                'data' => VisitResource::collection($data),
                'percentage' => $visitPercentage,
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

