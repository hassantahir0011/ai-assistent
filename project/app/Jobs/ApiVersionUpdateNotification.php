<?php

namespace App\Jobs;

use App\Entities\ChannelConfig;
use App\Entities\Notification;
use App\Entities\Shop;
use App\Entities\ShopifyApiVersionUpdate;
use App\Mail\SendEmailOnAppVersionUpdate;
use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SendEmailOnAppInstall;

class ApiVersionUpdateNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id;
    private $payload;
    private $title;
    private $send_email;
    public $tries = 3;
    public $timeout = 120;

    public function __construct($id, $title, $payload, $send_email)
    {
        $this->id = $id;
        $this->title = $title;
        $this->payload = $payload;
        $this->send_email = $send_email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $webhook_topic_ids = array();
        $shops = array();

        foreach ($this->payload as $pl){
            $webhook_topic_ids = array_merge($webhook_topic_ids, $pl->webhook_topics_id);
        }

        $active_webhook_setups = ChannelConfig::whereIn('webhook_topic_id', $webhook_topic_ids)->where('status', true)
            ->join('webhook_topics', 'channel_configs.webhook_topic_id', '=', 'webhook_topics.id', 'inner')
            ->join('webhook_events', 'webhook_topics.webhook_event_id', '=', 'webhook_events.id', 'inner')
            ->select('channel_configs.*', 'webhook_topics.webhook_event_id','webhook_topics.topic_name', 'webhook_events.slug as webhook_event_slug', 'webhook_events.event_name as webhook_event_name')
            ->get();

        foreach ($active_webhook_setups as $active_webhook_setup){
            Notification::create(['shop_id' => $active_webhook_setup->shop_id, 'marked_as_read' => false, 'notification_type' => "api_version_update", 'notification_title' => $this->title, 'notification_body' => "Shopify has updated its event payload. Kindly update your <a target='_blank' href='".route('channel_config'  ,[$active_webhook_setup->webhook_event_slug,$active_webhook_setup->id])."'>Automation</a> accordingly!"]);
            $shops[] = $active_webhook_setup->shop_id;
        }

        if($this->send_email) {
            $shops = array_unique($shops);
            foreach ($shops as $shop_id) {
                $shop = Shop::where('shop_id', $shop_id)->first() ?? false;
                if ($shop) {
                    $job = new SendEmail($shop->email, new SendEmailOnAppVersionUpdate(route('notification.index'), $shop));
                    dispatch($job->onQueue('email'));
                }
            }
        }

        $record = ShopifyApiVersionUpdate::where('id', $this->id)->first();
        $record->status = "completed";
        $record->save();
    }
}
