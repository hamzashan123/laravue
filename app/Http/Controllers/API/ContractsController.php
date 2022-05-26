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


class ContractsController extends Controller
{


    public $successStatus = 200;


}

