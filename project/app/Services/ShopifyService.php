<?php

namespace App\Services;

use App\Entities\PlansHistory;
use App\Entities\StoreWebhook;
use Oseintow\Shopify\Facades\Shopify;
use Session;
use URL;
use App\Entities\Shop;

class ShopifyService
{
    private $api_version;

    public function __construct()
    {
        $this->api_version = config('shopify.api_version');
    }


    public function replace_textarea_shopify_variable_values($text, $shopify_webhook_data, $remove_zero_width_space = true, $return_line_item_index = null)
    {
        // find all occurences of shopify variables in text string and loop them to find their values in real webhooks data
        preg_match_all("/{o=(.*?)}/", $text, $matches);
//   take all shopify variables in array


        $editor_object_and_variables_array = array_combine($matches[0], $matches[1]);

        $shopify_request_key_with_values = [];
        if (!empty($editor_object_and_variables_array)) {

            $array_iterator = new \RecursiveArrayIterator($shopify_webhook_data);
            $iterator_iterator = new \RecursiveIteratorIterator($array_iterator, \RecursiveIteratorIterator::SELF_FIRST);

            //            loop the mapped database columns with shopify data keys
            foreach ($editor_object_and_variables_array as $editor_object => $shopify_variable_key):



                //   loop the webhook data to identify key and get their values to save in database
                $line_item_variables = [];

                foreach ($iterator_iterator as $key => $value) {

                    $keys = array();
                    for ($i = 0; $i < $iterator_iterator->getDepth(); $i++) {

                        if (!is_int($iterator_iterator->getSubIterator($i)->key())) {
                            $keys[] = $iterator_iterator->getSubIterator($i)->key();
                        }
                    }
                    $keys[] = $key;
                    // making array key in same format like value,here we have key=textarea formated variable while
                    //value = shopify webhook object
                    $keys_to_array_formatted_str = array_map(function ($val) {
                        return "[" . $val . "]";
                    }, $keys);
                    // make array format used in rich textarea to distinguish chosen shopify variables e-g [variants][price] or [title]
                    $keys_to_array_formatted_str = implode('', $keys_to_array_formatted_str);
                    if ($shopify_variable_key == $keys_to_array_formatted_str) {
                        // check if its line items shopify variables
                        if (!is_null($return_line_item_index)) {
                            if (is_array($value))
                                $value = $this->implode_recursive("", $value);
                            /* Store all line item values in array and return value for particular index,
                            e-g return 0 index variant or line item price for first variant and 1 index for next
                            */
                            $line_item_variables[] = $value;
                            $shopify_request_key_with_values[$shopify_variable_key] = $line_item_variables[$return_line_item_index] ?? $line_item_variables[0];
                        } else {
                            // check shopify array variables,concatenate all values by comma separated
                            if (array_key_exists($shopify_variable_key, $shopify_request_key_with_values)) {
                                $previous_value = $shopify_request_key_with_values[$shopify_variable_key];
                                if (is_array($value))
                                    $value = $this->implode_recursive(": ", $value);
                                $shopify_request_key_with_values[$shopify_variable_key] = $previous_value . "," . $value;
                                // non array shopify json webhook
                            } else {
                                if (is_array($value))
                                    $value = $this->implode_recursive(": ", $value);
                                //assigning value to array
                                //key=shopify object array ,value=extract value from array
                                // e-g "[variants][price]" => "19.99"
                                $shopify_request_key_with_values[$shopify_variable_key] = $value;

                            }
                        }
                    }

                }
                // if shopify variable exists in text,replace that with actual webhook value
                if (array_key_exists($shopify_variable_key, $shopify_request_key_with_values)) {
                    //replace richtext variable with value of shopify variable array in text area.
                    $text = str_replace($editor_object, $shopify_request_key_with_values[$shopify_variable_key], $text);
                }

            endforeach;
        }
//        remove 0 width space created by text area plugin
        if ($remove_zero_width_space)
            return preg_replace('/[\x{200B}-\x{200D}]/u', '', $text);

        return $text;
    }

    //if shopify variable is array,then concatenate all values by separtor while making a string
    private
    function implode_recursive($separator, $arrayvar)
    {
        $output = "";
        foreach ($arrayvar as $key => $av)
            if (is_array($av))
                $output .= $this->implode_recursive($separator, $av); // Recursive array
            else
                $output .= (!is_int($key) ? $key . $separator : '') . $av . " ";
        return $output;
    }

