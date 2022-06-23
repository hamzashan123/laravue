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
use App\Models\Notifications;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public $successStatus = 200;

    public function getNotification(Request $request)
    {
        $user = Auth::user();

        $notifications = Notifications::where('user_id', $user->id)->orderBy('created_at','desc')->paginate(10);

        if(count($notifications) > 0) {
            $response_data = [
                'success' => true,
                'message' => 'Notification List',
                'data' => NotificationResource::collection($notifications),
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

    public function seenNotification(Request $request) {

        $validator = Validator::make($request->all(), [
            'id'        => 'required'
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $user = Auth::user();        
        $ids = explode(',', $request->id);
        
        $rows_affect = Notifications::where('user_id', $user->id)->whereIn('id', $ids)
                ->update(['seen' => '1']);

        $notifications = Notifications::where('user_id', $user->id)->orderBy('created_at','desc')->paginate(10);
        
        if(count($notifications) > 0) {
            $response_data = [
                'success' => true,
                'message' => 'Notification Seen Successfully',
                'data' => NotificationResource::collection($notifications),
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

