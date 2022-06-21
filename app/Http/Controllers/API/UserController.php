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
            'first_name'         => 'required',
            'last_name'         => 'required',
            'email'         => 'required|email|unique:users',
            'country'         => 'required',
            'contact'         => 'required',
            'role_id'         => 'required',
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

        $randomstring = Helper::generateRandomString($input['first_name'], $input['last_name'], $input['email']);

        $input['first_name']  = $input['first_name'];
        $input['user_name']  = $input['first_name'] . ' ' . $input['last_name'];
        $input['last_name']  = $input['last_name'];
        $input['password'] = bcrypt($input['password']);
        $input['country']  = $input['country'];
        $input['state']  = $input['state'] ?? '';
        $input['city']  = $input['city'] ?? '';
        $input['contact']  = $input['contact'];
        $input['user_id']  = $randomstring;
        $input['date_of_birth']  = $input['date_of_birth'] ?? null;
        $input['address']  = $input['address'] ?? null;
        $input['role_id']  = $input['role_id'];
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

        if($request->password != null || $request->confirm_password != null)
        {
            if($request->password == null || $request->confirm_password == null)
            {
                $response_data = [
                    'success' => false,
                    'message' => 'Incomplete data provided!',
                ];
                return response()->json($response_data);
            } else {
                 if (Hash::check($request['password'], $user->password)) {
                    $response_data = [
                        'success' => false,
                        'message' => 'New Password should not be same as old password'
                    ];
                    return response()->json($response_data);
                } else {
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

        $user->first_name = ($request->first_name != null ? $request->first_name : $user->first_name);
        $user->user_name = ($request->user_name != null ? $request->user_name : $user->user_name);
        $user->last_name = ($request->last_name != null ? $request->last_name : $user->last_name);
        $user->email = $request->email;
        $user->password = ($request->password != null ? bcrypt($request['password']) : $user->password);
        $user->contact = ($request->contact != null ? $request->contact : $user->contact);
        $user->address = ($request->address != null ? $request->address : $user->address);
        $user->date_of_birth = ($request->date_of_birth != null ? $request->date_of_birth : $user->date_of_birth);
        $user->country = ($request->country != null ? $request->country : $user->country);
        $user->state = ($request->state != null ? $request->state : $user->state);
        $user->city = ($request->city != null ? $request->city : $user->city);
        $user->save();

        //add user avatar

        if ($request->hasfile('avatar')) {

            $file = $request->file('avatar');
            $avatar = Str::random(20) . ".png";

            Storage::disk('local')->put('/public/users/' . $user->id . '/' . $avatar, File::get($file));
            $user->avatar = $avatar;
            $user->save();
        }

        if($user){
            $response_data = [
                'success' => true,
                'message' => 'Profile updated successfully',
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

    public function getDashboard() {
        
        $totalListingCount = Listing::count();
        $users = User::where('status', 'active')->get();
        $totalClients = $users->where('role_id','1')->count();
        $totalContractors = $users->where('role_id','2')->count();
        $totalEBStaff = $users->where('role_id','3')->count();    
         
        
        $data = [
            'totallistings' => $totalListingCount,
            'totalclients' => $totalClients,
            'totalcontractors' => $totalContractors,
            'totalstaff' => $totalEBStaff,
            'totalusers' => $users->count(),
        ];

        $response_data = [
            'data' => $data,
        ];

        return response()->json($response_data,  $this->successStatus);

    }

    public function getUsers(Request $request) {

        $users = User::where('status', 'active')->where('id','!=' , Auth::user()->id)->get();

        if(count($users) > 0) {
            $response_data = [
                'success' => true,
                'message' => 'Users List',
                'user' => UserResource::collection($users)
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

