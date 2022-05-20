<?php

namespace App\Http\Helpers;

use App\Models\JobsLogs;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\User;
use App\Http\Helpers\ExpoNotifications\ExpoMessage;
use App\Http\Helpers\ExpoNotifications\Expo;
use DB;

class Helper
{


    public static function generateRandomString($firstname, $lastname, $email) {
        $emailaddress = str_replace('.','', $email);
        $emailstring = explode('@', $emailaddress);
        $random_number = rand(999, 9999);
        $text = ($firstname . $lastname . $emailstring[0]);
        
        $charactersLength = strlen($text);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $text[rand(0, $charactersLength - 1)];
        }

        $randomString = ($randomString . $random_number);
        return $randomString;
    }

}

