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
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Listing;
use App\Models\Messages;


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
            else {
                $response_data = [
                'success' => false,
                'message' => 'User not found'
            ];
            return response()->json($response_data,  $this->successStatus);
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

        $user = Auth::user();
        $users = User::whereIn('status',['active','banned'] )->whereNotIn('id',[$user->id]);        
        if($user->role_id == 3) {
            $users = $users;
        } else {
            $messages = Messages::where('status', 'active');
            $messages = $messages->where('from_user_id', $user->id)->orWhere('to_user_id', $user->id);

            $fromUser = $messages->pluck('from_user_id');
            $toUser = $messages->pluck('to_user_id');                       

            $users = $users->whereIn('id', $fromUser)->orWhereIn('id', $toUser);
            $users = $users->whereNotIn('id',[$user->id]);
        }        

        if($request->filter != null) {
            $users = $users->where(DB::raw("CONCAT(first_name,' ',last_name)"), 'LIKE', '%' . $request->filter . '%');
        }
        
        $users = $users->get();


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
                'message' => 'No Communication yet!',
            ];
            return response()->json($response_data, $this->successStatus);
        }
    }

    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $user = User::where('email', $request->email)->where('status','active')->first();
        
        if($user != null) {
            $code = rand(999, 9999999999);
            $date = Carbon::parse(Carbon::now());

            $user->reset_password_code = $code;
            $user->reset_password_expiry = $date->addhour(1)->toDateTimeString();
            $user->save();

            Helper::sendEmailForgot($user, $code);

            $response_data = [
                'success' => true,
                'message' => 'Please check your email for a link to reset your password.',
                //'code' => $code
            ];
            return response()->json($response_data);

        } else {
            $response_data=[
                'success' => false,
                'message' => 'Email Not Exist.'
            ];
            return response()->json($response_data,  $this->successStatus);
        }
    }

    public function verifyResetPasswordCode(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'code' => 'required'
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $user = User::where('email', $request->email)->where('status','active')->where('reset_password_code', '!=', null)
                    ->where('reset_password_code', '!=', '')->where('reset_password_code', $request->code)->first();

        if($user != null) {
            $date = Carbon::parse(Carbon::now());
            if($date <= $user->reset_password_expiry) {
                $response_data=[
                    'success' => true,
                    'message' => 'Code verify successfully'
                ];
                return response()->json($response_data,  $this->successStatus);
            } else {
                $response_data=[
                    'success' => false,
                    'message' => 'Reset password code has been expired'
                ];
                return response()->json($response_data,  $this->successStatus);
            }
        } else {
            $response_data=[
                'success' => false,
                'message' => 'Code not matched.'
            ];
            return response()->json($response_data,  $this->successStatus);
        }
    }

    public function changePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        if ($request->password != $request->confirm_password) {
            $response_data = [
                'success' => false,
                'message' => 'Password and confirm password mismatched.',
            ];
            return response()->json($response_data);
        } else if (Str::length($request->password) < 8) {
            $response_data = [
                'success' => false,
                'message' => 'Password length must be greater than or equal to 8 character',
            ];
            return response()->json($response_data);
        } else {
            $user = User::where('email', $request->email)->where('status','active')->first();
            if($user != null) {

                $user->password = bcrypt($request->password);
                $user->save();

                $response_data = [
                    'success' => true,
                    'message' => 'Password change successfully',
                ];
                return response()->json($response_data);

            } else {
                $response_data = [
                    'success' => false,
                    'message' => 'Data not found',
                ];
                return response()->json($response_data);
            }
        }
    }

    public function baneUser(Request $request) {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $auth = Auth::user();
        $user = User::where('id', $request->id)->where('id', '!=', $auth->id)->first();
        
        if($user != null && $request->status == 'banned') {
            User::where(['id' => $request->id])->update(['status' => 'banned']);
            $response_data = [
                'success' => true,
                'message' => 'User Ban successfully',
            ];
            return response()->json($response_data, $this->successStatus);

        }elseif($user != null && $request->status == 'unbanned'){
            User::where(['id' => $request->id])->update(['status' => 'active']);
            $response_data = [
                'success' => true,
                'message' => 'User unbanned successfully',
            ];
            return response()->json($response_data, $this->successStatus);
        } else {
            $response_data = [
                'success' => false,
                'message' => 'User Not Found',
            ];
            return response()->json($response_data, $this->successStatus);
        }
        

    }
}

