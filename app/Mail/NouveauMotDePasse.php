<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NouveauMotDePasse extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public function __construct($token)
    {
        $this->token    = $token;
    }

    public function build()
    {
        return $this->subject('rĂ©initialiser votre mot de passe')
                ->view('emails.Nouveau_mot_de_passe');
    }
}
