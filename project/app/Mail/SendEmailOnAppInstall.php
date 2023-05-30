<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailOnAppInstall extends Mailable
{
    use Queueable, SerializesModels;

    public $shop;

    public function __construct($shop)
    {
       $this->shop = $shop;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->shop->is_deleted)
            return $this->from(['address' => env('MAIL_FROM_ADDRESS',''), 'name' => env('MAIL_FROM_NAME','Connectify')])
                ->subject('We would miss you.')
                ->view('emails.app_un_install_template');
            else
                return $this->from(['address' => env('MAIL_FROM_ADDRESS',''), 'name' => env('MAIL_FROM_NAME','Connectify')])
            ->subject('Thank you for installing our Connectify App!')
            ->view('emails.app_install_template');
    }
}
