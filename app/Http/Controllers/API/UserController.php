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
use App\Models\CreateListing;
use App\Models\ListingImages;

use App\Http\Resources\ListingResource;


class UserController extends Controller
{


    public $successStatus = 200;



    public function login(Request $request){

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

            $user = Auth::user();

            if($user->status =='active'){

                $success['token'] =  $user->createToken('MyApp')->accessToken;
                $id = auth()->user()->id;
                $token = $success['token'];
                $user->save();

                $response_data = [
                    'success' => true,
                    'message' => 'Login success.',
                    'data' => $success,
                    'user' => new UserResource($user)
                ];

                return response()->json($response_data, $this->successStatus);

            }

        } else {
            $response_data = [
                'success' => false,
                'message' => 'Invalid Email or Password, please try again.'
            ];
            return response()->json($response_data,  $this->successStatus);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname'         => 'required',
            'lastname'         => 'required',
            'email'         => 'required|email|unique:users',
            'country'         => 'required',
            'contact'         => 'required',
            'roleid'         => 'required',
            'password'      => 'required',
            'confirm_password'    => 'required|same:password'
        ]);

        //Check Email Duplication
        $email_data = User::where('email',$request->email)->first();
        if ($email_data != null) {
            if ($email_data != null) {
                $response_validation = [
                    'success' => false,
                    'message' => 'Provided email is already in used, Please try different.',
                    'errors' => $validator->errors()
                ];

                return response()->json($response_validation);
            }
        }

        if( $request->password != $request->confirm_password )
        {
            $response_data = [
                'success' => false,
                'message' => 'password and confirm password mismatched.',
                'email' => '',
                'user' => null,
            ];
            return response()->json($response_data);
        }

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $input = $request->all();

        $randomstring = Helper::generateRandomString($input['firstname'], $input['lastname'], $input['email']);

        $input['firstname']  = $input['firstname'];
        $input['middlename']  = $input['middlename'] ?? '';
        $input['lastname']  = $input['lastname'];
        $input['password'] = bcrypt($input['password']);
        $input['country']  = $input['country'];
        $input['state']  = $input['state'] ?? '';
        $input['city']  = $input['city'] ?? '';
        $input['contact']  = $input['contact'];
        $input['userid']  = $randomstring;
        $input['dateofbirth']  = $input['dateofbirth'] ?? null;
        $input['address']  = $input['address'] ?? null;
        $input['roleid']  = $input['roleid'];
        $input['status']  = 'active';
        $user = User::create($input);
        $data = User::find($user->id);

        $success['token'] =  $user->createToken('MyApp')->accessToken;

        $response_data = [
            'success' => true,
            'message' =>  'Account created successfully!',
            'user' => new UserResource($data),
        ];
        return response()->json($response_data, $this->successStatus);
    }

    public function updateProfile(Request $request){

        $user = Auth::user();
        $oldemail = Auth::user()->email;
        $ischangepassword = false;

        $validator = Validator::make($request->all(), [
            'email'         => 'required',
        ]);

        if ($validator->fails() || ($request->password != null && $request->confirm_password == null)) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $request->email = Str::lower($request->email);

        if($request->password != null || $request->confirm_password != null || $request->old_password != null)
        {
            if($request->password == null || $request->confirm_password == null || $request->old_password == null)
            {
                $response_data = [
                    'success' => false,
                    'message' => 'Incomplete data provided!',
                ];
                return response()->json($response_data);
            } else {
                if (!Hash::check($request['old_password'], $user->password)) {
                    $response_data = [
                        'success' => false,
                        'message' => 'Invalid old password'
                    ];
                    return response()->json($response_data);
                } else if (request('old_password') == request('password')) {
                    $response_data = [
                        'success' => false,
                        'message' => 'New Password should not be same as old password'
                    ];
                    return response()->json($response_data);
                } else {
                    $ischangepassword = true;
                }
            }
        }

        //Check Email Duplication
        $email_data = User::where('email',$request->email)->first();
        if (Str::lower($user->email) != Str::lower($request->email) && $email_data != null) {
            if ($email_data != null) {
                $response_validation = [
                    'success' => false,
                    'message' => 'You cannot use this email, Please provide another one.',
                    'errors' => $validator->errors()
                ];

                return response()->json($response_validation);
            }
        }

        if($request->password != null && $request->password != $request->confirm_password )
        {
            $response_data = [
                'success' => false,
                'message' => 'New password and confirm password mismatched.',
                'email' => '',
                'user' => null,
            ];
            return response()->json($response_data);
        }

        $user->firstname = ($request->firstname != null ? $request->firstname : $user->firstname);
        $user->middlename = ($request->middlename != null ? $request->middlename : $user->middlename);
        $user->lastname = ($request->lastname != null ? $request->lastname : $user->lastname);
        $user->email = $request->email;
        $user->password = ($request->password != null ? bcrypt($request['password']) : $user->password);
        $user->country = ($request->country != null ? $request->country : $user->country);
        $user->state = ($request->state != null ? $request->state : $user->state);
        $user->city = ($request->city != null ? $request->city : $user->city);
        $user->contact = ($request->contact != null ? $request->contact : $user->contact);
        $user->authentication_type = ($request->authentication_type != null ? $request->authentication_type : $user->authentication_type);
        $user->businesslegal_name = ($request->businesslegal_name != null ? $request->businesslegal_name : $user->businesslegal_name);
        $user->whatsapp = ($request->whatsapp != null ? $request->whatsapp : $user->whatsapp);
        $user->dateofbirth = ($request->dateofbirth != null ? $request->dateofbirth : $user->dateofbirth);
        $user->address = ($request->address != null ? $request->address : $user->address);
        $user->zipcode = ($request->zipcode != null ? $request->zipcode : $user->zipcode);
        $user->pincode = ($request->pincode != null ? $request->pincode : $user->pincode);
        $user->notification_type = ($request->notification_type != null ? $request->notification_type : $user->notification_type);
        $user->status = ($request->status != null ? $request->status : $user->status);
        $user->save();

        //add user avatar

        if ($request->hasfile('avatar')) {

            $file = $request->file('avatar');
            $avatar = Str::random(20) . ".png";

            Storage::disk('local')->put('/public/users/' . $user->id . '/' . $avatar, File::get($file));
            $user->avatar = $avatar;
            $user->save();
        }

        $message = 'Information updated successfully';
        /*
        if($oldemail != $user->email) {
            $message = 'Email changed successfully.';
            Helpers::sendemail_updateprofile($user, $oldemail, true, false);
        }

        if($ischangepassword) {
            Helperss::sendemail_updateprofile($user, $oldemail, false, false);
        }
        */
        if($user){
            $response_data = [
                'success' => true,
                'message' => $message,
                'data' => new UserResource($user)
            ];

            return response()->json($response_data, $this->successStatus);
        }
        else {
            $response_data = [
                'success' => false,
                'message' => 'Error while updating profile!'
            ];
            return response()->json($response_data,  $this->successStatus);
        }
    }

    public function create_listing(Request $request)
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

        //Auth::user();

        //dd(Auth::user());
        $input['userid']  = 1;
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
        $input['status']  = 'active';
        $listing = CreateListing::create($input);
        $data = CreateListing::find($listing->id);


        //region Listing Images
        if($request->hasfile('images'))
        {
            $files = $request->file('images');
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $image = Str::random(20) . ".png";
                Storage::disk('local')->put('/public/Listing/' . $data->id . '/images/' . $image, File::get($file));
                ListingImages::create([
                    'listing_id' => $data->id,
                    'image'  => $image,
                    'status' => 'active'
                ]);
            }
        }
        //endregion


        $response_data = [
            'success' => true,
            'message' =>  'Listing created successfully!',
            'user' => new ListingResource($data),
        ];
        return response()->json($response_data, $this->successStatus);
    }
}

