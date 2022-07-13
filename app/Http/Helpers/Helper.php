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
            $mail->Host = env("MAIL_HOST", "smtp.mailtrap.io");
            $mail->SMTPAuth = true;
            $mail->Username = env("MAIL_USERNAME", 'f0820cb8ffefab');
            $mail->Password = env("MAIL_PASSWORD", "99d10ddeea0845");
            $mail->SMTPSecure = env("MAIL_ENCRYPTION", "tls");
            $mail->Port = 2525;
            
            //Recipients
            $mail->setFrom(env("MAIL_FROMADDRESS", "touqeer.hanif91@gmail.com"), 'ACME');
            //  $mail->addAddress($email_a, $user->fname  );     // Add a recipient
            $mail->addAddress($email_a, $user->fname);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "Hello " . $user->fname . " Reset Your Password";
            //  $mail->Body    = "test";
            $mail->Body = "<h2>Reset Your Password</h2><p>To change your password <a href='" . $url . "'>click here.</a></p>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            dd($e);
            return false;
        }
    }

}