    public
    function shopify_event_request_fields($array, $leaves_only = false)
    {
        $leafs = [];
        try {
            $array_iterator = new \RecursiveArrayIterator($array);
            $iterator_iterator = new \RecursiveIteratorIterator($array_iterator, $leaves_only ? \RecursiveIteratorIterator::LEAVES_ONLY : \RecursiveIteratorIterator::SELF_FIRST);
            foreach ($iterator_iterator as $key => $value) {
                $keys = array();
                for ($i = 0; $i < $iterator_iterator->getDepth(); $i++) {
                    if (!is_int($iterator_iterator->getSubIterator($i)->key()))
                        $keys[] = $iterator_iterator->getSubIterator($i)->key();
                }
                if (!is_int($key))
                    $keys[] = $key;
                $keys_to_array_formatted_str = array_map(function ($val) {
                    return "[" . $val . "]";
                }, $keys);
                $keys_to_array_formatted_str = implode('', $keys_to_array_formatted_str);
                $is_array=isset( $leafs[$keys_to_array_formatted_str])?true:false;
                $leafs[$keys_to_array_formatted_str] =
                    ucwords(str_replace('_', ' ', implode(' ', $keys))) . (" : ".$value. (is_array($value) || $is_array ? ' [ ] ' :"" )  );
            }
        } catch (\Exception $e) {
        }
        return $leafs;
    }

    public
    function generate_shop_charge_api($shop, $plan_type)
    {
        try {
            $shopUrl = $shop->myshopify_domain;
            $return_url = URL::to('/') . '/' . 'confirm_billing';
            if ($plan_type == 'basic') {
                $shop->current_plan_type = 'basic';
                $shop->is_deleted = 0;
                session()->put('current_plan_type', $shop->current_plan_type);

                // saving plans history
                $plan_history = new PlansHistory();
                $plan_history->shop_id = $shop->shop_id;
                $plan_history->plan_type = $plan_type;
                $plan_history->save();

                if ($shop->charge_status == 'active' && !empty($shop->charge_id)) {
                    try {
                        Shopify::setShopUrl($shop->myshopify_domain)->setAccessToken($shop->access_token)->delete("admin/api/$this->api_version/recurring_application_charges/$shop->charge_id.json");
                        $shop->charge_status = null;
                        $shop->charge_id = null;
                    } catch (\Exception $e) {

                    }
                }
                $shop->save();
                return false;
            } else {
                if ($plan_type == 'professional') {
                    $post_data = array('recurring_application_charge' => array('name' => 'Professional', 'trial_days' => 0, 'price' => config('shopify.professional_plan_price', 5), 'format' => 'json',
                        'return_url' => $return_url, 'test' => config('shopify.app_test_mode', false)));
                } else {
                    $post_data = array('recurring_application_charge' => array('name' => 'Elite', 'trial_days' => 0, 'price' => config('shopify.elite_plan_price', 9), 'format' => 'json',
                        'return_url' => $return_url, 'test' => config('shopify.app_test_mode', false)));
                }
                $res = Shopify::setShopUrl($shop->myshopify_domain)->setAccessToken($shop->access_token)->post("admin/api/$this->api_version/recurring_application_charges.json", $post_data);
                if ($res && isset($res['id'])) {
                    $res['id'] = str_replace('.0', '', $res['id']);
                    $shop = Shop::firstOrNew(array('myshopify_domain' => $shopUrl));
                    $shop->charge_id = $res['id'];
                    $shop->confirmation_url = $res['confirmation_url'];
                    $shop->charge_status = $res['status'];
                    $shop->is_deleted = 0;
                    $shop->save();


                    if (isset($res['confirmation_url']) && !empty($res['confirmation_url'])) {
                        // saving plans history
                        $plan_history = new PlansHistory();
                        $plan_history->shop_id = $shop->shop_id;
                        $plan_history->charge_id = $res['id'];
                        $plan_history->confirmation_url = $res['confirmation_url'];
                        $plan_history->plan_type = $plan_type;
                        $plan_history->charge_status = $res['status'];
                        $plan_history->save();
                        return true;
                    }
                }
            }


        } catch (\Exception $e) {
        }

        return false;


    }

