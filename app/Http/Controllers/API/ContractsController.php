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
use App\Models\Contracts;

use App\Http\Resources\ListingResource;
use App\Http\Resources\ContractResource;

class ContractsController extends Controller
{


    public $successStatus = 200;

    public function assignContract(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'listing_id'        => 'required',
            'contractor_id'     => 'required'
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $listing = Listing::where('id',$request->listing_id)->where('status','waiting_assignment')->first();        

        if ($listing != null) {

            $input = $request->all();
            $input['listing_id']  = $input['listing_id'];
            $input['contractor_id']  = $input['contractor_id'];
            $input['status']  = 'pre_contract';
            $input['assigned_by']  = Auth::user()->id;
            $input['description']  = $input['description'] ?? '';
            $contract = Contracts::create($input);

            $listing->status = 'pre_contract';
            $listing->save();
            
            $contract_data = Contracts::find($contract->id);

            $response_data = [
                'success' => true,
                'message' => 'Contract Assigned successfully!',
                'data' => new ContractResource($contract_data),
            ];
            return response()->json($response_data, $this->successStatus);
        }
        else {
            $response_data = [
                'success' => false,
                'message' => 'Data Not Found',
            ];
            return response()->json($response_data, $this->successStatus);
        }
    }

    public function getContracts(Request $request)
    {
        $contract = Contracts::where('status','pre_contract')->paginate(10);      

        if (count($contract) > 0) {            

            $response_data = [
                'success' => true,
                'message' => 'Contract Assigned successfully!',
                'data' => ContractResource::collection($contract),
            ];
            return response()->json($response_data, $this->successStatus);
        }
        else {
            $response_data = [
                'success' => false,
                'message' => 'Data Not Found',
            ];
            return response()->json($response_data, $this->successStatus);
        }
    }

}

