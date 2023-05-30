<?php namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\TriggerMailEvent;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailLibrary
{
    public
    function send_email($message_title, $message_body, $config,$shop,$access_link)
    {

        try {
            $notification_status = true;
            $mail_settings = $config->channel_event_settings;

            if (!$mail_settings)
                return ['status' => $notification_status, 'message' => 'Unable to find mail account settings.Please update the event from registered webhooks screen'];
            $channel_account = $mail_settings->channel_account;
            if (!$channel_account)
                return ['status' => $notification_status, 'message' =>
                    'No account details found.Please make sure you have not removed or updated the channel account settings.'
                ];

            $channel_account    =   $channel_account->login_credentials ;
            Mail::to($mail_settings->api_fields['receiving_email'])->send(new TriggerMailEvent($message_title, $message_body,$channel_account,$shop,$access_link));
            $response_message = 'Mail sent successfully';

        } catch(\TransportExceptionInterface  $transportExp){

            $notification_status = false;
            $response_message = $transportExp->getMessage();
        }
        catch(\Exception  $ex){

            $notification_status = false;
            $response_message = $ex->getMessage();
        }
        return ['status' => $notification_status, 'message' => $response_message];
    }


}
