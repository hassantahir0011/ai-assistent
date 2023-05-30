<?php

namespace App\Services;

use App\Services\Connectors\PgsqlLibrary;
use Illuminate\Support\Str;

class ProcessWebhooks
{

    private $api_version;
    private $exclude_data_keys;
    public $shop;
    public $values;


    public function __construct($shop)
    {
        $this->exclude_data_keys = ['admin_graphql_api_id'];
        $this->api_version = env('SHOPIFY_API_VERSION') ?? '2019-10';
        $this->shop = $shop;
    }
   /*
     * Previously slack was implemented with incoming webhooks url
     *so notifications were sent via post webhook url method
    * for all users who have registered events with old way will triiger the hooks in same way except those who configured via oauth api later
    */

    public
    function process_drip_connector($config, $event_topic, $shopify_webhook_data, $webhook_event = "")
    {
        $notification_status = false;
        $response_message = $webhook_event . " ID:" . ($shopify_webhook_data['id'] ?? $shopify_webhook_data['inventory_item_id'] ?? $shopify_webhook_data['locale'] ?? 0) . "\n";
        try {
            $channel_event_settings = $config->channel_event_settings;
            if (!$channel_event_settings || !$channel_event = $channel_event_settings->channel_event)
                return ['status' => $notification_status, 'message' => 'No event configuration settings found.Please make sure you have an active webhook registration for this event type.'];
            $channel_account = $channel_event_settings->channel_account;
            if (!$channel_account)
                return ['status' => $notification_status, 'message' =>
                    'No  account or api key details found.Please make sure you have not removed or updated the channel account settings.'
                ];
            $channel_api_library = new \App\Services\Connectors\DripApiLibrary();
            $response = $channel_api_library->trigger_drip_api($channel_account, $channel_event_settings, $shopify_webhook_data, $channel_event);
            $response_message .= $response['message'] ?? ($response_message . 'Unable to perform task.');
            $notification_status = $response['status'] ?? $notification_status;
            if ($response && !$response['status'] && $response['message'] == "Rate Limit Issue")
                return ['status' => $notification_status, 'message' => $response['message'], 'retry_after' => $response['retry_after'] ?? 32];
            else
                return ['status' => $notification_status, 'message' => $response_message];

        } catch (\Exception $e) {
            $response_message .= $e->getMessage();
            return ['status' => false, 'message' => $response_message];

        }

    }
//    private
//    function forward_to_targeted_channel($message_title, $message_body, $channel_config, $channel_name, $access_link = null)
//    {
//        if ($channel_name == 'slack') {
//            $slack_lib = new SlackLibrary();
//            return $slack_lib->send_message($message_title, $message_body, $channel_config);
//        } elseif ($channel_name == 'twilio') {
//            $twilio_lib = new TwilioLibrary();
//            return $twilio_lib->send_message($message_title, $message_body, $channel_config);
//        } elseif ($channel_name == 'mail') {
//            $mail_lib = new MailLibrary();
//            return $mail_lib->send_email($message_title, $message_body, $channel_config, $this->shop, $access_link);
//        } elseif ($channel_name == 'web_push_notification') {
//            $notification_lib = new WebPushNotificationsLibrary();
//            return $notification_lib->send_notification($message_title, $message_body, $channel_config, $this->shop, $access_link);
//        }
//    }

