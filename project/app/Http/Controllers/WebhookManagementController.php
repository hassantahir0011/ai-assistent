<?php

namespace App\Http\Controllers;

use App\Entities\ChannelAccount;
use App\Entities\ChannelConfig;
use App\Entities\ChannelEventSetting;
use App\Entities\FavoriteConnectorWithWebhookEvent;
use App\Entities\Shop;
use App\Entities\WebhookEvent;
use App\Entities\WebhookLog;
use App\Entities\PlansHistory;
use App\Entities\WebhookTopic;
use Illuminate\Http\Request;
use App\Services\ShopifyService;
use App\Http\Requests\StoreGeneralEventRequest;
use App\Http\Requests\RetryFailedWebhooksRequest;
use Session;
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
use App\Services\WebhookLogs;
use Carbon\Carbon;
use GuzzleHttp\Client;

class WebhookManagementController extends Controller
{
    private $shopify_service;

    public function __construct(ShopifyService $shopify_service, WebhookLogs $webhook_logs)
    {
        $this->shopify_service = $shopify_service;
        $this->webhook_logs = $webhook_logs;
    }

    public
    function update_event_status(Request $request, $id)
    {
        $shop = session('shop');
        $shop_id = $shop['shop_id'];
        $config = ChannelConfig::where('id', $id)->where('shop_id', $shop_id)->first();
        if (!$config || !isset($request->status)) {
            return response()->json(array('status' => 'error', 'message' => 'Unable to update status'));
        }
        $webhook_topic = $config->webhook_topic;
        if ($request->status == 1) {
            $bound_webhook_for_this_event = $this->shopify_service->verify_webhooks($shop, $webhook_topic->topic_name, $webhook_topic->webhook_topic_url);

            if ($bound_webhook_for_this_event) {
                $config->status = 1;
                $config->save();
                return response()->json(array('status' => 'success', 'message' => 'Updated successfully'));
            } else {
                $config->status = 0;
                $config->save();
                return response()->json(array('status' => 'error', 'message' => 'Unable to register webhook at the moment'));
            }
        } else {
            $config->status = 0;
            $config->save();
            $is_active_any_other_configured_hook = ChannelConfig::where('webhook_topic_id', $webhook_topic->id)
                ->where('shop_id', $shop_id)
                ->where('status', 1)
                ->count();

            if ($is_active_any_other_configured_hook == 0) {
                // disable previous webhook if activated/enabled
                $this->shopify_service->remove_single_webhook($shop, $webhook_topic->topic_name);
            }
            return response()->json(array('status' => 'success', 'message' => 'Updated successfully'));
        }


    }

    public
    function delete_registered_webhook($id)
    {
        $shop = session('shop');
        $shop_id = $shop['shop_id'];
        if (!$shop || !$id || empty($id)) {
            return response()->json(array('status' => 'error', 'message' => 'Unable to delete webhook'));
        }
        $config = ChannelConfig::where('id', $id)->where('shop_id', $shop_id)->first();
        if (!$config) {
            return response()->json(array('status' => 'error', 'message' => 'No record found.'));
        }
        $webhook_topic = $config->webhook_topic;
        $channel = $config->channel;
        if ($channel && $channel->name == 'microsoft_excel_sheet')
            MsExcelSetting::where('channel_config_id', $id)->delete();
        else
            ChannelEventSetting::where('channel_config_id', $id)->delete();

        // delete the db table config row
        ChannelConfig::where('id', $id)->where('shop_id', $shop_id)->delete();


        //check if any other configs available for this topic name othereise unbound shopify webhooks
        $is_active_any_other_configured_hook = ChannelConfig::where('webhook_topic_id', $webhook_topic->id)
            ->where('shop_id', $shop_id)
            ->where('status', 1)
            ->count();
        if ($is_active_any_other_configured_hook == 0) {
            // disable previous webhook if activated/enabled
            $this->shopify_service->remove_single_webhook($shop, $webhook_topic->topic_name);
        }
        return response()->json(array('status' => 'success', 'message' => 'deleted successfully'));

    }


