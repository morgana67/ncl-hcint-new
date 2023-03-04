<?php

namespace App\Functions;

use Mail;

class Functions {


    public static function replaceBodyEmail($body,$customer) {
        $body = str_replace("{{NAME}}", "<strong>".$customer->firstName.' '.$customer->lastName."</strong>", $body);
        $body = str_replace("{{LINK}}", route('changePassword').'?token='.$customer->token, $body);
        $body = str_replace("{{LOGO}}", '<p style="margin-top:0in;text-align:center" align="center"><img src="'.asset('front/images/email_logo.png').'" alt="'.setting('site.title').'" border="0" ></p>', $body);
        return $body;
    }

    public static function sendEmail($email, $subject, $body, $header = '', $cc = "", $bcc = "") {


        $data['to'] = $email;
        $data['body'] = $body;
        $data['subject'] = $subject;


        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <' . env('MAIL_FROM_ADDRESS') . '>' . "\r\n";
        // $headers .= 'Cc: myboss@example.com' . "\r\n";
        //return mail($email, $subject, $body, $headers);


         Mail::send('emails.template', $data, function($message) use ($data) {
            $message->to($data['to'])->subject($data['subject']);
        });
    }

    public static function makeCurlRequest($url) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url,
            )
        );
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }

}
