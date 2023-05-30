<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailOnAppVersionUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $shop;

    public function __construct($link, $shop)
    {
       $this->link = $link;
       $this->shop = $shop;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(['address' => env('MAIL_FROM_ADDRESS',''), 'name' => env('MAIL_FROM_NAME','Connectify')])
            ->subject('Urgent changes required!')
            ->view('emails.app_version_update_template');
    }
}
