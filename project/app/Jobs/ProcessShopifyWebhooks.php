<?php

namespace App\Jobs;

use App\Entities\ChannelConfig;
use App\Entities\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \Carbon\Carbon;

class ProcessShopifyWebhooks implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 50;
    public $timeout = 12000;
    private $shopify_request_data;
    private $store_domain;
    private $event_topic;
    private $shopify_request_header;
    private $webhook_logs;

    public function __construct(
        $store_domain, $event_topic,
        $shopify_request_data,
        $shopify_request_header,
        $webhook_logs
    )
    {
        $this->shopify_request_data = $shopify_request_data;
        $this->store_domain = $store_domain;
        $this->event_topic = $event_topic;
        $this->shopify_request_header = $shopify_request_header;
        $this->webhook_logs = $webhook_logs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $event_topic = $this->event_topic; // $request->header('x-shopify-topic');
            $store_domain = $this->store_domain; // $request->header('x-shopify-shop-domain');
            $shopify_request_data = $this->shopify_request_data;
            $shopify_request_header = $this->shopify_request_header;

            $shop = Shop::where('myshopify_domain', $store_domain)
                ->where('is_deleted', 0)
                ->first();
            if (!$shop || !$this->webhook_logs->allowed_tasks_per_plan($shop)) {
                return;
            }
            //check for duplicate webhooks restricting by multiple entries in db with help of composite keys
            $check_not_duplicates = $this->webhook_logs->handle_dublicate_webhooks($shop, $event_topic, $shopify_request_data);
            if ($check_not_duplicates ) {
                // process slack webhooks if registered0
                $channel_configs = ChannelConfig::where('shop_id', $shop->shop_id)
                    ->join('webhook_topics', 'channel_configs.webhook_topic_id', '=', 'webhook_topics.id', 'inner')
                    ->select('channel_configs.*', 'webhook_topics.topic_name', 'webhook_topics.webhook_event_id')
                    ->where('webhook_topics.topic_name', $event_topic)
                    ->where('channel_configs.status', 1)->get();

                if ($channel_configs->isNotEmpty()) {
                    foreach ($channel_configs as $channel_config):
                        if ($channel_config->topic_name == $event_topic) {
                            $this->dispatchRelatedJob($channel_config, $shopify_request_data, $shopify_request_header, $shop, $event_topic);
                        }
                    endforeach;
                }
            }
        } catch (\Exception $e) {
        }
    }

    private function dispatchRelatedJob($channel_config, $shopify_request_data, $shopify_request_header, $shop, $event_topic)
    {
        $event_name = webhookEventNameByTopicName($event_topic);
        switch ($event_name) {
            case "Cart":
                $queue = new ProcessCartWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "Checkout":
                $queue = new ProcessCheckoutsWebhooks($channel_config, collect($shopify_request_data), $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "Collection":
                $queue = new ProcessCollectionWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "Customer":
                $queue = new ProcessCustomersWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "CustomerSavedSearch":
                $queue = new ProcessCustomerSavedSearchWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "DraftOrder":
                $queue = new ProcessOrderWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "Fulfillment":
                $queue = new ProcessFulfillmentsWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "FulfillmentEvent":
                $queue = new ProcessFulfillmentEventsWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "InventoryItem":
                $queue = new ProcessInventoryItemLevelWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "InventoryLevel":
                $queue = new ProcessInventoryItemLevelWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "Location":
                $queue = new ProcessLocationWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "Order":
                $queue = new ProcessOrderWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "OrderTransaction":
                $queue = new ProcessOrderTransactionsWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "Product":
                $queue = new ProcessProductsWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "Refund":
                $queue = new ProcessRefundsWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "Shop":
                $queue = new ProcessShopWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "TenderTransaction":
                $queue = new ProcessTenderTransactionsWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "Theme":
                $queue = new ProcessThemeWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "OrderEdit":
                $queue = new ProcessOrderEditWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "ShopAlternateLocale":
                $queue = new ProcessShopAlternateLocaleWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "SubscriptionContract":
                $queue = new ProcessSubscriptionContractWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            case "Dispute":
                $queue = new ProcessDisputeWebhooks($channel_config, $shopify_request_data, $shop, $event_topic, $shopify_request_header, $event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds(rand(1,60))))->onQueue('quick');
                break;
            default:
                break;
        }


    }
}
