<?php

namespace App\Http\Controllers;

use App\Entities\ChannelConfig;
use App\Http\Requests\TestWebhooksRequest;
use App\Services\ProcessCartWebhooksLib;
use App\Services\ProcessCheckoutsWebhooksLib;
use App\Services\ProcessCollectionWebhooksLib;
use App\Services\ProcessCustomerSavedSearchWebhooksLib;
use App\Services\ProcessCustomersWebhooksLib;
use App\Services\ProcessDisputeWebhooksLib;
use App\Services\ProcessFulfillmentEventsWebhooksLib;
use App\Services\ProcessFulfillmentsWebhooksLib;
use App\Services\ProcessInventoryItemLevelWebhooksLib;
use App\Services\ProcessLocationWebhooksLib;
use App\Services\ProcessOrderEditWebhooksLib;
use App\Services\ProcessOrderTransactionsWebhooksLib;
use App\Services\ProcessOrderWebhooksLib;
use App\Services\ProcessProductsWebhooksLib;
use App\Services\ProcessRefundsWebhooksLib;
use App\Services\ProcessShopAlternateLocaleWebhooksLib;
use App\Services\ProcessShopWebhooksLib;
use App\Services\ProcessSubscriptionContractWebhooksLib;
use App\Services\ProcessTenderTransactionsWebhooksLib;
use App\Services\ProcessThemeWebhooksLib;


class TestWebhooksController extends Controller
{
    public function test_registered_webhook(TestWebhooksRequest $request)
    {
        try {
            $shop = session('shop');
            $channel_config = ChannelConfig::where('id', $request->config_id)->where('shop_id', $shop['shop_id'])->first();
            if (!$channel_config)
                return response()->json(array('status' => false, 'message' => 'Unable to find event detail.Make sure you have setup event successfully.Follow the guide for further details.'));

            $webhook_topic = $channel_config->webhook_topic;
            $event_topic = $webhook_topic->topic_name;
            $event = $webhook_topic->event;
            $event_name = $event->event_name;
//            set headers,same header format as sent by shopify
            $headers = [];
            $headers['x-shopify-topic'] = [$event_topic];
            $headers['x-shopify-shop-domain'] = [$shop['myshopify_domain']];
            $headers['x-shopify-api-version'] = [env('SHOPIFY_API_VERSION', '2020-04')];
            // get sample webhook data in php array format stored in config files
            $sample_webhooks_data = config("sample_webhooks_data.$event_name");
            switch ($event_name) {
                case "Customer":
                    $process_webhook = new ProcessCustomersWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "Cart":
                    $process_webhook = new ProcessCartWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "Checkout":
                    $process_webhook = new ProcessCheckoutsWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "Collection":
                    $process_webhook = new ProcessCollectionWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "CustomerSavedSearch":
                    $process_webhook = new ProcessCustomerSavedSearchWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "DraftOrder":
                    $process_webhook = new ProcessOrderWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "Fulfillment":
                    $process_webhook = new ProcessFulfillmentsWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "FulfillmentEvent":
                    $process_webhook = new ProcessFulfillmentEventsWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "InventoryItem":
                    $process_webhook = new ProcessInventoryItemLevelWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "InventoryLevel":
                    $process_webhook = new ProcessInventoryItemLevelWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "Location":
                    $process_webhook = new ProcessLocationWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "Order":
                    $process_webhook = new ProcessOrderWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "OrderTransaction":
                    $process_webhook = new ProcessOrderTransactionsWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "Product":
                    $process_webhook = new ProcessProductsWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "Refund":
                    $process_webhook = new ProcessRefundsWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "Shop":
                    $process_webhook = new ProcessShopWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "TenderTransaction":
                    $process_webhook = new ProcessTenderTransactionsWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "Theme":
                    $process_webhook = new ProcessThemeWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "OrderEdit":
                    // add property order_edit as its been updated in sample sheet but exists in original webhook
                    $altered_array_structure['order_edit']=$sample_webhooks_data;
                    $process_webhook = new ProcessOrderEditWebhooksLib($channel_config, $altered_array_structure, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "ShopAlternateLocale":
                    $process_webhook = new ProcessShopAlternateLocaleWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "SubscriptionContract":
                    $process_webhook = new ProcessSubscriptionContractWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                case "Dispute":
                    $process_webhook = new ProcessDisputeWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = true);
                    return $process_webhook->trigger();
                    break;
                default:
                    return response()->json(array('status' => false, 'message' => 'No test webhook event found'));
                    break;
            }

        } catch (\Exception $e) {
            return response()->json(array('status' => false, 'message' => $e->getMessage()));
        }
    }


}
