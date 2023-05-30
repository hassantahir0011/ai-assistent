<?php namespace App\Services;

use App\Jobs\ProcessCollectionWebhooks;
use Illuminate\Support\Str;

class ProcessCollectionWebhooksLib
{
    private $db_channel_config;
    private $shopify_request_data;
    private $shop;
    private $event_name;
    private $event_topic;
    private $shopify_request_header;
    private $is_test_webhook ;
    private $is_retry_webhook;

    public function __construct(
        $db_channel_config,
        $shopify_request_data,
        $shop, $event_topic,
        $shopify_request_header,
        $event_name,
        //if class is initiated from test webhooks controller
        $is_test_webhook= false,
        $is_retry_webhook= false
    )
    {
        $this->db_channel_config = $db_channel_config;
        $this->shopify_request_data = $shopify_request_data;
        $this->shop = $shop;
        $this->event_topic = $event_topic;
        $this->shopify_request_header = $shopify_request_header;
        $this->event_name = $event_name;
        $this->is_test_webhook = $is_test_webhook;
        $this->is_retry_webhook = $is_retry_webhook;
    }

    public function trigger()
    {
        $webhook_logs = new WebhookLogs();
        $ShopifyService = new ShopifyService();
        $data = $this->shopify_request_data;
        $is_allowed_webhook = true;
        if (!$this->is_test_webhook && !empty($this->db_channel_config->execution_conditions) && !Str::contains($this->event_topic, '/delete')) {
            $execution_conditions = $this->db_channel_config->execution_conditions;
            $handle = $data['handle'];
            $updated_at = date('Y-m-d', strtotime($data['updated_at']));
            $condition_str = $ShopifyService->filter_webhook_conditions_str_format($execution_conditions);
            try {
                $is_allowed_webhook = eval($condition_str);
            } catch (\Throwable $e) {
                $is_allowed_webhook = false;
                $webhook_logs->save_logs(0, $this->db_channel_config, $data, $this->shop, $e->getMessage() . ".Please contact support team");
            }
        }
        // if webhook filters/conditions set are not satisfied
        if (!$is_allowed_webhook) return;
        $process_webhooks = new ProcessWebhooks($this->shop);
        $response = $process_webhooks->process_drip_connector($this->db_channel_config, $this->event_topic, $data, 'Collection');
        // send response to test webhooks in json
        if ($this->is_test_webhook && isset($response))
            return response()->json($response);

        // send response to Retry webhooks in json
        if ($this->is_retry_webhook && isset($response)) {
            $webhook_logs->save_retry_logs($response['status'] ? 1 : 0, $this->db_channel_config, $data, $this->shop, $response['message']);
            return $response;
        }
        // save webhook log
        if (!$this->is_test_webhook && isset($response) && !empty($response)){

            if (!$response['status'] && $response['message'] == config('channel.code_503_message')) {
                $queue = new ProcessCollectionWebhooks($this->db_channel_config, $this->shopify_request_data, $this->shop, $this->event_topic, $this->shopify_request_header, $this->event_name);
                $availableAt = now()->addSeconds(60);
                dispatch($queue->delay($availableAt))->onQueue(($this->db_channel_config->channel_name == 'google_sheets' || $this->db_channel_config->channel_name == 'microsoft_excel_sheet') ? 'delay' : 'quick');
            }
            if (!$response['status'] && $response['message'] == "Rate Limit Issue") {
                $after = $response['retry_after'] + rand(1,60);
                $app_key = get_app_key($this->db_channel_config);
                if(isset($app_key)){
                    Cache::put($app_key, now()->addSeconds($after)->timestamp, $after);
                }
                $queue = new ProcessCollectionWebhooks($this->db_channel_config, $this->shopify_request_data, $this->shop, $this->event_topic, $this->shopify_request_header, $this->event_name);
                dispatch($queue->delay(Carbon::now()->addSeconds($after)))->onQueue(($this->db_channel_config->channel_name == 'google_sheets' || $this->db_channel_config->channel_name == 'microsoft_excel_sheet') ? 'delay' : 'quick');
            }
            if ($response['message'] != "Rate Limit Issue") $webhook_logs->save_logs($response['status'] ? 1 : 0, $this->db_channel_config, $data, $this->shop, $response['message']);
        }
    }
}