    public function index()
    {
        $shop = session('shop');
        $shop = Shop::where('shop_id', $shop->shop_id)
            ->first();
        $webhook_events = WebhookEvent::select('webhook_events.*')
            ->where('webhook_events.is_active', 1)
            ->orderBy('order', 'desc')
            ->get();
        $processed_webhooks = $shop->processed_jobs()->count();
        $allowed_webhooks_tasks = allowed_webhooks_tasks($shop->current_plan_type);
        $favorites = FavoriteConnectorWithWebhookEvent::all()->shuffle()->take(5);

        $register_webhook_query = ChannelConfig::where('shop_id', $shop->shop_id)
            ->join('webhook_topics', 'channel_configs.webhook_topic_id', '=', 'webhook_topics.id', 'inner')
            ->join('webhook_events', 'webhook_topics.webhook_event_id', '=', 'webhook_events.id', 'inner')
            ->select('channel_configs.*', 'webhook_topics.webhook_event_id','webhook_topics.topic_name', 'webhook_events.event_name as webhook_event_name', 'webhook_events.slug as webhook_event_slug');
        $register_webhooks = $register_webhook_query->latest('channel_configs.updated_at')->get()->take(5);

        $plan_history = PlansHistory::where('shop_id', $shop->shop_id)->where('charge_status', 'active')->latest()->first();
        if($plan_history) {
            $months_diff = Carbon::parse($plan_history->updated_at)->diffInMonths(Carbon::now()) + 1;
            $plan_history_next_date = Carbon::parse($plan_history->updated_at)->addMonthsNoOverflow($months_diff)->toFormattedDateString();
        }
        else {
            $months_diff = Carbon::parse($shop->created_at)->diffInMonths(Carbon::now()) + 1;
            $plan_history_next_date = Carbon::parse($shop->created_at)->addMonthsNoOverflow($months_diff)->toFormattedDateString();
        }
        return view('webhook_management', compact('webhook_events', 'processed_webhooks', 'allowed_webhooks_tasks', 'shop', 'plan_history', 'plan_history_next_date', 'favorites', 'register_webhooks'));

    }

    public function webhookSettings()
    {
        $shop = session('shop');
        $shop = Shop::where('shop_id', $shop->shop_id)
            ->first();
        $webhook_events = WebhookEvent::select('webhook_events.*')
            ->where('webhook_events.is_active', 1)
            ->orderBy('order', 'desc')
            ->get();
        $favorites = FavoriteConnectorWithWebhookEvent::all()->shuffle();
        return view('webhook_management_all', compact('webhook_events', 'shop', 'favorites'));

    }

    public function getFavorites(Request $request){
        $favorites = FavoriteConnectorWithWebhookEvent::all()->shuffle();
        $response = "";
        foreach ($favorites as $favorite){
            if($request->channel_category_id == "" || $favorite->channel->channel_category_id == $request->channel_category_id){
                $response .= "<div class=\"card horizontally\">
                                <div class=\"card-body\">
                                    <ul class=\"icon-list small\">
                                        <li>
                                            <div class=\"icon-box\">
                                                <img src=\"https://appscorridor.com/webhook_setup_stage/css/appdesign/images/shopify-img.png\">
                                            </div>
                                        </li>
                                        <li>
                                            <div class=\"icon-box\">
                                                <img src=".$favorite->channel->icon_path.">
                                            </div>
                                        </li>
                                    </ul>
                                    <p>$favorite->message in <a href=\"#\">".$favorite->channel->name."</a> </p>
                                    <a href=".route('channel_config', [$favorite->channel->slug, $favorite->webhook_event->slug])." class=\"btn \">Try it</a>
                                </div>
                            </div>";
            }
        }
        return $response;
    }

    public
    function delete_logs(Request $request)
    {
        $shop = session('shop');
        $ids = $request->log_ids;

        if (!$shop || !$ids || empty($ids)) {
            return response()->json(array('status' => 'error', 'message' => 'Unable to delete logs'));
        }
        $shop_id = $shop['shop_id'];

        WebhookLog::whereIn('id', $ids)->where('shop_id', $shop_id)->delete();
        return response()->json(array('status' => 'success', 'message' => 'deleted successfully'));

    }

    public function products()
    {
        return view('logs.webhook_logs');
    }