    public
    function verify_webhooks($shop, $topic = null, $callback_url = null)
    {

        $shopUrl = $shop->myshopify_domain;
        $accessToken = $shop->access_token;
        $webhooks = Shopify::setShopUrl($shopUrl)->setAccessToken($accessToken)->get("admin/api/$this->api_version/webhooks.json", ["limit" => 250]);

        $webhook_topic_already_exists = false;
        $webhook_activated = true;
        if ($webhooks && sizeof($webhooks) > 0) {
            $createAppUnistallWebhook = false;
            $str = '';
            foreach ($webhooks as $webhook):
                $str .= $webhook->topic . "\n";
                if ($topic && $callback_url && $webhook->topic == $topic) {
                    $webhook_topic_already_exists = true;
                }
                // use first time on apps installation in store
                if ($webhook->topic == 'app/uninstalled') {
                    $createAppUnistallWebhook = true;
                }

            endforeach;
            // bind webhook to for store on creating new event for any channel
            if ($topic && $callback_url && !$webhook_topic_already_exists) {
                $webhook_activated = $this->create_webhook($shop, $topic, $callback_url);
            }

            // use first time on apps installation in store
            if (!$createAppUnistallWebhook) {
                $is_success = $this->create_webhook($shop, 'app/uninstalled', 'appunistalled_webhook');
                if ($is_success) {
                    $shop->is_webhooks_added = 1;
                    $shop->save();
                }

            }

        } else {
            // bind webhook to for store on creating new event for any channel
            if ($topic && $callback_url) {
                $webhook_activated = $this->create_webhook($shop, $topic, $callback_url);
            }
//            create webhooks forapp removing
            $is_success = $this->create_webhook($shop, 'app/uninstalled', 'appunistalled_webhook');
            if ($is_success) {
                $shop->is_webhooks_added = 1;
                $shop->save();
            }
        }

        return $webhook_activated;

    }

    private
    function create_webhook($shop, $type, $callbacK_url)
    {
        $shopUrl = $shop->myshopify_domain;
        $accessToken = $shop->access_token;
        $callbacK_url = URL::to('/') . '/' . $callbacK_url;
        $post_data = array('webhook' => array('topic' => $type, 'address' => $callbacK_url, 'format' => 'json'));
        try {
            $webhook = Shopify::setShopUrl($shopUrl)->setAccessToken($accessToken)->post("admin/api/$this->api_version/webhooks.json", $post_data);
            return true;
        } catch (\Exception $e) {
            return false;

        }
    }

    public
    function remove_single_webhook($shop, $topic_name)
    {
        $accessToken = $shop['access_token'];
        $shopUrl = $shop['myshopify_domain'];
        $webhooks = Shopify::setShopUrl($shopUrl)->setAccessToken($accessToken)->get("admin/api/$this->api_version/webhooks.json");
        if ($webhooks && sizeof($webhooks) > 0) {
            foreach ($webhooks as $webhook):
                if ($webhook->topic == $topic_name) {
                    $webhook_id = $webhook->id;
                    try {
                        Shopify::setShopUrl($shopUrl)->setAccessToken($accessToken)->delete("admin/api/$this->api_version/webhooks/$webhook_id.json");
                    } catch (\Exception $e) {
                        return false;
                    }

                }
            endforeach;
            return true;
        }
        return true;
    }


    public
    function filter_webhook_conditions_str_format($execution_conditions)
    {
        try {
            $execution_conditions = \GuzzleHttp\json_decode($execution_conditions);
            $condition = $this->get_logical_operator($execution_conditions->condition);
            $rules = $execution_conditions->rules;
            $condition_str = 'return (';
            $concatenate_multiple_conditions = $this->concatenate_multiple_conditions($rules, $condition);
            $condition_str .= $concatenate_multiple_conditions;
            $condition_str .= ');';
            return $condition_str;
        } catch (\Exception $e) {
            return '';
        }

    }

