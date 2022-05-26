<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Proposals;
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

use App\Http\Resources\ListingResource;
use App\Http\Resources\ProposalsResource;

class ProposalController extends Controller
{
    public $successStatus = 200;

    public function createProposal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'clientid'    => 'required',
            'listingid'    => 'required',
            'contractorid'    => 'required',
            'min_budget'    => 'required',
            'max_budget'    => 'required',
            'target_startdate'    => 'required',
            'target_enddate'    => 'required',
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $data = Listing::where('id',$request->listingid)->where('status', 'publish')->first();

        if ($data != null) {
            $input = $request->all();
            $input['client_id']  = $input['clientid'];
            $input['listing_id']  = $input['listingid'];
            $input['contractor_id'] = $input['contractorid'];
            $input['min_budget']  = $input['min_budget'];
            $input['max_budget']  = $input['max_budget'];
            $input['target_startdate']  = $input['target_startdate'];
            $input['target_enddate']  = $input['target_enddate'];
            $input['status']  = 'active';
            $proposals = Proposals::create($input);
            $bid_data = Proposals::find($proposals->id);

            $response_data = [
                'success' => true,
                'message' => 'Create Proposal successfully!',
                'data' => new ProposalsResource($bid_data),
            ];
            return response()->json($response_data, $this->successStatus);
        }
        else {
            $response_data = [
                'success' => false,
                'message' => 'Listing Not Available For Proposal',
            ];
            return response()->json($response_data, $this->successStatus);
        }
    }

    public function getProposal(Request $request)
    {
        $data = null;
        if($request->id != null) {
            $data = Proposals::where('id',$request->id)->get();
        } else {
            $data = Proposals::get();
        }

        if (count($data) > 0) {
            $response_data = [
                'success' => true,
                'message' => 'Proposal List',
                'data' => ProposalsResource::collection($data),
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

