<?php namespace App\Services\Connectors;

class DripApiLibrary
{
    private $shopify_service;
    private $api_url;
    private $api_version;

    function __construct()
    {
        $this->shopify_service = new  \App\Services\ShopifyService();
        $this->api_version = "v2";
        $this->api_url = "https://api.getdrip.com/";
    }


    public
    function isAccessTokenExpired($account)
    {
        if (!$account['access_token'] || !$account['expires_in']) {
            return true;
        }
        // If the token is set to expire in the next 30 seconds.
        return ($account['expires_in'] - 30) < time();
    }

    public
    function get_account_details($request)
    {
        try {
            $api_url = $this->api_url . $this->api_version . "/accounts";
            $client = new \GuzzleHttp\Client();
            $post_array['headers']['Authorization'] = 'Basic ' . base64_encode($request->api_token);
            $post_array['headers']['Content-Type'] = 'application/json';
            $response = $client->request("GET", $api_url, $post_array);

            return json_decode($response->getBody());
        } catch (\Exception $e) {
            return false;
        }
    }

    public
    function get_module_fields($account, $module_name = "")
    {
        $properties = [];
        try {
            $endpoint = "/$module_name/describe.json";
            $request = $this->make_drip_api_call($account, $endpoint, "GET");
            $response = \GuzzleHttp\json_decode($request->getBody());
            if (isset($response->result) && !empty($response->result)) {
                $properties = array_slice($response->result, 0, 100);
            }
        } catch (\Exception $e) {
        }
        return $properties;

    }


    public
    function get_accounts($account, $request)
    {
        $data_array = [];
        try {
            $endpoint = "/accounts";
            $page = 1;
            if (!empty($request->page))
                $page = $request->page;

            if (!empty($request->search))
                $params['search'] = $request->search;
            $response = $this->make_drip_api_call($account, $endpoint, $method = "GET", []);
            $results = json_decode($response->getBody());
            if (isset($results->accounts)) {
                foreach ($results->accounts as $key => $object) {
                    $data_array[$key]['text'] = $object->name . " ( $object->default_from_email )";
                    $data_array[$key]['id'] = $object->id;
                }
                return $results = [
                    "results" => $data_array,
                    "page" => 1,
                    "pagination" => ["more" => false]
                ];
            }
        } catch (\Exception $e) {
        }
        return ['results' => $data_array];

    }

    public
    function get_campaigns($account, $request)
    {
        $data_array = [];
        try {
            $page = 1;
            if (!empty($request->page))
                $page = $request->page;
            if (!empty($request->search))
                $params['search'] = $request->search;
            $endpoint = "/$request->drip_account_id/campaigns?page=$page";
            $response = $this->make_drip_api_call($account, $endpoint, $method = "GET", []);
            $results = json_decode($response->getBody());
            if (isset($results->campaigns)) {
                $meta = $results->meta;
                foreach ($results->campaigns as $key => $object) {
                    $data_array[$key]['text'] = $object->name;
                    $data_array[$key]['id'] = $object->id;
                }
                return $results = [
                    "results" => $data_array,
                    "page" => $meta->page + 1,
                    "pagination" => ["more" => ($meta->total_pages ? $page : false)]
                ];
            }
        } catch (\Exception $e) {
//            \Log::info($e->getMessage());
        }
        return ['results' => $data_array];

    }


    public
    function format_custom_fields_array($post_data_array)
    {
        $custom_fields = [];
        if (isset($post_data_array['custom_field_keys']) && !empty($post_data_array['custom_field_keys'])) {
            foreach ($post_data_array['custom_field_keys'] as $index => $custom_field_key):
                if (isset($post_data_array['custom_field_values'][$index]))
                    $custom_fields[] = [$custom_field_key => $post_data_array['custom_field_values'][$index]];
            endforeach;
        }
        return $custom_fields;
    }