    public
    function trigger_checkouts_notification($channel_config, $event_topic, $data, $channel_name)
    {
        try {
            $notification_status = true;
            if ($channel_config->send_system_defined_notifcation == 1 || empty($channel_config->message_body)) {
                $message_body = '';
                switch ($event_topic) {
                    case "checkouts/create":
                        $message_title = "Dear Merchant,\n A new checkout occured in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "checkouts/update":
                        $message_title = "Dear Merchant,\n checkout has been updated in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "checkouts/delete":
                        $message_title = "Dear Merchant,\n checkout has been deleted in your shopify " . $this->shop->name . " store.\n";
                        break;
                    default:
                        $message_title = "Dear Merchant,\n checkout has been updated in your shopify " . $this->shop->name . " store.\n";
                        break;
                }
                $message_body .= "ID : " . ($data['id'] ?? 0) . "\n";
                if ($event_topic !== "checkouts/delete") {
                    $message_body .= "Email : " . ($data['email'] ?? '') . "\n";
                    $message_body .= "Gateway : " . ($data['gateway'] ?? '') . "\n";
                    $message_body .= "Created At : " . ($data['created_at'] ?? '') . "\n";
                    $message_body .= "Updated At : " . ($data['updated_at'] ?? '') . "\n";
                    $message_body .= "Note  : " . ($data['note'] ?? '') . "\n";
                    $message_body .= "Total Weight : " . ($data['total_weight'] ?? '') . "\n";
                    $message_body .= "Completed At : " . ($data['completed_at'] ?? '') . "\n";
                    $message_body .= "Phone : " . ($data['phone'] ?? '') . "\n";
                    $message_body .= "Source Name : " . ($data['source_name'] ?? '') . "\n";
                    $message_body .= "Total Discounts : " . ($data['total_discounts'] ?? '') . "\n";
                    $message_body .= "Total Line Item Price : " . ($data['total_line_items_price'] ?? '') . "\n";
                    $message_body .= "Total Price : " . ($data['total_price'] ?? '') . "\n";
                    $message_body .= "Total Tax : " . ($data['total_tax'] ?? '') . "\n";
                    $message_body .= "Subtotal Price : " . ($data['subtotal_price'] ?? '') . "\n";
                    if (isset($data['customer']) && !empty($data['customer'])) {
                        $message_body .= "Customer Name: " . $data['customer']['first_name'] ?? '' . $data['customer']['last_name'] ?? '';
                        $message_body .= "\n";
                    }
                    $message_body .= "Total Line Items Count : " . count($data['line_items']);
                }
            } else {
                $shopify_service = new  \App\Services\ShopifyService();
                $message_title = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_title, $data);
                $message_body = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_body, $data);
            }
            // send message to channel
            return $this->forward_to_targeted_channel($message_title, $message_body, $channel_config, $channel_name);

        } catch (\Exception $e) {
            $notification_status = false;
            $response_message = $e->getMessage();
        }
        return ['status' => $notification_status, 'message' => $response_message];

    }

    public
    function trigger_subscription_contract_notification($channel_config, $event_topic, $data, $channel_name)
    {
        try {
            $notification_status = true;
            $response_message = '';
            if ($channel_config->send_system_defined_notifcation == 1 || empty($channel_config->message_body)) {
                $message_body = '';
                switch ($event_topic) {
                    case "subscription_contracts/create":
                        $message_title = "Dear Merchant,\n A new Subscription contract created in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "subscription_contracts/update":
                        $message_title = "Dear Merchant,\n Subscription contract has been updated in your shopify " . $this->shop->name . " store.\n";
                        break;
                    default:
                        $message_title = "Dear Merchant,\n Subscription contract has been updated in your shopify " . $this->shop->name . " store.\n";
                        break;
                }

                $message_body .= "ID : " . ($data['id'] ?? 0) . "\n";
                $message_body .= "Currency Code : " . ($data['currency_code'] ?? '') . "\n";
                $message_body .= "Customer Id : " . ($data['customer_id'] ?? '') . "\n";
                $message_body .= "Status : " . ($data['status'] ?? '') . "\n";
                $message_body .= "Origin Order Id : " . ($data['origin_order_id'] ?? '') . "\n";
                if (!empty($data['billing_policy'])) {
                    $message_body .= "Billing Policy Details: " . "\n";
                    $message_body .= "Interval : " . ($data['billing_policy']['interval'] ?? '') . "\n";
                    $message_body .= "Interval Count : " . ($data['billing_policy']['interval_count'] ?? '') . "\n";
                    $message_body .= "Min Cycles : " . ($data['billing_policy']['min_cycles'] ?? '') . "\n";
                    $message_body .= "Max Cycles : " . ($data['billing_policy']['max_cycles'] ?? '') . "\n";
                }
                if (!empty($data['delivery_policy'])) {
                    $message_body .= "Delivery Policy Details: " . "\n";
                    $message_body .= "Interval : " . ($data['delivery_policy']['interval'] ?? '') . "\n";
                    $message_body .= "Interval Count : " . ($data['delivery_policy']['interval_count'] ?? '') . "\n";
                }
            } else {
                $shopify_service = new  \App\Services\ShopifyService();
                $message_title = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_title, $data);
                $message_body = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_body, $data);
            }
            // send message to channel
            return $this->forward_to_targeted_channel($message_title, $message_body, $channel_config, $channel_name);
        } catch (\Exception $e) {
            $notification_status = false;
            $response_message = $e->getMessage();
        }
        return ['status' => $notification_status, 'message' => $response_message];

    }

    public
    function trigger_cart_notification($channel_config, $event_topic, $data, $channel_name)
    {
        try {
            $notification_status = true;
            $response_message = '';
            if ($channel_config->send_system_defined_notifcation == 1 || empty($channel_config->message_body)) {
                $message_body = '';
                switch ($event_topic) {
                    case "carts/create":
                        $message_title = "Dear Merchant,\n A new Cart created in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "carts/update":
                        $message_title = "Dear Merchant,\n Cart has been updated in your shopify " . $this->shop->name . " store.\n";
                        break;
                    default:
                        $message_title = "Dear Merchant,\n Cart has been updated in your shopify " . $this->shop->name . " store.\n";
                        break;
                }

                $message_body .= "ID : " . ($data['id'] ?? 0) . "\n";
                $message_body .= "Note : " . ($data['note'] ?? '') . "\n";
                $message_body .= "Updated At : " . ($data['created_at'] ?? '') . "\n";
                $message_body .= "Created At : " . ($data['updated_at'] ?? '') . "\n";
                $message_body .= "Line Items Count : " . count($data['line_items']);
            } else {
                $shopify_service = new  \App\Services\ShopifyService();
                $message_title = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_title, $data);
                $message_body = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_body, $data);
            }
            // send message to channel
            return $this->forward_to_targeted_channel($message_title, $message_body, $channel_config, $channel_name);
        } catch (\Exception $e) {
            $notification_status = false;
            $response_message = $e->getMessage();
        }
        return ['status' => $notification_status, 'message' => $response_message];

    }

    public
    function trigger_order_edit_notification($channel_config, $event_topic, $data, $channel_name)
    {
        try {
            $notification_status = true;
            if ($channel_config->send_system_defined_notifcation == 1 || empty($channel_config->message_body)) {
                $message_body = '';
                $message_title = "Dear Merchant,\n Order has been edited in your shopify " . $this->shop->name . " store.\n";
                $message_body .= "ID : " . ($data['id'] ?? 0) . "\n";
                $message_body .= "App ID : " . ($data['app_id'] ?? '') . "\n";
                $message_body .= "Created At : " . ($data['created_at'] ?? '') . "\n";
                $message_body .= "Notify Customer : " . ($data['notify_customer'] ?? '') . "\n";
                $message_body .= "Order Id : " . ($data['order_id'] ?? '') . "\n";
                $message_body .= "Staff Note : " . ($data['staff_note'] ?? '') . "\n";
                $message_body .= "User Id : " . ($data['user_id'] ?? '') . "\n";
                $message_body .= "--------------\n";
                $additions = $data['line_items']['additions'] ?? [];
                $message_body .= "Line Items Additions Count : " . count($additions);
                $removals = $data['line_items']['removals'] ?? [];
                $message_body .= "Line Items Removals Count : " . count($removals);
            } else {
                $shopify_service = new  \App\Services\ShopifyService();
                $message_title = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_title, $data);
                $message_body = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_body, $data);

            }