    public function product(Request $request)
    {
        if(!$request->id) return redirect()->back();
        $shop = session('shop');
        try {
            $client = new Client([
                'base_uri' => 'https://' . $shop['myshopify_domain'] . '/admin/api/2023-01/',
                'headers' => [
                    'X-Shopify-Access-Token' => $shop['access_token'],
                    'Content-Type' => 'application/json',
                ],
            ]);
            $url = "products/$request->id.json";
            $response = $client->request('GET', $url);

            // Extract the data from the response body
            $product = json_decode($response->getBody(), true);
            $product = $product['product'] ?? [];
            return view('logs.product', compact('product'));
        }
        catch (\Exception $e){
            \Log::info($e->getMessage());
            return json_encode(array('data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0));
        }
    }

    public function update_product(Request $request)
    {
        if(!$request->id || !$request->body_html) return response()->json(['code' => 400, 'status' => 'error',
            'message' => "Missing required data"
        ], 400);
        $shop = session('shop');
        try {
            $client = new Client([
                'base_uri' => 'https://' . $shop['myshopify_domain'] . '/admin/api/2023-01/',
                'headers' => [
                    'X-Shopify-Access-Token' => $shop['access_token'],
                    'Content-Type' => 'application/json',
                ],
            ]);
            $url = "products/$request->id.json";
            $data['body'] = json_encode(["product" => ["body_html" => $request->body_html]]);
            $response = $client->request('PUT', $url, $data);

            // Extract the data from the response body
            $product = json_decode($response->getBody(), true);
            $product = $product['product'] ?? [];
            return response()->json(['code' => 200, 'status' => 'success',
                'message' => "$product[title] updated successfully"
            ], 200);
        }
        catch (\Exception $e){
            \Log::info($e->getMessage());

            return response()->json(['code' => 500, 'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function upload_images(Request $request)
    {
        if(!$request->id || !$request->selected_images) return response()->json(['code' => 400, 'status' => 'error',
            'message' => "Missing required data"
        ], 400);
        $shop = session('shop');
        try {
            $client = new Client([
                'base_uri' => 'https://' . $shop['myshopify_domain'] . '/admin/api/2023-01/',
                'headers' => [
                    'X-Shopify-Access-Token' => $shop['access_token'],
                    'Content-Type' => 'application/json',
                ],
            ]);
            $url = "products/$request->id.json";
            $images = [];
            if($request->existing_images) foreach (explode(',', $request->existing_images) as $img_id) $images[] = ["id" => $img_id];
            foreach ($request->selected_images as $img_src) $images[] = ["src" => $img_src];
            $data['body'] = json_encode(["product" => ["images" => $images]]);
            $response = $client->request('PUT', $url, $data);

            // Extract the data from the response body
            $product = json_decode($response->getBody(), true);
            $product = $product['product'] ?? [];
            return response()->json(['code' => 200, 'status' => 'success',
                'message' => "$product[title] updated successfully"
            ], 200);
        }
        catch (\Exception $e){
            \Log::info($e->getMessage());

            return response()->json(['code' => 500, 'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function generate_images(Request $request)
    {
        if(!$request->id || !$request->title || !$request->body_html) return response()->json(['code' => 400, 'status' => 'error',
            'message' => "Missing required data"
        ], 400);
        $shop = session('shop');
        try {
            $client = new Client([
                'base_uri' => 'https://stablediffusionapi.com/api/v3/',
                'headers' => [
                    'X-Shopify-Access-Token' => $shop['access_token'],
                    'Content-Type' => 'application/json',
                ],
            ]);
            $req_body = [
                "key" => "mpAf2QJ39xunisE4Z3PsRnxIWI6pYLmebtKKvRflNhNGiofVWI5KwTWsKBJb",
                "prompt" => "ultra realistic close up portrait for a product ( Title ($request->title) and Description (".strip_tags($request->body_html)."))",
                "negative_prompt" => null,
                "width" => "512",
                "height" => "512",
                "samples" => $request->samples ?? "3",
                "num_inference_steps" => "20",
                "seed" => null,
                "guidance_scale" => 7.5,
                "safety_checker" => "yes",
                "multi_lingual" => "no",
                "panorama" => "no",
                "self_attention" => "no",
                "upscale" => "no",
//                    "embeddings_model" => "embeddings_model_id",
                "webhook" => null,
                "track_id" => null
            ];
            if(!$request->img_src) $url = "text2img";
            else{
                $url = "img2img";
                $req_body += ["init_image" =>  $request->img_src];
            }
            $data['body'] = json_encode($req_body);
            $response = $client->request('POST', $url, $data);

            // Extract the data from the response body
            \Log::info($data['body']);
            \Log::info($response->getBody());
            $response = json_decode($response->getBody(), true);
            if($response['status']){
                return response()->json(['code' => 200, 'status' => 'success',
                    'message' => "Imgaes created successfully", "output" => $response['output']
                ], 200);
            }

            $product = $product['product'] ?? [];
            return response()->json(['code' => 200, 'status' => 'error',
                'message' => $response['message'], "tip" => $response['tip']
            ], 200);
        }
        catch (\Exception $e){
            \Log::info($e->getMessage());

            return response()->json(['code' => 500, 'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public
    function store_logs(Request $request){
        $shop = session('shop');
        try {
            $client = new Client([
                'base_uri' => 'https://' . $shop['myshopify_domain'] . '/admin/api/2023-01/',
                'headers' => [
                    'X-Shopify-Access-Token' => $shop['access_token'],
                    'Content-Type' => 'application/json',
                ],
            ]);

            $url = 'products/count.json';

            $response = $client->request('GET', $url);
            $products_count = json_decode($response->getBody(), true);
            $products_count = $products_count['count'] ?? 0;

            if ($products_count > 0) {
                $url = 'products.json?fields=id%2Ctitle%2Cimage';

                if (!empty($_REQUEST['sSearch'])) {
                    session()->put('storeLogSearch', $_REQUEST['sSearch']);
                    $search = $_REQUEST['sSearch'];
                    $url .= '&ids=' . $search;
                } else {
                    session()->forget('storeLogSearch');
                }

                if ($_REQUEST['iDisplayLength']) {
                    $limit = $_REQUEST['iDisplayLength'];
                    $url .= '&limit=' . $limit;
                }

                if ($_REQUEST['iDisplayStart']) {
                    $offset = $_REQUEST['iDisplayStart'];
                    (session()->get('storeLogDisplayStart') ?? 0) < $offset ? $url .= '&page_info=' . $_REQUEST['nextPageInfo'] : $url .= '&page_info=' . $_REQUEST['previousPageInfo'];
                    session()->put('storeLogDisplayStart', $_REQUEST['iDisplayStart']);
                } else {
                    session()->forget('storeLogDisplayStart');
                }
                $response = $client->request('GET', $url);

                // Extract the page_info for the next page from the Link header (if available)
                $linkHeader = $response->getHeader('Link')[0] ?? "";
                $links = explode(',', $linkHeader);

                $nextLink = null;
                $previousLink = null;

                foreach ($links as $link) {
                    if (strpos($link, 'rel="next"') !== false) {
                        $nextLink = $link;
                    }
                    if (strpos($link, 'rel="previous"') !== false) {
                        $previousLink = $link;
                    }
                }
                if (preg_match('/page_info=([^>]*)>/', $nextLink, $matches)) {
                    $nextPageInfo = isset($matches[1]) ? $matches[1] : null;
                } else {
                    $nextPageInfo = '';
                }
                if (preg_match('/page_info=([^>]*)>/', $previousLink, $matches)) {
                    $previousPageInfo = isset($matches[1]) ? $matches[1] : null;
                } else {
                    $previousPageInfo = '';
                }

                // Extract the data from the response body
                $products = json_decode($response->getBody(), true);
                $products = $products['products'] ?? [];

                $data = [];
                if (count($products) > 0) {
                    $serial = $_REQUEST['iDisplayStart'];
                    foreach ($products as $row):
                        $serial++;
                        $obj = new \stdClass;
                        $obj->serial_no = $serial;
                        $obj->id = $row['id'];
                        $obj->title = $row['title'];
                        $obj->image_url = $row['image']['src'] ?? env('APP_URL')."/css/appdesign/images/shopify-img.png";
                        $data[] = $obj;
                    endforeach;
                }
                return json_encode(array('data' => $data, 'recordsTotal' => count($products), 'recordsFiltered' => $products_count, 'previousPageInfo' => $previousPageInfo, 'nextPageInfo' => $nextPageInfo));
            }
            return json_encode(array('data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0));
        }
        catch (\Exception $e){
            \Log::info($e->getMessage());
            return json_encode(array('data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0));
        }
    }


    public function store_general_event_config(StoreGeneralEventRequest $request)
    {

        try {
            $shop = session('shop');
            $webhook_topic = WebhookTopic::find($request->webhook_topic_id);

            if (!$webhook_topic) {
                Session::flash('message', 'No details Found');
                return redirect()->route('dashboard');
            }
            $config = new ChannelConfig();
            $config->webhook_topic_id = $request->webhook_topic_id;
            $config->post_url = $request->post_url ?? "";
            $config->description = $request->description;
            $config->execution_conditions = $request->execution_conditions;
            $config->send_system_defined_notifcation = ($request->send_system_defined_notifcation ?? 0);
            $config->message_title = $request->message_title;
            $config->message_body = $request->message_body;
            $config->shop_id = $shop['shop_id'];
            if (isset($request->status) && $request->status == 'enabled') {
                $bound_webhook_for_this_event = $this->shopify_service->verify_webhooks($shop, $webhook_topic->topic_name,
                    $webhook_topic->webhook_topic_url
                );
                if ($bound_webhook_for_this_event) {
                    $config->status = 1;
                    Session::flash('message', 'Event Configured Successfully.Test your event now by clicking Test Action button below.');
                } else {
                    $config->status = 0;
                    Session::flash('message', 'Event saved successfully but not bound to shopify webhook.Please enable it later.Test your event now by clicking Test Action button below.');
                }
            } else {
                Session::flash('message', 'Event saved successfully but not enabled.Test your event now by clicking Test Action button below.');
                $config->status = 0;
            }
            $config->save();
            //redirect route
            $webhookEventIdByTopicId = webhookEventIdByTopicId($request->webhook_topic_id);
            $webhook_event = WebhookEvent::find($webhookEventIdByTopicId);
            $route_params = [$webhook_event->slug, $config->id];
            // if this channel has multiple events
            if ($request->api_fields && $request->channel_account_id)
            {
                //save api fields and other information
                $config->channel_event_settings()->create([
                        "channel_account_id" => $request->channel_account_id,
                        "channel_event_id" => $request->channel_event_id ?? 0,
                        "api_fields" => $request->api_fields,
                        "object_id" => $request->object_id,
                        "object_text" => $request->object_text,
                        "where_clause_fields" =>$request->where_clause_fields ?? null
                    ]
                );
                $route_params['channel_account_id'] = $request->channel_account_id;
            }

            //redirect to same page for test triggers or actions
            return redirect()->route('channel_config', $route_params);
        } catch (\Exception $e) {
            Session::flash('message', $e->getMessage());
            return redirect()->route('registered_webhooks');
        }
    }

    public function update_general_event_config(StoreGeneralEventRequest $request, $id)
    {
        try {
            $shop = session('shop');
            $webhook_topic = WebhookTopic::find($request->webhook_topic_id);
            $config = ChannelConfig::where('id', $id)->where('shop_id', $shop['shop_id'])->first();
            if (!$webhook_topic || !$config) {
                Session::flash('message', 'No details Found');
                return redirect()->route('dashboard');
            }
            // set previous status value true or false
            $last_event_status = $config->status;
            $last_webhook_topic_id = $config->webhook_topic_id;
            $config->webhook_topic_id = $request->webhook_topic_id;
            $config->description = $request->description;
            $config->execution_conditions = $request->execution_conditions;
            $config->send_system_defined_notifcation = ($request->send_system_defined_notifcation ?? 0);
            $config->message_title = $request->message_title;
            $config->message_body = $request->message_body;
            $config->post_url = $request->post_url;
            if (isset($request->status) && $request->status == 'enabled') {
                $config->status = 1;
            } else {
                $config->status = 0;
            }
            $config->save();
            // if this channel has multiple events
            if ($request->api_fields && $request->channel_account_id) {
                $channel_event_settings = $config->channel_event_settings;

                //update child
                $channel_event_settings->update(
                    [
                        "channel_account_id" => $request->channel_account_id,
                        "channel_event_id" => $request->channel_event_id ?? 0,
                        "api_fields" => $request->api_fields,
                        "object_id" => $request->object_id,
                        "object_text" => $request->object_text,
                        "where_clause_fields" =>$request->where_clause_fields ?? null
                    ]
                );

            }


            if ($last_webhook_topic_id !== $request->webhook_topic_id || $last_event_status) {
                $is_active_configured_hook = ChannelConfig::where('webhook_topic_id', $last_webhook_topic_id)
                    ->where('shop_id', $shop['shop_id'])
                    ->where('status', 1)
                    ->count();

                if ($is_active_configured_hook == 0) {
                    // disable previous webhook if activated/enabled
                    $this->shopify_service->remove_single_webhook($shop, topicNameById($last_webhook_topic_id));
                }
            }
            if ($config->status) {
                $bound_webhook_for_this_event = $this->shopify_service->verify_webhooks($shop, $webhook_topic->topic_name,
                    $webhook_topic->webhook_topic_url);
                if ($bound_webhook_for_this_event) {
                    $config->status = 1;
                    Session::flash('message', 'Event Configured Successfully');
                } else {
                    $config->status = 0;
                    Session::flash('message', 'Event updated successfully but not bound to shopify webhook.Please enable it later');
                }
                $config->save();
            } else {
                Session::flash('message', 'Event Configured Successfully');
            }

        } catch (\Exception $e) {

            Session::flash('message', $e->getMessage());
        }
        return redirect()->route('registered_webhooks');
    }

    public function remove_channel_account(Request $request)
    {
        $shop = session('shop');
        $channel_account = ChannelAccount::where('shop_id', $shop['shop_id'])
            ->where('id', $request->id)->first();
        if (!$channel_account)
            return response()->json(array('status' => 'error', 'message' => 'No account details found'));
        if ($channel_account->channel_event_settings->count()) {
            return response()->json(array('status' => 'error', 'message' => 'You have events associated with this account.Please remove them first'));
        } else {
            $channel = $channel_account->channel;
            $channel_account->delete();
            return response()->json(array('status' => 'success', 'message' => 'Account removed successfully'));
        }
    }

    public function retry_failed_webhook(Request $request, $id)
    {
        try {
            $shop = session('shop');
            $log = WebhookLog::where('id', $id)->where('shop_id', $shop['shop_id'])->first();
            if($log && $log->retries_left > 0 && $shop && $this->webhook_logs->allowed_tasks_per_plan($shop)) {
                $log->retries_left -= 1;
                $log->save();
                $channel_config = ChannelConfig::where('id', $log->channel_config_id)->where('shop_id', $shop['shop_id'])->first();
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
//            $sample_webhooks_data = config("sample_webhooks_data.$event_name");
                $sample_webhooks_data = $log->webhook_data;
                switch ($event_name) {
                    case "Customer":
                        $process_webhook = new ProcessCustomersWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "Cart":
                        $process_webhook = new ProcessCartWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "Checkout":
                        $process_webhook = new ProcessCheckoutsWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "Collection":
                        $process_webhook = new ProcessCollectionWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "CustomerSavedSearch":
                        $process_webhook = new ProcessCustomerSavedSearchWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "DraftOrder":
                        $process_webhook = new ProcessOrderWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "Fulfillment":
                        $process_webhook = new ProcessFulfillmentsWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "FulfillmentEvent":
                        $process_webhook = new ProcessFulfillmentEventsWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "InventoryItem":
                        $process_webhook = new ProcessInventoryItemLevelWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "InventoryLevel":
                        $process_webhook = new ProcessInventoryItemLevelWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "Location":
                        $process_webhook = new ProcessLocationWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "Order":
                        $process_webhook = new ProcessOrderWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "OrderTransaction":
                        $process_webhook = new ProcessOrderTransactionsWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "Product":
                        $process_webhook = new ProcessProductsWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "Refund":
                        $process_webhook = new ProcessRefundsWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "Shop":
                        $process_webhook = new ProcessShopWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "TenderTransaction":
                        $process_webhook = new ProcessTenderTransactionsWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "Theme":
                        $process_webhook = new ProcessThemeWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "OrderEdit":
                        // add property order_edit as its been updated in sample sheet but exists in original webhook
                        $altered_array_structure['order_edit'] = $sample_webhooks_data;
                        $process_webhook = new ProcessOrderEditWebhooksLib($channel_config, $altered_array_structure, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "ShopAlternateLocale":
                        $process_webhook = new ProcessShopAlternateLocaleWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "SubscriptionContract":
                        $process_webhook = new ProcessSubscriptionContractWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    case "Dispute":
                        $process_webhook = new ProcessDisputeWebhooksLib($channel_config, $sample_webhooks_data, $shop, $event_topic, $headers, $event_name, $is_test_webhook = false, true);
                        $response = $process_webhook->trigger();
                        break;
                    default:
                        return response()->json(array('status' => false, 'message' => 'No registered webhook event found'));
                        break;
                }
                if($response['status']){
                    $log->retries_left = 0;
                    $log->save();
                }
                if($response['status']) return response()->json(array('status' => $response['status'], 'message' => $response['message'], 'retries_left' => $log->retries_left));
                else return response()->json(array('status' => $response['status'], 'message' => $response['message']."<br/><strong>Note:</strong><br/>You can retry failed jobs upto 3 times and remaining count is $log->retries_left.If event fails multiple times , try updating the field values according to exception or contact administration for support.", 'retries_left' => $log->retries_left));
            }
            else return response()->json(array('status' => false, 'message' => "Retry failed! Either retry limit or plan's quota limit reached. <a href='". route('faqs') ."'>Learn more</a>"));

        } catch (\Exception $e) {
            return response()->json(array('status' => false, 'message' => $e->getMessage()));
        }
    }

}
