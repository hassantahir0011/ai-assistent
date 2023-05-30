<?php

namespace App\Jobs;

use App\Entities\ChannelConfig;
use App\Entities\Notification;
use App\Entities\Shop;
use App\Mail\SendEmailOnAppVersionUpdate;
use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SendEmailOnAppInstall;
use Illuminate\Queue\Middleware\RateLimited;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email_to;
    private $template;
    public $tries = 3;
    public $timeout = 120;

    public function __construct($email_to, $template)
    {
        $this->email_to = $email_to;
        $this->template = $template;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email_to)->send($this->template);
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        return [new RateLimited('email')];
    }
}