    public
    function trigger_drip_api($account, $drip_event_settings, $shopify_webhook_data, $channel_event)
    {
        try {
            $api_fields = $drip_event_settings->api_fields;
            $post_data_array = [];
            foreach ($api_fields as $api_field_key => $api_field_value):
                if (\Illuminate\Support\Str::contains($api_field_key, '_HiddenTextValue')) {
                    unset($api_fields[$api_field_key]);
                } else {
                    if (is_array($api_field_value)) {
                        $get_values = $this->extract_field_values_from_richtextarea($api_field_value, $shopify_webhook_data);
                        if (!empty($get_values))
                            $post_data_array[$api_field_key] = $get_values;
                    } elseif (!is_null($api_field_value)) {
                        $post_data_array[$api_field_key] = $this->shopify_service->replace_textarea_shopify_variable_values($api_field_value, $shopify_webhook_data, true);
                    }
                }
            endforeach;
            $method = "POST";
            //urls for different drip apis
            switch ($channel_event->slug):
                case "add_or_update_subscriber":
                    $endpoint = "/$drip_event_settings->object_id/subscribers";
                    $response_msg = "Subscriber created or updated successfully";
                    // make required array format
                    $custom_fields = $this->format_custom_fields_array($post_data_array);
                    unset($post_data_array['custom_field_keys']);
                    unset($post_data_array['custom_field_values']);
                    $final_array['subscribers'][] = $post_data_array;
                    if (!empty($custom_fields))
                        $final_array['custom_fields'] = $custom_fields;
                    break;
                case "remove_people_from_campaign":
                    if (!isset($post_data_array['email']) || !$drip_event_settings->object_id)
                        return ['status' => false, 'message' => "Please select account and user email in event setup."];
                    $subscriber_email = $post_data_array['email'];
                    //object_id referes account id of drip
                    $endpoint = "/$drip_event_settings->object_id/subscribers/$subscriber_email/remove";
                    $response_msg = "Request sent to remove subscriber.";
                    $final_array = $post_data_array;
                    break;
                case "add_tag_to_subscriber":
                    if (!$drip_event_settings->object_id)
                        return ['status' => false, 'message' => "Please select account in event setup."];
                    $endpoint = "/$drip_event_settings->object_id/tags";
                    $response_msg = "Tag added to subscriber.";
                    $final_array['tags'][] = $post_data_array;
                    break;
                case "remove_tag_from_subscriber":
                    if (!$drip_event_settings->object_id)
                        return ['status' => false, 'message' => "Please select account in event setup."];
                    $subscriber_email = $post_data_array['email'];
                    $subscriber_tag = $post_data_array['tag'];
                    $endpoint = "/$drip_event_settings->object_id/subscribers/$subscriber_email/tags/$subscriber_tag";
                    $response_msg = "Tag removed from subscriber.";
                    $final_array = [];
                    $method = "DELETE";
                    break;
                case "add_people_to_campaign":
                    if (!$drip_event_settings->object_id)
                        return ['status' => false, 'message' => "Please select account in event setup."];
                    $campaign_id = $post_data_array['campaign_id'];
                    $endpoint = "/$drip_event_settings->object_id/campaigns/$campaign_id/subscribers";
                    $response_msg = "Subscriber added to series successfully.";
                    $final_array['subscribers'][] = $post_data_array;
                    break;


                default:
                    return ['status' => false, 'message' => "No drip event details found."];
                    break;

            endswitch;
//            initiating drip client,basic url is created in drip api call,appending module name in the last
            $make_api_call = $this->make_drip_api_call($account, $endpoint, $method, $final_array);

//            $response_body = json_decode($make_api_call->getBody());
            return ['status' => true, 'message' => $response_msg];


        } catch (\GuzzleHttp\Exception\ClientException $e) {

            if($e->getResponse()->getStatusCode() == 429){
                return ['status' => false, 'message' => "Rate Limit Issue", 'retry_after' => $e->getResponse()->getHeader('Retry-After')[0] ?? 3600];
            }
            $err_arr = \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents(), true);
            $error = $err_arr['errors'][0] ?? [];
            return ['status' => false, 'message' => "GeT Response API Exception- Error Code: " . ($error['code'] ?? "") . " Details: " . ($error['message'] ?? "")];
        } catch
        (\Exception $e) {
            return ['status' => false, 'message' => "Unable to perform operation.Please contact administrator" . "Error Details:" . $e->getMessage()];
        }
    }

    private function parse_api_response_messages($response_body, $response_msg, $message)
    {
        // if api return reason to fail or success response like duplicate lead or lead created
        $result_with_reasons = $response_body->result[0] ?? [];
        if (!empty($result_with_reasons)) {
            if (isset($result_with_reasons->status))
                $response_msg .= "Status : " . $result_with_reasons->status . ".";

            if (isset($result_with_reasons->reasons) && isset($result_with_reasons->reasons[0]->code))
                $response_msg .= "Code : " . $result_with_reasons->reasons[0]->code . ".";
            // message returns in case of duplicate else show custom message as per event type
            if (isset($result_with_reasons->reasons) && isset($result_with_reasons->reasons[0]->message))
                $response_msg .= "Message : " . $result_with_reasons->reasons[0]->message . ".";
            else
                $response_msg .= $message;
        } //if errors response

        else {
            $result_with_errors = $response_body->errors[0] ?? [];
            if (isset($result_with_errors->code))
                $response_msg .= ".Code : " . $result_with_errors->code . ".";
            // message returns in case of duplicate else show custom message as per event type
            if (isset($result_with_errors->message))
                $response_msg .= ".Message : " . $result_with_errors->message . ".";
            else
                $response_msg .= $message;
        }
        return $response_msg;

    }

    private
    function make_drip_api_call($account, $endpoint, $method = "GET", $params = [])
    {
        try {
            $login_credentials = $account->login_credentials;
            $api_url = $this->api_url . $this->api_version . $endpoint;
            $post_array['headers']['Authorization'] = 'Basic ' . base64_encode($login_credentials['api_token']);
            $post_array['headers']['Content-Type'] = 'application/json';

            if (($method == "POST" || $method == "PUT") && !empty($method == "POST" || $method == "PUT")) {
                $post_array['body'] = \GuzzleHttp\json_encode($params);
            }
            $client = new \GuzzleHttp\Client();
            return $client->request($method, $api_url, $post_array);
        }catch (\Exception $e){
//            \Log::info("Exception");
//            \Log::info(print_r($e->getMessage(),true));
        }

    }

    private
    function extract_field_values_from_richtextarea($value_array, $shopify_webhook_data, $return_line_item_index = null)
    {
        $response_array = [];
        foreach ($value_array as $api_field_key => $value):
            if (!is_null($value)) {
                if (is_array($value)) {
                    $response_array_obj = $this->extract_field_values_from_richtextarea($value, $shopify_webhook_data, $return_line_item_index);
                    if (!empty($response_array_obj))
                        $response_array[$api_field_key] = $response_array_obj;
                } else {
                    if (!\Illuminate\Support\Str::contains($api_field_key, '_HiddenTextValue'))
                        $response_array[$api_field_key] = $this->shopify_service->replace_textarea_shopify_variable_values($value, $shopify_webhook_data, true, $return_line_item_index);

                }
            }
        endforeach;
        return $response_array;
    }

}
