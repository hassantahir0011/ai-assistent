<?php

namespace App\Http\Controllers;

use App\Entities\CustomerDataRequest;
use App\Entities\WebhookEvent;
use App\Jobs\ProcessShopifyWebhooks;
use App\Services\WebhookLogs;
use Illuminate\Http\Request;
use OpenAI;


class WebhookReceiverController extends Controller
{
    private $webhook_logs;

    public function __construct(WebhookLogs $webhook_logs)
    {
        $this->webhook_logs = $webhook_logs;
    }

    public
    function process_shopify_webhooks(Request $request)
    {
        $event_topic = $request->header('x-shopify-topic');
        $store_domain = $request->header('x-shopify-shop-domain');
        $queue = new ProcessShopifyWebhooks($store_domain, $event_topic, $request->all(), $request->header(), $this->webhook_logs);
        dispatch($queue)->onQueue('webhooks');
        return response()->json(array('success' => true, 'id' => $request->id, 'message' => "received"), 200);

    }

    public
    function customers_redact(Request $request)
    {
        try {

            return response()->json(array('success' => true, 'shop_id' => $request->shop_id, 'message' => "received"), 200);

        } catch (\Exception $e) {

        }

        return response()->json(array('success' => true, 'message' => "received"), 200);

    }

    public
    function shop_redact(Request $request)
    {
        try {

            return response()->json(array('success' => true, 'shop_id' => $request->shop_id, 'message' => "received"), 200);

        } catch (\Exception $e) {

        }

        return response()->json(array('success' => true, 'message' => "received"), 200);

    }

    public
    function customers_data_request(Request $request)
    {
        try {
            $data = new CustomerDataRequest();
            $data->shop_id = $request->shop_id;
            $data->myshopify_domain = $request->shop_domain;
            $data->save();
            return response()->json(array('success' => true, 'shop_id' => $request->shop_id, 'message' => "We'll contact you shortly."), 200);

        } catch (\Exception $e) {
            return response()->json(array('success' => false, 'message' => "error processing your request."), 422);
        }


    }
    function testing(){
        try{
            $yourApiKey = config('openai.api_key');
            \Log::info($yourApiKey);
            $client = OpenAI::client($yourApiKey);

            $result = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => "write a description for my shopify store's product Helmet. We are offering helmet with premium look and colors for their premium rides. description should be of length 750 words"],
                ],
            ]);

            dd($result);
        }
        catch (\Exception $e){
            \Log::info($e->getMessage());
            \Log::info($e->getTraceAsString());
        }
        echo "done";
    }

    public function slugify($text, string $divider = '-')
    {
        // replacing caps with space and small letters
        $text = preg_replace('/(?<!\ )[A-Z]/', ' '.strtolower('$0'), $text);

        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
