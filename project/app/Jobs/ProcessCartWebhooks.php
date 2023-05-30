<?php

namespace App\Jobs;

use App\Services\ProcessCartWebhooksLib;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \Carbon\Carbon;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\Cache;

class ProcessCartWebhooks implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 10000000000;
    public $timeout = 800;
    private $db_channel_config;
    private $shopify_request_data;
    private $shop;
    private $event_topic;
    private $event_name;
    private $shopify_request_header;

    public function __construct(
        $db_channel_config,
        $shopify_request_data,
        $shop, $event_topic,
        $shopify_request_header,
        $event_name
    )
    {

        $this->db_channel_config = $db_channel_config;
        $this->shopify_request_data = $shopify_request_data;
        $this->shop = $shop;
        $this->event_topic = $event_topic;
        $this->event_name = $event_name;
        $this->shopify_request_header = $shopify_request_header;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $app_key = get_app_key($this->db_channel_config);
        if(isset($app_key)){
            if($timestamp = Cache::get($app_key)) {
                if($timestamp > time()) return $this->release(
                    abs($timestamp - time())
                );
            }
        }

        $trigger_webhook = new ProcessCartWebhooksLib(
            $this->db_channel_config,
            $this->shopify_request_data,
            $this->shop,
            $this->event_topic,
            $this->shopify_request_header,
            $this->event_name);
        $trigger_webhook->trigger();

    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        $app_key = get_app_key($this->db_channel_config);

        if(isset($app_key)) return [(new WithoutOverlapping($app_key))->releaseAfter(rand(1,10))];
    }
}
