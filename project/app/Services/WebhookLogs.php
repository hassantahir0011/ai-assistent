<?php

namespace App\Services;

use App\Entities\IncomingShopifyWebhook;
use App\Entities\ProcessedJob;
use App\Entities\WebhookLog;
use Illuminate\Support\Str;

class WebhookLogs
{

    public function handle_dublicate_webhooks($shop, $event_topic, $data)
    {
        if ($event_topic == 'orders/edited') {
            $data = $data['order_edit'];
        }
        if (Str::contains($event_topic, 'locales')) {
            return true;
        }
        $object_id = $data['id'] ?? $data['inventory_item_id'] ?? 0;
        $shopify_updated_at = $data['updated_at'] ?? '0000-00-00 00:00:00';
        try {
            $log = new IncomingShopifyWebhook();
            $log->object_id = $object_id;
            $log->shop_id = $shop->shop_id;
            $log->topic_name = $event_topic;
            $log->shopify_updated_at = $shopify_updated_at;
            $log->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function save_logs($status, $channel_config, $data, $shop, $message = '')
    {
        $object_id = $data['id'] ?? $data['inventory_item_id'] ?? 0;
        $shopify_updated_at = $data['updated_at'] ?? null;
        try {

            $log = new WebhookLog();
            $log->object_id = $object_id;
            $log->shop_id = $shop->shop_id;
            $log->webhook_topic_id = $channel_config->webhook_topic_id;
            $log->channel_config_id = $channel_config->id;
            $log->status = $status;
            $log->message = $message;
            $log->shopify_updated_at = $shopify_updated_at;
            $log->webhook_data = $data;
            if(!$status) $log->retries_left = 3;
            $log->save();
            //save no of jobs per shop in table to track remaining jobs per month
            $processed_jobs = new ProcessedJob();
            $processed_jobs->shop_id = $shop->shop_id;
            $processed_jobs->save();
        } catch (\Exception $e) {
        }
    }

    public function save_retry_logs($status, $channel_config, $data, $shop, $message = '')
    {
        $object_id = $data['id'] ?? $data['inventory_item_id'] ?? 0;
        $shopify_updated_at = $data['updated_at'] ?? null;
        try {

            $log = new WebhookLog();
            $log->object_id = $object_id;
            $log->shop_id = $shop->shop_id;
            $log->webhook_topic_id = $channel_config->webhook_topic_id;
            $log->channel_config_id = $channel_config->id;
            $log->status = $status;
            $log->message = $message;
            $log->shopify_updated_at = $shopify_updated_at;
            $log->webhook_data = $data;
            if(!$status) $log->retries_left = 0;
            $log->save();
            //save no of jobs per shop in table to track remaining jobs per month
            $processed_jobs = new ProcessedJob();
            $processed_jobs->shop_id = $shop->shop_id;
            $processed_jobs->save();
        } catch (\Exception $e) {
        }
    }

    public function allowed_tasks_per_plan($shop)
    {
        $active_plan = $shop->current_plan_type;
        $current_month_jobs = $shop->processed_jobs()->count();
        $allowed_webhooks_tasks = allowed_webhooks_tasks($active_plan);
        if ($current_month_jobs < $allowed_webhooks_tasks) {
            return true;
        }
        return false;
    }


}
