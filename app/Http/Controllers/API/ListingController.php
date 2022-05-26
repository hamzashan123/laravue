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
use App\Http\Resources\ListingResource;

class ListingController extends Controller
{

    public $successStatus = 200;

    public function createListing(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                          => 'required',
            'target_completion_datefrom'    => 'required',
            'target_completion_dateto'      => 'required',
            'minimum_budget'                => 'required',
            'maximum_budget'                => 'required'
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        //region Maximum 5 Images Validation
        if ($request->hasfile('images')) {
            $files_count = $request->file('images');
            if (!is_array($files_count)) {
                $response_data = [
                    'success' => false,
                    'message' => 'Images Parameter must be an array',
                    'errors' => $validator->errors()
                ];
                return response()->json($response_data);
            } else if (count($files_count) > 5) {
                $response_data = [
                    'success' => false,
                    'message' => 'Maximum 5 images allowed.',
                    'errors' => $validator->errors()
                ];
                return response()->json($response_data);
            }
        }
        //endregion

        $input = $request->all();
        $input['userid']  = Auth::user()->id;
        $input['name']  = $input['name'];
        $input['target_completion_datefrom']  = $input['target_completion_datefrom'];
        $input['target_completion_dateto'] = $input['target_completion_dateto'];
        $input['minimum_budget']  = $input['minimum_budget'];
        $input['maximum_budget']  = $input['maximum_budget'];
        $input['detail']  = $input['detail'] ?? '';
        $input['address_line1']  = $input['address_line1'] ?? '';
        $input['address_line2']  = $input['address_line2'] ?? '';
        $input['country']  = $input['country'] ?? '';
        $input['state']  = $input['state'] ?? '';
        $input['district']  = $input['district'] ?? '';
        $input['status']  = 'draft';
        $listing = Listing::create($input);



        //region Listing Images
        if($request->hasfile('images'))
        {
            $files = $request->file('images');
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $image = Str::random(20) . ".png";
                Storage::disk('local')->put('/public/Listing/' . $listing->id . '/images/' . $image, File::get($file));
                ListingImages::create([
                    'listing_id' => $listing->id,
                    'image'  => $image,
                    'status' => 'active'
                ]);
            }
        }
        //endregion

        $data = Listing::where('id', $listing->id)->first();

        $response_data = [
            'success' => true,
            'message' =>  'Listing created successfully!',
            'data' => new ListingResource($data),
        ];
        return response()->json($response_data, $this->successStatus);
    }

    public function updateListing(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        //region Maximum 5 Images Validation
        if ($request->hasfile('images')) {
            $files_count = $request->file('images');
            if (!is_array($files_count)) {
                $response_data = [
                    'success' => false,
                    'message' => 'Images Parameter must be an array',
                    'errors' => $validator->errors()
                ];
                return response()->json($response_data);
            } else if (count($files_count) > 5) {
                $response_data = [
                    'success' => false,
                    'message' => 'Maximum 5 images allowed.',
                    'errors' => $validator->errors()
                ];
                return response()->json($response_data);
            }
        }
        //endregion

        $input = $request->all();
        $listingdata = Listing::where('id',$input['id'])->first();

        if($listingdata != null)
        {
            $listingdata->name = $input['name'] ?? $listingdata->name;
            $listingdata->target_completion_datefrom = $input['target_completion_datefrom'] ?? $listingdata->target_completion_datefrom;
            $listingdata->target_completion_dateto = $input['target_completion_dateto'] ?? $listingdata->target_completion_dateto;
            $listingdata->minimum_budget = $input['minimum_budget'] ?? $listingdata->minimum_budget;
            $listingdata->maximum_budget = $input['maximum_budget'] ?? $listingdata->maximum_budget;
            $listingdata->detail = $input['detail'] ?? $listingdata->detail;
            $listingdata->address_line1 = $input['address_line1'] ?? $listingdata->address_line1;
            $listingdata->address_line2 = $input['address_line2'] ?? $listingdata->address_line2;
            $listingdata->country = $input['country'] ?? $listingdata->country;
            $listingdata->state = $input['state'] ?? $listingdata->state;
            $listingdata->district = $input['district'] ?? $listingdata->district;
            $listingdata->status = $input['status'] ?? $listingdata->status;
            $listingdata->save();

            //region Listing Images
            if($request->hasfile('images'))
            {
                $files = $request->file('images');
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $image = Str::random(20) . ".png";
                    Storage::disk('local')->put('/public/Listing/' . $listingdata->id . '/images/' . $image, File::get($file));
                    ListingImages::create([
                        'listing_id' => $listingdata->id,
                        'image'  => $image,
                        'status' => 'active'
                    ]);
                }
            }
            //endregion

            $response_data = [
                'success' => true,
                'message' =>  'Listing Update successfully!',
                'data' => new ListingResource($listingdata),
            ];
            return response()->json($response_data, $this->successStatus);
        } else {
            $response_data=[
                'success' => false,
                'message' => 'Data Not Found.'
            ];
            return response()->json($response_data,  $this->successStatus);
        }
    }

    public function getListing(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userid' => 'required',
            'roleid' => 'required',
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $data = null;
        switch ($request->roleid) {
            case 1:
                $data = Listing::where('userid', $request->userid)->orderBy('id','asc');
                break;
            case 2:
                $data = Listing::where('status', 'publish')->orderBy('id','asc');
                break;
            case 3:
                $data = Listing::orderBy('id','asc');
                break;
            default:
                break;
        }

        $data = $data->paginate(10);

        if(count($data) > 0)
        {
            $response_data = [
                'success' => true,
                'message' =>  'Listings',
                'data' => ListingResource::collection($data),
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

    public function getListingById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'roleid' => 'required',
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $data = null;
        switch ($request->roleid) {
            case 1:
            case 3:
                $data = Listing::where('id', $request->id)->orderBy('id','asc');
                break;
            case 2:
                $data = Listing::where('status', 'publish')->where('id', $request->id)->orderBy('id','asc');
                break;
            default:
                break;
        }

        $data = $data->paginate(10);

        if(count($data) > 0)
        {
            $response_data = [
                'success' => true,
                'message' =>  'Listings',
                'data' => ListingResource::collection($data),
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

    public function publish_listing(Request $request)
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

        $data = Listing::where('userid', Auth::user()->id)->where('id',$request->id)->first();

        if ($data != null) {
            $data->status = 'publish';
            $data->save();

            $response_data = [
                'success' => true,
                'message' => 'Listing Published successfully!',
                'data' => new ListingResource($data),
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

