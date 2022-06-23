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
use App\Models\Proposals;
use App\Models\LegalDocuments;

use App\Http\Resources\ListingResource;
use App\Http\Resources\ContractResource;
use App\Http\Resources\ContractDetailResource;

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
        
        $contractExist = Contracts::where('listing_id', $request->listing_id)->whereIn('status', ['pre_contract','contract_started','contract_completed'])
                ->exists();


        if($contractExist == true){
            $response_data = [
                'success' => false,
                'message' => 'Someone already assigned pre_contract!',
            ];
            return response()->json($response_data, $this->successStatus);
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

            $isSucess = Helper::saveNotification($input['contractor_id'], 'contract', 'Contract Assign', 'Contract Assigned successfully');

            $contract_data = Contracts::find($contract->id);

            Proposals::where(['listing_id' => $request->listing_id, 'user_id' => $request->contractor_id])->update(['status' => 'pre_contract']);    
            
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
        $contract = Contracts::whereIn('status', ['pre_contract','contract_started','contract_completed'])->paginate(10);      

        if (count($contract) > 0) {            

            $response_data = [
                'success' => true,
                'message' => 'Contracts List!',
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

    public function getContractDetail(Request $request)
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
        
        if(count($data) >= 0) {
            $response_data = [
                'success' => true,
                'message' =>  'Contract Detail',
                'data' => ContractDetailResource::collection($data),
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

    public function contractStarted(Request $request) {
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
        
        $contractExist = Contracts::where(['listing_id' => $request->listing_id, 'contractor_id' => $request->contractor_id, 'status' => 'pre_contract'])
                ->exists();

        if($contractExist == true) {            

            Contracts::where(['listing_id' => $request->listing_id, 'contractor_id' => $request->contractor_id, 'status' => 'pre_contract'])->update(['status' => 'contract_started']);
            Proposals::where(['listing_id' => $request->listing_id, 'user_id' => $request->contractor_id, 'status' => 'pre_contract'])->update(['status' => 'contract_started']);
            Listing::where(['id' => $request->listing_id, 'status' => 'pre_contract'])->update(['status' => 'contract_started']);
                        
            $contract_data = Contracts::where('listing_id', $request->listing_id)->where('contractor_id', $request->contractor_id)->first();

            $isSucess = Helper::saveNotification($contract_data->contractor_id, 'contract', 'Contract Started', 'Contract Started');

            if($contract_data != null) {
                $response_data = [
                    'success' => true,
                    'message' => 'Contract Started successfully!',
                    'data' => new ContractResource($contract_data),
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

    public function contractCompleted(Request $request) {
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
        
        $contractExist = Contracts::where(['listing_id' => $request->listing_id, 'contractor_id' => $request->contractor_id, 'status' => 'contract_started'])
                ->exists();

        if($contractExist == true) {            

            Contracts::where(['listing_id' => $request->listing_id, 'contractor_id' => $request->contractor_id, 'status' => 'contract_started'])->update(['status' => 'contract_completed']);
            Proposals::where(['listing_id' => $request->listing_id, 'user_id' => $request->contractor_id, 'status' => 'contract_started'])->update(['status' => 'contract_completed']);
            Listing::where(['id' => $request->listing_id, 'status' => 'contract_started'])->update(['status' => 'contract_completed']);
                        
            $contract_data = Contracts::where('listing_id', $request->listing_id)->where('contractor_id', $request->contractor_id)->first();

            $isSucess = Helper::saveNotification($contract_data->contractor_id, 'contract', 'Contract Completed', 'Contract Completed');

            if($contract_data != null) {
                $response_data = [
                    'success' => true,
                    'message' => 'Contract Completed successfully!',
                    'data' => new ContractResource($contract_data),
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
