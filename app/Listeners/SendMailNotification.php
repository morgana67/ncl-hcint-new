<?php

namespace App\Listeners;

use App\Events\SendMailProcessed;
use App\Functions\Functions;
use App\Models\MailConfig;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendMailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $connection = 'database';
    public $queue = 'listeners';
    public $delay = 1;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendMailProcessed  $event
     * @return void
     */
    public function handle(SendMailProcessed $event)
    {
        $data['to'] = $event->email;
        $data['subject'] = $event->subject;
        $data['body'] = $event->body;


        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <' . env('MAIL_FROM_ADDRESS') . '>' . "\r\n";
        // $headers .= 'Cc: myboss@example.com' . "\r\n";
        //return mail($email, $subject, $body, $headers);
//        for ($i = 0;$i < 10;$i++){
            Mail::send('emails.template', $data, function($message) use ($data) {
                $message->to($data['to'])->subject($data['subject']);
            });
//        }

//        Functions::sendEmail($event->email,$event->subject, $event->body);
    }
}
