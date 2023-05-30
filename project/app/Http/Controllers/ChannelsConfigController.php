<?php

namespace App\Http\Controllers;


use App\Entities\Admin\Doc;
use App\Entities\ChannelConfig;
use App\Entities\MicrosoftAccount;
use App\Entities\WebhookEvent;
use App\Entities\WebhookTopic;
use Illuminate\Http\Request;
use Redirect;
use Session;
use App\Services\ShopifyService;

use DB;
use URL;


class ChannelsConfigController extends Controller
{
    private $shopify_service;

    public function __construct(ShopifyService $shopify_service)
    {
        $this->shopify_service = $shopify_service;
    }

    public function channel_config(Request $request, $webhook_event_slug, $registered_webhook_id = 0)
    {

        $shop = session('shop');
        $shop_id = $shop['shop_id'];
        $guide_available=false;
        $webhook_event = WebhookEvent::where('slug', $webhook_event_slug)->where('is_active', 1)->first();
        if($webhook_event) {
            $webhook_event_id = $webhook_event->id;
            $guide_available = Doc::where('status', 1)->where('webhook_event_id', $webhook_event_id)->count();
            if ($guide_available > 0)
                $guide_available = true;
            $webhook_topics = WebhookTopic::where('webhook_event_id', $webhook_event_id)
                ->where('topic_status', 'enabled')
                ->get();
            $registered_webhook = null;

            if ($webhook_topics->isEmpty() || ($registered_webhook_id && !$registered_webhook = ChannelConfig::where('id', $registered_webhook_id)->where('shop_id', $shop_id)->first())) {
                Session::flash('message', 'No details Found.Either channel or event configuration is unavailable.');
                return redirect()->back();
            }
            $webhook_event = WebhookEvent::find($webhook_event_id);
            $webhook_event_conditions = config("event_execution_conditions.$webhook_event->event_name");
            // get keys and fields names from sample shopify webhooks data config file
            $sample_webhooks_data = config('sample_webhooks_data.' . $webhook_event->event_name);
            $shopify_event_request_fields = $this->shopify_service->shopify_event_request_fields($sample_webhooks_data, true);

            $channel_event_settings = $registered_webhook ? $registered_webhook->channel_event_settings : null;
            $channel_accounts = \App\Entities\ChannelAccount::where('shop_id', $shop_id);
            if ($channel_event_settings && $channel_event_settings->channel_account_id)
                $channel_accounts = $channel_accounts->orderBy(\DB::raw('CASE
                                                                        WHEN id=' . $channel_event_settings->channel_account_id . ' THEN 1
                                                                      END', 'DESC'));

            $channel_account_id = $_GET['channel_account_id'] ?? null;
            if ($channel_account_id) {
                $response = true ;
                if (!$response) {
                    if ($registered_webhook_id != 0) {
                        return redirect()->route('channel_config', ['webhook_event_id' => $webhook_event->event_name, 'id' => $registered_webhook_id]);
                    } else {
                        return redirect()->route('channel_config', ['webhook_event_id' => $webhook_event->event_name]);
                    }
                }
            }

            $channel_accounts = $channel_accounts->get();
            return view("channel.setup", compact('guide_available', 'shopify_event_request_fields', 'channel_event_settings', 'channel_accounts', 'webhook_topics', 'registered_webhook', 'webhook_event', 'webhook_event_conditions'));

        }
        else{
            Session::flash('message', 'No details Found.Either channel or event configuration is unavailable.');
            return redirect()->back();
        }
    }

}