//            create access link for shopify object like order,product etc
            $access_link = $this->get_shopify_object_access_links($event_topic, $data);
            // send message to channel
            return $this->forward_to_targeted_channel($message_title, $message_body, $channel_config, $channel_name, $access_link);
        } catch (\Exception $e) {
            $notification_status = false;
            $response_message = $e->getMessage();
        }
        return ['status' => $notification_status, 'message' => $response_message];

    }


    public
    function trigger_refunds_notification($channel_config, $event_topic, $data, $channel_name)
    {
        try {
            $notification_status = true;
            if ($channel_config->send_system_defined_notifcation == 1 || empty($channel_config->message_body)) {
                $message_body = '';
                switch ($event_topic) {
                    case "refunds/create":
                        $message_title = "Dear Merchant,\n Customer has been refunded via your shopify " . $this->shop->name . " store.\n";
                        break;
                    default:
                        $message_title = "Unrecognized Request Type.\n";
                        break;
                }
                $message_body .= "ID : " . ($data['id'] ?? 0) . "\n";
                $message_body .= "Order ID : " . ($data['order_id'] ?? '') . "\n";
                $message_body .= "Created At : " . ($data['created_at'] ?? '') . "\n";
                $message_body .= "Note : " . ($data['note'] ?? '') . "\n";
                $message_body .= "Processed At : " . ($data['processed_at'] ?? '') . "\n";
                $message_body .= "Restock : " . ($data['restock'] ?? '') . "\n";
                $message_body .= "Total Refund Line Items : " . count($data['refund_line_items']);
            } else {
                $shopify_service = new  \App\Services\ShopifyService();
                $message_title = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_title, $data);
                $message_body = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_body, $data);
            }
            $access_link = $this->get_shopify_object_access_links($event_topic, $data);
            // send message to channel
            return $this->forward_to_targeted_channel($message_title, $message_body, $channel_config, $channel_name, $access_link);
        } catch (\Exception $e) {
            $notification_status = false;
            $response_message = $e->getMessage();
        }
        return ['status' => $notification_status, 'message' => $response_message];

    }

    public
    function trigger_fulfillment_notification($channel_config, $event_topic, $data, $channel_name)
    {
        try {
            $notification_status = true;
            if ($channel_config->send_system_defined_notifcation == 1 || empty($channel_config->message_body)) {
                $message_body = '';
                switch ($event_topic) {
                    case "fulfillments/create":
                        $message_title = "Dear Merchant,\n Fulfillment added in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "fulfillments/update":
                        $message_title = "Dear Merchant,\n Fulfillment has been updated in your shopify " . $this->shop->name . ".\n";
                        break;
                    default:
                        $message_title = "Dear Merchant,\n Fulfillment has been updated in your " . $this->shop->name . ".\n";
                        break;
                }
                $message_body .= "ID : " . ($data['id'] ?? 0) . "\n";
                $message_body .= "Order ID : " . ($data['token'] ?? '') . "\n";
                $message_body .= "Status : " . ($data['status'] ?? '') . "\n";
                $message_body .= "Service : " . ($data['service'] ?? '') . "\n";
                $message_body .= "Tracking Company : " . ($data['tracking_company'] ?? '') . "\n";
                $message_body .= "Shipment Status : " . ($data['shipment_status'] ?? '') . "\n";
                $message_body .= "Location Id : " . ($data['location_id'] ?? '') . "\n";
                $message_body .= "Email : " . ($data['email'] ?? '') . "\n";
                $message_body .= "Tracking Number : " . ($data['tracking_number'] ?? '') . "\n";
                $message_body .= "Tracking Url : " . ($data['tracking_url'] ?? '') . "\n";
                $message_body .= "Receipt : " . (implode(',', $data['receipt'] ?? [])) . "\n";
                $message_body .= "Name : " . ($data['name'] ?? '') . "\n";
                $message_body .= "Updated At : " . ($data['created_at'] ?? '') . "\n";
                $message_body .= "Created At : " . ($data['created_at'] ?? '') . "\n";
                $message_body .= " Line Items Count : " . count($data['line_items']);
            } else {
                $shopify_service = new  \App\Services\ShopifyService();
                $message_title = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_title, $data);
                $message_body = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_body, $data);
            }
            // send message to channel
            return $this->forward_to_targeted_channel($message_title, $message_body, $channel_config, $channel_name);
        } catch (\Exception $e) {
            $notification_status = false;
            $response_message = $e->getMessage();
        }
        return ['status' => $notification_status, 'message' => $response_message];

    }

    public
    function trigger_post_all_data_obj_notification($channel_config, $event_topic, $data, $channel_name)
    {
        try {
            $notification_status = true;
            $access_link = $this->get_shopify_object_access_links($event_topic, $data);
            if ($channel_config->send_system_defined_notifcation == 1 || empty($channel_config->message_body)) {
                $message_body = '';
                switch ($event_topic) {
                    case "shop/update":
                        $message_title = "Dear Merchant,\n Shop settings has been updated into your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "themes/create":
                        $message_title = "Dear Merchant,\n A new theme has been added in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "themes/publish":
                        $message_title = "Dear Merchant,\n Theme has been published in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "themes/update":
                        $message_title = "Dear Merchant,\n Theme has been updated in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "themes/delete":
                        $message_title = "Dear Merchant,\n Theme has been deleted in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "order_transactions/create":
                        $message_title = "Dear Merchant,\n Order transaction processed in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "locations/create":
                        $message_title = "Dear Merchant,\n A new Location added in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "locations/update":
                        $message_title = "Dear Merchant,\n Location has been updated in your shopify " . $this->shop->name . ".\n";
                        break;
                    case "locations/delete":
                        $message_title = "Dear Merchant,\n Location has been deleted from your " . $this->shop->name . " store.\n";
                        break;
                    case "inventory_items/create":
                        $message_title = "Dear Merchant,\n A new Inventry Item added in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "inventory_items/update":
                        $message_title = "Dear Merchant,\n Inventry Item has been updated in your " . $this->shop->name . ".\n";
                        break;
                    case "inventory_items/delete":
                        $message_title = "Dear Merchant,\n Inventory Item deleted from your " . $this->shop->name . " store.\n";
                        break;
                    case "inventory_levels/connect":
                        $message_title = "Dear Merchant,\n Inventory Level connected into your " . $this->shop->name . " store.\n";
                        break;
                    case "inventory_levels/disconnect":
                        $message_title = "Dear Merchant,\n Inventory Level disconnected into your store.\n";
                        break;
                    case "inventory_levels/update":
                        $message_title = "Dear Merchant,\n Inventory Level updated into your " . $this->shop->name . " store.\n";
                        break;
                    case "customer_groups/create":
                        $message_title = "Dear Merchant,\n A new customer searched/filter saved into your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "customer_groups/update":
                        $message_title = "Dear Merchant,\n customer searched/filter updated in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "customer_groups/delete":
                        $message_title = "Dear Merchant,\n customer searched/filter deleted in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "disputes/create":
                        $message_title = "Dear Merchant,\n A dispute has been created on order into your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "disputes/update":
                        $message_title = "Dear Merchant,\n dispute updated on order in your shopify " . $this->shop->name . " store.\n";
                        break;
                    default:
                        $message_title = "Dear Merchant,\n " . $event_topic . " triggered into your shopify " . $this->shop->name . " store.\n";
                        break;
                }
                foreach ($data as $key => $value):
                    if (!in_array($key, $this->exclude_data_keys)) {
                        if (is_array($value))
                            $value = implode(',', $value);
                        $message_body .= ucwords(str_replace('_', ' ', $key)) . " : " . ($value) . "\n";
                    }
                endforeach;

            } else {
                $shopify_service = new  \App\Services\ShopifyService();
                $message_title = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_title, $data);
                $message_body = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_body, $data);
            }
            // send message to channel
            return $this->forward_to_targeted_channel($message_title, $message_body, $channel_config, $channel_name, $access_link);
        } catch (\Exception $e) {
            $notification_status = false;
            $response_message = $e->getMessage();
        }
        return ['status' => $notification_status, 'message' => $response_message];

    }

    private function get_shopify_object_access_links($event_topic, $data)
    {
        switch ($event_topic) {
            case "shop/update":
                $access_link['label'] = 'View Shop';
                $access_link['link'] = make_domain_url($this->shop->myshopify_domain) . "/admin/settings/general/" . ($data['id'] ?? 0);
                break;
            case "themes/create":
                $access_link['label'] = 'View Theme';
                $access_link['link'] = make_domain_url($this->shop->myshopify_domain) . "/admin/themes/" . ($data['id'] ?? 0);
                break;

            case "themes/publish":
                $access_link['label'] = 'View Theme';
                $access_link['link'] = make_domain_url($this->shop->myshopify_domain) . "/admin/themes/" . ($data['id'] ?? 0);
                break;
            case "themes/update":
                $access_link['label'] = 'View Theme';
                $access_link['link'] = make_domain_url($this->shop->myshopify_domain) . "/admin/themes/" . ($data['id'] ?? 0);
                break;
            case "refunds/create":
            case "orders/edited":
            case "disputes/create":
            case "disputes/update":
                $access_link['label'] = 'View Order';
                $access_link['link'] = make_domain_url($this->shop->myshopify_domain) . "/admin/orders/" . ($data['order_id'] ?? 0);
                break;
            case "collections/create":
            case "collections/update":
                $access_link['label'] = 'View Collection';
                $access_link['link'] = make_domain_url($this->shop->myshopify_domain) . "/admin/collections/" . ($data['id'] ?? 0);
                break;
            case "products/create":
            case "products/update":
                $access_link['label'] = 'View Product';
                $access_link['link'] = make_domain_url($this->shop->myshopify_domain) . "/admin/products/" . ($data['id'] ?? 0);
                break;
            case "customers/create":
            case "customers/update":
                $access_link['label'] = 'View Customer';
                $access_link['link'] = make_domain_url($this->shop->myshopify_domain) . "/admin/customers/" . ($data['id'] ?? 0);
                break;
            case "orders/cancelled":
            case "orders/create":
            case "orders/fulfilled":
            case "orders/paid":
            case "orders/updated":
            case "orders/partially_fulfilled":
                $access_link['label'] = 'View Order';
                $access_link['link'] = make_domain_url($this->shop->myshopify_domain) . "/admin/orders/" . ($data['id'] ?? 0);
                break;
            case "draft_orders/create":
            case "draft_orders/update":
                $access_link['label'] = 'View Draft Order';
                $access_link['link'] = make_domain_url($this->shop->myshopify_domain) . "/admin/draft_orders/" . ($data['id'] ?? 0);
                break;
            default:
                $access_link = null;
                break;
        }
        return $access_link;
    }

    public
    function trigger_tender_transaction_notification($channel_config, $event_topic, $data, $channel_name)
    {
        try {
            $notification_status = true;
            $response_message = 'Unable to send notification';
            if ($channel_config->send_system_defined_notifcation == 1 || empty($channel_config->message_body)) {
                $message_body = '';
                $message_title = "Dear Merchant,\n A new tender transaction has been processed into your shopify " . $this->shop->name . " store.\n";
                foreach ($data as $key => $value):
                    if ($key == 'payment_details') {
                        $message_body .= "Credit Card Number : " . ($value['credit_card_number'] ?? 0) . "\n";
                        $message_body .= "Credit Card Company : " . ($value['credit_card_company'] ?? '') . "\n";
                    } else {
                        $message_body .= ucwords(str_replace('_', ' ', $key)) . " : " . $value . "\n";
                    }
                endforeach;
            } else {
                $shopify_service = new  \App\Services\ShopifyService();
                $message_title = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_title, $data);
                $message_body = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_body, $data);
            }
            // send message to channel
            return $this->forward_to_targeted_channel($message_title, $message_body, $channel_config, $channel_name);
        } catch (\Exception $e) {
            $notification_status = false;
            $response_message = $e->getMessage();
        }
        return ['status' => $notification_status, 'message' => $response_message];
    }

    public
    function trigger_product_or_collection_notification($channel_config, $event_topic, $data, $event_type = 'Product', $channel_name)
    {
        try {
            $notification_status = true;
            $access_link = null;
            $response_message = '';
            if ($channel_config->send_system_defined_notifcation == 1 || empty($channel_config->message_body)) {
                $message_body = '';
                switch ($event_topic) {
                    case "products/create":
                    case "collections/create":
                        $message_title = "Dear Merchant,\n A new " . $event_type . " has been added into your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "products/update":
                    case "collections/update":
                        $message_title = "Dear Merchant,\n " . $event_type . " been updated into your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "products/delete":
                    case "collections/delete":
                        $message_title = "Dear Merchant,\n " . $event_type . " has been deleted in your shopify " . $this->shop->name . ".\n";
                        break;
                    default:
                        $message_title = "Dear Merchant,\n " . $event_type . " has been updated in your shopify.\n";
                        break;
                }
                $message_body .= $event_type . " ID : " . ($data['id'] ?? 0) . "\n";
                if ($event_topic !== 'products/delete' && $event_topic !== 'collections/delete') {
                    $message_body .= "Handle : " . ($data['handle'] ?? '') . "\n";
                    $message_body .= "Title : " . ($data['title'] ?? '') . "\n";
                    $message_body .= "Published At : " . ($data['published_at'] ?? '') . "\n";
                    if ($event_type == 'Product') {
                        $message_body .= "Vendor : " . $data['vendor'] ?? '' . "\n";
                        $message_body .= "Variants Count : " . count($data['variants'] ?? []) . "\n";
                        $message_body .= "Tags : " . ($data['tags'] ?? '') . "\n";
                    }
                    if ($event_type == 'Collection') {
                        $message_body .= "published Scope : " . ($data['published_scope'] ?? '') . "\n";
                        $message_body .= "Body HTML : " . ($data['body_html'] ?? '') . "\n";
                        $message_body .= "Updated At : " . humanDateFormat($data['updated_at'] ?? '') . "\n";
                    }
                }
            } else {
                $shopify_service = new  \App\Services\ShopifyService();
                $message_title = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_title, $data);
                $message_body = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_body, $data);
            }
            // admin access link of shopify object
            $access_link = $this->get_shopify_object_access_links($event_topic, $data);

            // send message to channel
            return $this->forward_to_targeted_channel($message_title, $message_body, $channel_config, $channel_name, $access_link);
        } catch (\Exception $e) {
            $notification_status = false;
            $response_message    = $e->getMessage();
        }
        return ['status' => $notification_status, 'message' => $response_message];
    }

    public
    function trigger_customer_notification($channel_config, $event_topic, $data, $channel_name)
    {
        try {
            $notification_status = true;
            if ($channel_config->send_system_defined_notifcation == 1 || empty($channel_config->message_body)) {
                $response_message = '';
                $message_body = '';
                switch ($event_topic) {
                    case "customers/create":
                        $message_title = "Dear Merchant,\n A new customer has signed up in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "customers/enable":
                        $message_title = "Dear Merchant,\n Customer is enabled with following details in your shopify " . $this->shop->name . ".\n";
                        break;
                    case "customers/disable":
                        $message_title = "Dear Merchant,\n Customer is disabled in your shopify " . $this->shop->name . " with following details.\n";
                        break;
                    case "customers/update":
                        $message_title = "Dear Merchant,\n Customer been updated into your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "customers/delete":
                        $message_title = "Dear Merchant,\n Customer has been deleted in your shopify " . $this->shop->name . " store.\n";
                        break;
                    default:
                        $message_title = "Dear Merchant,\n Customer has been updated in your shopify " . $this->shop->name . " store.\n";
                        break;
                }
                $customer_id = $data['id'] ?? 0;
                $customer_email = $data['email'] ?? '';
                $customer_phone = $data['phone'] ?? '';
                //  $customer_city = $data['city'] ?? '';
                $state = $data['state'] ?? '';
                $message_body .= "Customer ID : " . $customer_id . "\n";
                if ($event_topic !== 'customers/delete') {
                    $customer_name = $data['first_name'] . ' ' . $data['last_name'];
                    $message_body .= "Customer name : " . $customer_name . "\n";
                    $message_body .= "Email : " . $customer_email . "\n";
                    $message_body .= "Phone : " . $customer_phone . "\n";
                    $message_body .= "State : " . $state . "\n";
                }

            } else {
                $shopify_service = new  \App\Services\ShopifyService();
                $message_title = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_title, $data);
                $message_body = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_body, $data);
            }
            $access_link = $this->get_shopify_object_access_links($event_topic, $data);
            // send message to channel
            return $this->forward_to_targeted_channel($message_title, $message_body, $channel_config, $channel_name, $access_link);
        } catch (\Exception $e) {
            $notification_status = false;
        }
        return ['status' => $notification_status, 'message' => $response_message];
    }

    public
    function trigger_order_notification($channel_config, $event_topic, $data, $channel_name)
    {
        try {
            $notification_status = true;
            $is_draft_order = Str::contains($event_topic, 'draft');
            $order_type = $is_draft_order ? 'draft order ' : 'order';
            $response_message = $order_type . 'Update notification sent';
            $order_id = $data['id'] ?? 0;
            $total_price = $data['total_price'] ?? 0;
            $order_status_url = $data['order_status_url'] ?? '';
            $customer_name = !empty($data['customer']) ? $data['customer']['first_name'] . ' ' . $data['customer']['last_name'] : '';
            if ($channel_config->send_system_defined_notifcation == 1 || empty($channel_config->message_body)) {
                $message_body = '';
                switch ($event_topic) {
                    case "orders/create":
                    case "draft_orders/create":
                        $message_title = "Dear Merchant,\n You have received a new " . $order_type . " in your shopify " . $this->shop->name . " store.\n";
                        break;
                    case "orders/fulfilled":
                        $message_title = "Dear Merchant,\n Order fulfilled in your shopify " . $this->shop->name . " store with following details.\n";
                        break;
                    case "orders/cancelled":
                        $message_title = "Dear Merchant,\n Order cancelled in your shopify " . $this->shop->name . " store with following details.\n";
                        break;
                    case "orders/partially_fulfilled":
                        $message_title = "Dear Merchant,\n Order partially fulfilled in your shopify " . $this->shop->name . " store with following details.\n";
                        break;
                    case "orders/paid":
                        $message_title = "Dear Merchant,\n Order payment status is marked to paid in your shopify " . $this->shop->name . "store.\n";
                        break;
                    case "orders/updated":
                    case "draft_orders/updated":
                        $message_title = "Dear Merchant,\n " . $order_type . " has been updated in your shopify " . $this->shop->name . "store .\n";
                        break;
                    case "orders/delete":
                    case "draft_orders/delete":
                        $message_title = "Dear Merchant,\n " . $order_type . " has been deleted in your shopify " . $this->shop->name . " store.\n";
                        break;
                    default:
                        $message_title = "Dear Merchant,\n " . $order_type . " has been updated in your shopify " . $this->shop->name . " store.\n";
                        break;
                }
                $message_body .= Ucfirst($order_type) . "ID :" . $order_id . "\n";
                if ($event_topic !== 'orders/delete' && $event_topic !== 'draft_orders/delete') {
                    $message_body .= "Price " . $total_price . "\n";
                    $message_body .= "Customer name " . $customer_name . "\n";
                    if (!$is_draft_order) {
                        $message_body .= "URL " . $order_status_url;
                    }
                }
            } else {
                $shopify_service = new  \App\Services\ShopifyService();
                $message_title = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_title, $data);
                $message_body = $shopify_service->replace_textarea_shopify_variable_values($channel_config->message_body, $data);
            }
            $access_link = $this->get_shopify_object_access_links($event_topic, $data);
            // send message to channel
            return $this->forward_to_targeted_channel($message_title, $message_body, $channel_config, $channel_name, $access_link);
        } catch (\Exception $e) {
            $notification_status = false;
            $response_message = $e->getMessage();
        }

        return ['status' => $notification_status, 'message' => $response_message];

    }


    public
    function post_shopify_data_to_url($config, $data, $webhook_event = "Product", $headers = [])
    {
        try {
            $notification_status = true;
            $response_message = $webhook_event . " ID:" . ($data['id'] ?? $data['inventory_item_id'] ?? $data['locale'] ?? 0) . "\n";
            $headers = collect($headers)->transform(function ($item) {
                return $item[0];
            });
            $event_topic = $headers['x-shopify-topic'];
            $shop_domain = $headers['x-shopify-shop-domain'];
            $api_version = $headers['x-shopify-api-version'];
            $url = $config->post_url;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//            follow location is throwing exception "Uncaught BadMethodCallException: Method Illuminate\View\View::send does not exist"
//            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                "x-shopify-topic: $event_topic",
                "x-shopify-shop-domain: $shop_domain",
                "x-shopify-api-version: $api_version"

            ]);
            $result = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            $curl_error = curl_errno($ch);

            if ($statusCode != 200) {
                $notification_status = false;
                $response_message .= 'Successfully forwarded data to given URL but server responded with status code <b>' . $statusCode . '</b> while expected was <b>200</b>';
            } elseif ($curl_error) {
                $notification_status = false;
                $response_message .= $curl_error;
            } else {
                $response_message .= 'Request forwarded to url';
            }

            curl_close($ch);
        } catch (\Exception $e) {

            $response_message .= $e->getMessage();
            $notification_status = false;
        }
        return ['status' => $notification_status, 'message' => $response_message];

    }


}