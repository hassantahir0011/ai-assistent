<?php

namespace App\Mail;

use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class TriggerMailEvent extends Mailable
{
    public $user;
    public $mail_settings;
    public $notification_body_text;
    public $notification_body_title;
    public $access_link;
    //upgrade to laravel 7.1
//https://newbedev.com/how-to-change-mail-configuration-before-sending-a-mail-in-the-controller-using-laravel
    public function __construct($notification_body_title, $notification_body_text, $mail_settings, $user, $access_link)
    {

        $this->notification_body_title = $notification_body_title;
        $this->notification_body_text = $notification_body_text;
        $this->mail_settings = $mail_settings;
        $this->user = $user;
        $this->access_link = $access_link;
    }

    /**
     * Override Mailable functionality to support per-user mail settings
     *
     * @param  \Illuminate\Contracts\Mail\Mailer $mailer
     * @return void
     */
    public function send($mailer)
    {

        $mail_driver = $this->mail_settings['mail_driver'];
        $mail_host = $this->mail_settings['mail_host'];
        $mail_port = $this->mail_settings['mail_port'];
        $mail_username = $this->mail_settings['mail_username'];
        $mail_password = $this->mail_settings['mail_password'];
        $mail_encryption = $this->mail_settings['mail_encryption'];

        $dsn="$mail_driver://$mail_username:$mail_password@$mail_host:$mail_port";

        $transport = Transport::fromDsn($dsn);
        $mailer = app(\Illuminate\Mail\Mailer::class);
        $mailer->setSymfonyTransport($transport);

        Container::getInstance()->call([$this, 'build']);
        $mailer->send($this->buildView(), $this->buildViewData(), function ($message) {
            $this->buildFrom($message)
                ->buildRecipients($message)
                ->buildSubject($message)
                ->buildAttachments($message)
                ->runCallbacks($message);
        });
    }

    public function build()
    {

        return $this->from($this->mail_settings['mail_from_address'], $this->mail_settings['mail_from_name'])
            ->subject(config('constants.platform_name') . ' Webhook')
            ->view('mail.notification_template');
    }
}