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
            'title'                          => 'required',
            'target_completion_datefrom'    => 'required',
            'target_completion_dateto'      => 'required',
            'min_budget'                => 'required',
            'max_budget'                => 'required'
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }
        
        if(Auth::user()->role_id == 2) {
            $response_data = [
                'success' => true,
                'message' =>  'Cannot create listing ,please contact with support!',                
            ];
            return response()->json($response_data, $this->successStatus);

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
        $input['user_id']  = Auth::user()->id;
        $input['title']  = $input['title'];
        $input['target_completion_datefrom']  = $input['target_completion_datefrom'];
        $input['target_completion_dateto'] = $input['target_completion_dateto'];
        $input['min_budget']  = $input['min_budget'];
        $input['max_budget']  = $input['max_budget'];
        $input['description']  = $input['description'] ?? '';
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
            $listingdata->title = $input['title'] ?? $listingdata->title;
            $listingdata->target_completion_datefrom = $input['target_completion_datefrom'] ?? $listingdata->target_completion_datefrom;
            $listingdata->target_completion_dateto = $input['target_completion_dateto'] ?? $listingdata->target_completion_dateto;
            $listingdata->min_budget = $input['min_budget'] ?? $listingdata->min_budget;
            $listingdata->max_budget = $input['max_budget'] ?? $listingdata->max_budget;
            $listingdata->description = $input['description'] ?? $listingdata->description;
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

    public function deleteListing(Request $request)
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

        if(Auth::user()->role_id != 2) {
            $listingResponse = Listing::where('id', $request->id)->delete();

            $listingImagesResponse = ListingImages::where('listing_id', $request->id)->delete();       
            
            $response_data = [
                'success' => true,
                'message' =>  'Listing Delete successfully!',                
            ];
            return response()->json($response_data, $this->successStatus);

        } else {
            $response_data = [
                'success' => false,
                'message' => 'Contractor has no permission to delete this record',                
            ];
            return response()->json($response_data);
        }       
    }

    public function getListing(Request $request)
    {       
        $data = Listing::orderBy('id','asc')->paginate(10);

        if(count($data) > 0)
        {
            $response_data = [
                'success' => true,
                'message' =>  'Get Listings',
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

    public function myListings(Request $request)
    {        
        $data = Listing::where('user_id', Auth::user()->id)->orderBy('id','asc')->paginate(10);

        if(count($data) > 0)
        {
            $response_data = [
                'success' => true,
                'message' =>  'My Listings',
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

    public function getPublishedListings(Request $request)
    {
        $data = Listing::whereNotIn('status', ['draft'])->orderBy('id','asc')->paginate(10);

        if(count($data) > 0)
        {
            $response_data = [
                'success' => true,
                'message' =>  'Published Listings',
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
            'role_id' => 'required',
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
        switch ($request->role_id) {
            case 1:
            case 3:
                $data = Listing::where('id', $request->id)->orderBy('id','asc');
                break;
            case 2:
                $data = Listing::whereNotIn('status', ['draft'])->where('id', $request->id)->orderBy('id','asc');
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

    public function publishListing(Request $request)
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

        $data = Listing::where('user_id', Auth::user()->id)->where('id',$request->id)->first();

        if ($data != null) {
            $data->status = 'publish';
            $data->published_by = Auth::user()->id;
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

    public function archiveListingImages(Request $request) {

        $validator = Validator::make($request->all(), [
            'listing_id'     => 'required',
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

        if($user->role_id == 1 || $user->role_id == 3) {
            
            $listing = Listing::where('id', $request->listing_id);

            if(count($listing->get()) > 0) {
                if($user->role_id == 1) {
                    $listing = $listing->where('user_id', $user->id);

                    if(count($listing->get()) <= 0) {
                        $response_data = [
                            'success' => false,
                            'message' => 'Data Not Found',
                        ];
                        return response()->json($response_data, $this->successStatus);
                    }
                }

                $rows_affect = ListingImages::where(['listing_id' => $request->listing_id, 'image' => $image_, 'status' => 'active'])->update(['status' => 'delete']);
                
                if($rows_affect > 0) {
                    $response_data = [
                        'success' => true,
                        'message' => 'Listing Image archive successfully!',                    
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
        } else {
            $response_data = [
                'success' => false,
                'message' => 'Data Not Found',
            ];
            return response()->json($response_data, $this->successStatus);
        }
    }

}
