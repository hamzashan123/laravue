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
use DB;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Listing;
use App\Models\ListingImages;

use App\Http\Resources\ListingResource;
use App\Http\Resources\ProposalsResource;
use App\Http\Resources\GetProposalResource;

class ProposalController extends Controller
{
    public $successStatus = 200;

    public function sendProposal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'listing_id'          => 'required',
            'min_budget'          => 'required',
            'max_budget'          => 'required',
            'target_startdate'    => 'required',
            'target_enddate'      => 'required',
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        if(Auth::user()->role_id != 2) {
            $response_data = [
                'success' => false,
                'message' => 'Bider must be a Contractor',
            ];
            return response()->json($response_data);
        }

        $proposal = Proposals::where('listing_id',$request->listing_id)->where('user_id', Auth::user()->id)->first();
        if($proposal != null) {
            $response_data = [
                'success' => false,
                'message' => 'Proposal already send',
            ];
            return response()->json($response_data);
        }


        $data = Listing::where('id',$request->listing_id)->where('status', 'publish')->first();

        if ($data != null) {
            $input = $request->all();
            $input['listing_id']  = $input['listing_id'];
            $input['user_id'] = Auth::user()->id;
            $input['min_budget']  = $input['min_budget'];
            $input['max_budget']  = $input['max_budget'];
            $input['target_startdate']  = $input['target_startdate'];
            $input['target_enddate']  = $input['target_enddate'];
            $input['status']  = 'pending';
            $proposals = Proposals::create($input);
            $bid_data = Proposals::find($proposals->id);

            $response_data = [
                'success' => true,
                'message' => 'Proposal send successfully!',
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

    public function approveProposal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'     => 'required',
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $data = Proposals::where('id',$request->id)->first();
        if ($data != null) {
            if(!($data['status'] == 'reject' || $data['status'] == 'pending')) {
                $response_data = [
                    'success' => false,
                    'message' => 'Proposal already approved!',
                    'errors' => $validator->errors()
                ];
                return response()->json($response_data);
            }
        }

        if ($data != null) {
            
            $data->status = 'approved';
            $data->approved_by = Auth::user()->id;
            $data->rejected_by = null;
            $data->save();

            $isSucess = Helper::saveNotification($data->user_id, 'proposal', 'Proposal Approved', 'Your ' . $data->getListing->title . ' Proposal Approved Sucessfully');


            $listing = Listing::where('id',$data->listing_id)->first();

            if($listing != null && !($listing['status'] == 'pre_contract' || $listing['status'] == 'contract_started' || $listing['status'] == 'contract_completed')) {
                $listing->status = 'waiting_assignment';
                $listing->save();
            }

            $response_data = [
                'success' => true,
                'message' => 'Proposal Approved successfully!',
                'data' => new ProposalsResource($data),
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

    public function denyProposal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'     => 'required',
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $data = Proposals::where('id',$request->id)->first();

        if ($data != null) {
            $data->status = 'reject';
            $data->approved_by = null;
            $data->rejected_by = Auth::user()->id;
            $data->save();

            $isSucess = Helper::saveNotification($data->user_id, 'proposal', 'Proposal Reject', 'Your ' . $data->getListing->title . ' proposal has been rejected');

            $listing = Listing::where('id', $data->listing_id)->first();
            if($listing != null) {
                $listing->status = 'publish';
                $listing->save();
            }

            $response_data = [
                'success' => true,
                'message' => 'Proposal Rejected successfully!',
                'data' => new ProposalsResource($data),
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

    public function getProposalDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'     => 'required',
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

       
        $data = Proposals::where('id',$request->id)->first();        

        if ($data != null) {
            $response_data = [
                'success' => true,
                'message' => 'Proposal Detail',
                'data' => new ProposalsResource($data),
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

    public function myListingProposals(Request $request)
    {
       
        $data = Listing::where('user_id', Auth::user()->id)->get();        

        if (count($data) > 0) {
            $response_data = [
                'success' => true,
                'message' => 'My Listing Proposals',
                'data' => GetProposalResource::collection($data),
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

    public function getProposals(Request $request)
    {
        $data;      
        if(Auth::user()->role_id == 1) {
            //Client
            $data = Listing::with('getListingProposals')->whereHas('getListingProposals',function($query){
                $query->whereIn('status' , ['approved','pre_contract','contract_started','contract_completed']);
            })->where('user_id', Auth::user()->id)->whereNotIn('status', ['draft','publish']);
        } else if (Auth::user()->role_id == 2) {
            //Contractor
            $data = Listing::with('getListingProposals')->whereHas('getListingProposals',function($query){
                $query->where(['user_id'=> Auth::user()->id]);
            });
        } else if (Auth::user()->role_id == 3) {
            //EB Staff
            $data = Listing::whereNotIn('status', ['draft']);
        }            

        $data = $data->paginate(10);    

        if (count($data) > 0) {
            $response_data = [
                'success' => true,
                'message' => 'Listing Proposals',
                'data' => GetProposalResource::collection($data),
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

    public function getListingProposals(Request $request) {

        $validator = Validator::make($request->all(), [
            'listing_id'     => 'required',
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }
        //only client can see approved proposal by staff
        if(Auth::user()->role_id == 1){
            $data = Proposals::where(['listing_id' => $request->listing_id])->whereIn('status' , ['approved','pre_contract','contract_started','contract_completed'])->paginate(10);
        //contractor can see only his proposal
        }else if(Auth::user()->role_id == 2){
            $data = Proposals::where(['listing_id' => $request->listing_id , 'user_id' => Auth::user()->id])->paginate(10);
        }else{
            $data = Proposals::where('listing_id', $request->listing_id)->paginate(10);
        }
               

        if (count($data) > 0) {
            $response_data = [
                'success' => true,
                'message' => 'Listing Proposals',
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
