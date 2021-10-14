<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class test extends Mailable
{
    use Queueable, SerializesModels;


    public $token;
    public function __construct($token)
    {
        $this->token    = $token;
    }

    public function build()
    {
        return $this->subject('réinitialiser votre mot de passe')
                ->view('emails.Nouveau_mot_de_passe');
    }
}
