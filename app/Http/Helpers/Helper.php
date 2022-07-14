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
use App\Models\Notifications;
use DB;



class Helper
{
    public static $client = 1;
    public static $contractor = 2;
    public static $staff = 3;
    private static $MAIL_HOST = "smtp.mailtrap.io";
    private static $MAIL_USERNAME = "f0820cb8ffefab";
    private static $MAIL_PASSWORD = "99d10ddeea0845";
    private static $MAIL_ENCRYPTION = "tls";
    private static $MAIL_PORT = 2525;
    private static $MAIL_FROM_ADDRESS = "touqeer.hanif91@gmail.com";

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

    public static function saveNotification($user_id, $type, $title, $message) {

        Notifications::create([
            'user_id' => $user_id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'seen' => '0',
            'status' => 'active'
        ]);

        return true;
    }

    public static function sendEmailForgot($user, $code)
    {
        $url = url('resetpassword/?email=' . $user->email . '&code=' . $code);
        $email_a = trim($user->email);

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = env("MAIL_HOST", self::$MAIL_HOST);
            $mail->SMTPAuth = true;
            $mail->Username = env("MAIL_USERNAME", self::$MAIL_USERNAME);
            $mail->Password = env("MAIL_PASSWORD", self::$MAIL_PASSWORD);
            $mail->SMTPSecure = env("MAIL_ENCRYPTION", self::$MAIL_ENCRYPTION);
            $mail->Port = env("MAIL_PORT", self::$MAIL_PORT);

            //Recipients
            $mail->setFrom(env("MAIL_FROM_ADDRESS", self::$MAIL_FROM_ADDRESS), 'ACME');
            $mail->addAddress($email_a, $user->first_name);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "Reset Password";
            $mail->Body = "<h2>Reset Your Password</h2><p>To change your password <a href='" . $url . "'>click here.</a></p>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function sendEmailToNotify($user, $notificationType, $title)
    {
        
        $email_a = trim($user->email);
        $mail = new PHPMailer(true);

        $subject = $notificationType;
        $body = "";
        switch($notificationType) {
            case "Contract Assign":                
                $body = "<h2>Hi " . $user->first_name . " " . $user->last_name . ", </h2>
                </br>
                <p>Contract has been assigned to you!</p>";
                break;
            case "Contract Started":                
                $body = "<h2>Hi " . $user["first_name"] . " " . $user["last_name"] . ", </h2>
                </br>
                <p>Your contract has been started.</p>";
                break;
            case "Contract Completed":                
                $body = "<h2>Hi " . $user["first_name"] . " " . $user["last_name"] . ", </h2>
                </br>
                <p>Your contract have been completed.</p>";
                break;
            case "Proposal Approved":                
                $body = "<h2>Hi " . $user["first_name"] . " " . $user["last_name"] . ", </h2>
                </br>
                <p>Your proposal for " . $title . " has been approved sucessfully</p>";
                
                break;
            case "Proposal Reject":                
                $body = "<h2>Hi " . $user["first_name"] . " " . $user["last_name"] . ", </h2>
                </br>
                <p>Your proposal for " . $title . " has been rejected ! </p>";
                break;
            default:                
                $body = "";
                break;
        }


        try {
            $mail->isSMTP();
            $mail->Host = env("MAIL_HOST", self::$MAIL_HOST);
            $mail->SMTPAuth = true;
            $mail->Username = env("MAIL_USERNAME", self::$MAIL_USERNAME);
            $mail->Password = env("MAIL_PASSWORD", self::$MAIL_PASSWORD);
            $mail->SMTPSecure = env("MAIL_ENCRYPTION", self::$MAIL_ENCRYPTION);
            $mail->Port = env("MAIL_PORT", self::$MAIL_PORT);
            
            //Recipients
            $mail->setFrom(env("MAIL_FROM_ADDRESS", self::$MAIL_FROM_ADDRESS), 'ACME');
            $mail->addAddress($email_a, $user->first_name);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function sendMessageEmail($user, $toUser, $message) {
       
        $email_a = trim($toUser->email);
        $mail = new PHPMailer(true);        

        try {
            $mail->isSMTP();
            $mail->Host = env("MAIL_HOST", self::$MAIL_HOST);
            $mail->SMTPAuth = true;
            $mail->Username = env("MAIL_USERNAME", self::$MAIL_USERNAME);
            $mail->Password = env("MAIL_PASSWORD", self::$MAIL_PASSWORD);
            $mail->SMTPSecure = env("MAIL_ENCRYPTION", self::$MAIL_ENCRYPTION);
            $mail->Port = env("MAIL_PORT", self::$MAIL_PORT);

            //Recipients
            $mail->setFrom(env("MAIL_FROM_ADDRESS", self::$MAIL_FROM_ADDRESS), 'ACME');
            $mail->addAddress($email_a, $toUser->first_name);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $user->first_name . " just messaged you";
            $mail->Body = "<p>" . $message . "</p>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            dd($e);
            return false;
        }
    }
}