    public
    function concatenate_multiple_conditions($rules, $condition)
    {
        $condition_str = '';
        foreach ($rules as $rule_key => $rule):
            if (isset($rule->rules) && is_array($rule->rules)) {
                $condition_str .= ' (';
                $condition_str .= $this->concatenate_multiple_conditions($rule->rules, $this->get_logical_operator($rule->condition));
                $condition_str .= ') ';
            } else {
                if ($rule->operator == 'contains') {
                    $condition_str .= $this->get_mathematical_operator($rule->operator, ("$" . $rule->id), $rule->value);
                } else {
                    $condition_str .= "$" . $rule->id . $this->get_mathematical_operator($rule->operator, $rule->id, $rule->value) . "'$rule->value'";
                }
            }
            if ($rule_key != (sizeof($rules) - 1)):
                $condition_str .= ' ' . $condition . ' ';
            endif;
        endforeach;
        return $condition_str;
    }

    public
    function get_logical_operator($operator)
    {
        switch ($operator) {
            case 'OR':
                return ' || ';
                break;
            case 'AND':
                return ' && ';
                break;
            default:
                return '';


        }
    }

    public
    function get_mathematical_operator($operator, $variable_name = null, $value = null)
    {

        switch ($operator) {
            case 'equal':
                return ' == ';
                break;
            case 'not_equal':
                return ' != ';
                break;
            case 'less':
                return ' < ';
                break;
            case 'greater':
                return ' > ';
                break;
            case 'greater_or_equal':
                return ' >= ';
                break;
            case 'less_or_equal':
                return ' <= ';
                break;
            case 'contains':
                //preg_match("/{$search}/i", $value)
                return ' preg_match("/{' . $variable_name . '}/i",' . "'$value'" . ") ";
                break;
            default:
                return '';


        }
    }


    public
    function execution_condition_php($execution_conditions)
    {
        $operators = array('equal' => "=",
            'not_equal' => "!=",
            'in' => "IN (?)",
            'not_in' => "NOT IN (_REP_)",
            'less' => "<",
            'less_or_equal' => "<=",
            'greater' => ">",
            'greater_or_equal' => ">=",
            'begins_with' => "ILIKE",
            'not_begins_with' => "NOT ILIKE",
            'contains' => "ILIKE",
            'not_contains' => "NOT ILIKE",
            'ends_with' => "ILIKE",
            'not_ends_with' => "NOT ILIKE",
            'is_empty' => "=''",
            'is_not_empty' => "!=''",
            'is_null' => "IS NULL",
            'is_not_null' => "IS NOT NULL");

        $jsonResult = array("data" => array());
        $getAllResults = false;
        $conditions = null;
        $result = "";
        $params = array();
        $conditions = json_decode(utf8_encode($execution_conditions), true);

        if (!array_key_exists('condition', $conditions)) {
            $getAllResults = true;
        } else {

            $global_bool_operator = $conditions['condition'];

            // i contatori servono per evitare di ripetere l'operatore booleano
            // alla fine del ciclo se non ci sono più condizioni
            $counter = 0;
            $total = count($conditions['rules']);

            foreach ($conditions['rules'] as $index => $rule) {
                if (array_key_exists('condition', $rule)) {
                    $result .= $this->parseGroup($rule, $params);
                    $total--;
                    if ($counter < $total)
                        $result .= " $global_bool_operator ";
                } else {
                    $result .= $this->parseRule($rule, $params);
                    $total--;
                    if ($counter < $total)
                        $result .= " $global_bool_operator ";
                }
            }
        }

        return $result;
    }

    /**
     * Parse a group of conditions */
    function parseGroup($rule, &$param)
    {
        $parseResult = "(";
        $bool_operator = $rule['condition'];
        // counters to avoid boolean operator at the end of the cycle
        // if there are no more conditions
        $counter = 0;
        $total = count($rule['rules']);

        foreach ($rule['rules'] as $i => $r) {
            if (array_key_exists('condition', $r)) {
                $parseResult .= "\n" . $this->parseGroup($r, $param);
            } else {
                $parseResult .= $this->parseRule($r, $param);
                $total--;
                if ($counter < $total)
                    $parseResult .= " " . $bool_operator . " ";
            }
        }

        return $parseResult . ")";
    }

    /**
     * Parsing of a single condition */
    function parseRule($rule, &$param)
    {

        global $fields, $operators;

        $parseResult = "";
        $parseResult .= $fields[$rule['id']] . " ";
        $param[] = array($rule['type'][0] => $rule['value']);
        $parseResult .= $operators[$rule['operator']] . " ?";

        return $parseResult;
    }


}
