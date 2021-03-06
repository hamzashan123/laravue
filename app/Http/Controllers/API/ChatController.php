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

use App\Models\Comments;
use App\Http\Resources\CommentsResource;
use App\Models\Messages;
use App\Http\Resources\MessageResource;


class ChatController extends Controller
{
    public $successStatus = 200;

    public function postComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'listing_id'        => 'required',
            'message'        => 'required'
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $input = $request->all();
        $input['from_user_id']  = Auth::user()->id;
        $input['to_user_id']  = 0;
        $input['listing_id']  = $input['listing_id'];
        $input['message']  = $input['message'];
        $input['status']  = 'active';
        $comments = Comments::create($input);

        $comments_data = Comments::find($comments->id);

        $response_data = [
            'success' => true,
            'message' => 'Comment Post Successfully',
            'data' => new CommentsResource($comments_data),
        ];
        return response()->json($response_data, $this->successStatus);
    }

    public function getComments(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'listing_id'        => 'required'
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $comments_data = Comments::where('listing_id', $request->listing_id)->orderBy('created_at','desc');

        if($comments_data)
        {
            $response_data = [
                'success' => true,
                'message' => 'Comments List',
                'data' => CommentsResource::collection($comments_data->get()),

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

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to_user_id'     => 'required',
            'message'        => 'required'
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $to_user = User::where('id', $request->to_user_id)->first();

        if($to_user == null) {
            $response_data = [
                'success' => false,
                'message' => 'Provided user not found!'
            ];
            return response()->json($response_data);
        }

        $input = $request->all();
        $input['from_user_id']  = Auth::user()->id;
        $input['to_user_id']  = $request->to_user_id;
        $input['message']  = $input['message'];
        $input['status']  = 'active';
        $message = Messages::create($input);
        $message_data = Messages::find($message->id);

        $response_data = [
            'success' => true,
            'message' => 'Message send Successfully',
            'data' => new MessageResource($message_data),
        ];
        return response()->json($response_data, $this->successStatus);
    }

    public function getMessages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to_user_id'     => 'required'
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

       
        $messages = Messages::where(function($query) use ($request) {
            $query->where('from_user_id', Auth::user()->id)->where('to_user_id', $request->to_user_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('from_user_id', $request->to_user_id)->where('to_user_id', Auth::user()->id);
        })->orderBy('created_at', 'DESC')->paginate(5);

        if(count($messages) > 0) {
            $response_data = [
                'success' => true,
                'message' => 'Message List',
                'data' => MessageResource::collection($messages),
            ];
            return response()->json($response_data, $this->successStatus);
        } else {
            $response_data = [
                'success' => false,
                'message' => 'No Messages Found!',
            ];
            return response()->json($response_data, $this->successStatus);
        }
    }

    public function seenMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to_user_id'     => 'required'
        ]);

        if ($validator->fails()) {
            $response_data = [
                'success' => false,
                'message' => 'Incomplete data provided!',
                'errors' => $validator->errors()
            ];
            return response()->json($response_data);
        }

        $to_user = User::where('id', $request->to_user_id)->first();

        if($to_user == null) {
            $response_data = [
                'success' => false,
                'message' => 'Provided user not found!'
            ];
            return response()->json($response_data);
        }
        $user = Auth::user();
        Messages::where(['from_user_id' => $user->id, 'to_user_id' => $request->to_user_id])->update(['seen' => '1']);

        $response_data = [
            'success' => true,
            'message' => 'Message seen successfully',
        ];
        return response()->json($response_data, $this->successStatus);
    }

    public function sendMessageEmail() {
        $message = Messages::where('seen','0')->where('is_email_sent','0')->get();

        foreach ($message as $message) {
            $fromUser = User::where('id', $message->from_user_id)->first();
            $toUser = User::where('id', $message->to_user_id)->first();

            Helper::sendMessageEmail($fromUser, $toUser, $message->message);
            Messages::where(['id' => $message->id])->update(['is_email_sent' => '1']);
        }

        $response_data = [
            'success' => true,
            'message' => 'Email send successfully',
        ];
        return response()->json($response_data, $this->successStatus);
    }
}

