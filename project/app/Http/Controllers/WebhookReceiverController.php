<?php

namespace App\Http\Controllers;

use App\Entities\CustomerDataRequest;
use App\Entities\Shop;
use App\Entities\WebhookEvent;
use App\Jobs\ProcessShopifyWebhooks;
use App\Services\WebhookLogs;
use Illuminate\Http\Request;
use OpenAI;
use GuzzleHttp\Client;


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
//            $shop = Shop::where('shop_id', 57502138441)->first();
//            dd($shop->purchased_text_processed_jobs->sum('tokens'), ((($shop->purchased_text_processed_jobs->sum('tokens') + config('shopify.trial_text_token')) ?? 0) % 1000));
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();

            $daysOfMonth = [];
            $tokenUsage = [];
            $currentDate = clone $startDate;

            while ($currentDate <= $endDate) {
                $day = $currentDate->format('j');
                $daysOfMonth[] = $day;
                $tokenUsage[$day] = 0;
                $currentDate->modify('+1 day');
            }

            $data = \DB::table('processed_jobs')
                ->select(
                    \DB::raw('EXTRACT(DAY FROM created_at) as day'),
                    \DB::raw('SUM(tokens) as total_tokens')
                )
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->where('media_type', '=', 'text')
                ->where('transaction_type', '=', 'credit')
                ->groupBy('day')
                ->orderBy('day')
                ->get();

            foreach ($data as $item) {
                $day = $item->day;
                $totalTokens = $item->total_tokens;
                $tokenUsage[$day] = $totalTokens;
            }

            $dataset = [];

            foreach ($daysOfMonth as $day) {
                $dataset[] = [
                    'day' => (string)$day,
                    'value' => $tokenUsage[$day]
                ];
            }


            dd(json_encode($dataset));
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
