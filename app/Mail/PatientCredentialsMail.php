<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PatientCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $password;
    public $full_name;

    public function __construct($email, $password,$full_name)
    {
        $this->email = $email;
        $this->password = $password;
        $this->full_name = $full_name;
    }

    public function build()
    {
        return $this->subject('Your Account Credentials')
                    ->view('email.patient_credentials')
                    ->with([
                        'email' => $this->email,
                        'password' => $this->password,
                        'full_name' => $this->full_name,
                    ]);
    }
}

