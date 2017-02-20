<?php

namespace App\Listeners;

use App\Events\emailVerifypay;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
class emailVerifyMailpay
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
    public function handle(emailVerifypay $event)
    {
      $receiver = $event->name;
	  $email = $event->email;
	  $tickets = $event->ticketnum;
	   Mail::send('email.conformationverify',['email'=>$email,'token'=>$tickets], function($message) use ($email,$receiver){
		   $message->from('busticketingsrilanka@gmail.com','Online Bus Ticketing');
		   $message->to($email,$receiver);
		   $message->subject('You have reserved tickets.');
	   });
    }
}
