<?php

namespace App\Listeners;

use App\Events\emailVerify;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
class emailVerifyMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  forgotPass  $event
     * @return void
     */
    public function handle(emailVerify $event)
    {
      $receiver = $event->name;
	  $email = $event->email;
	  $token = $event->token;
	   Mail::send('email.conformation',['email'=>$email,'token'=>$token], function($message) use ($email,$receiver){
		   $message->from('busticketingsrilanka@gmail.com','Online Bus Ticketing');
		   $message->to($email,$receiver);
		   $message->subject('You have just temparary reserved tickets.');
	   });
    }
}
