<?php

namespace App\Listeners;

use App\Events\forgotPass;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
class forgotPassMail
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
    public function handle(forgotPass $event)
    {
      $receiver = $event->keyvalue;
	  $email = $event->email;
	   
	   Mail::send('email.forgotPass',['keyvalue'=>$receiver], function($message) use ($email,$receiver){
		   $message->from('maestrorotaractmora@gmail.com','RotaractMora');
		   $message->to($email,$receiver);
		   $message->subject('Forgot your password');
	   });
    }
}
