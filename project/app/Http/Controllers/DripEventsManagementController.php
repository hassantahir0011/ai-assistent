<?php

namespace App\Http\Controllers;

use App\Entities\ChannelAccount;
use App\Entities\ChannelEvent;
use App\Entities\ChannelEventSetting;
use App\Http\Requests\DripConnectionRequest;
use App\Services\Connectors\DripApiLibrary;
use App\Services\ShopifyService;
use Illuminate\Http\Request;

class DripEventsManagementController extends Controller
{
    private $shopify_service;
    private $drip_library;

    public function __construct(ShopifyService $shopify_service, DripApiLibrary $drip_library)
    {
        $this->shopify_service = $shopify_service;
        $this->drip_library = $drip_library;
    }

    public function get_drip_resources(Request $request)
    {
        $final_array = [];
        $shop = session('shop');
        if (!$request->channel_object)
            return ['results' => $final_array];
        $drip_account = ChannelAccount::where('id', $request->channel_account_id)
            ->where('shop_id', $shop['shop_id'])->first();
        if ($drip_account) {
            switch ($request->channel_object):
                case "campaigns";
                    return $this->drip_library->get_campaigns($drip_account, $request);
                case "accounts";
                    return $this->drip_library->get_accounts($drip_account, $request);

            endswitch;

        }
        return ['results' => []];
    }

    public function load_drip_fields_section(Request $request)
    {
        $shop = session('shop');
        $drip_account = ChannelAccount::where('id', $request->channel_account_id)
            ->where('shop_id', $shop['shop_id'])->first();
        if (!$drip_account)
            return response()->json(['status' => 'error', 'message' => 'No account details found.']);
        if (!$request->channel_event_id || !$channel_event = ChannelEvent::where('id', $request->channel_event_id)->first())
            return response()->json(['status' => 'error', 'message' => 'No channel event found.']);
        $channel_event_settings = null;
//        if request from edit mysql webhook event (prefilled already stores table and request data in views)
        if (isset($request->drip_event_setting_id) && !empty($request->drip_event_setting_id)) {
            $channel_event_settings = ChannelEventSetting::where('id', $request->drip_event_setting_id)->first();
        }
        $api_fields = $channel_event_settings && $channel_event_settings->api_fields ? $channel_event_settings->api_fields : [];
        $module_fields = [];
        if ($channel_event->slug == "add_or_update_lead")
            $module_fields = $this->drip_library->get_module_fields($drip_account, "leads");
        return view("drip.load_api_fields_section",
            compact('channel_event_settings', 'channel_event', 'api_fields', 'module_fields'));

    }


    public function store_drip_account(DripConnectionRequest $request)
    {
        try {
            $shop = session('shop');
            $drip_account = ChannelAccount::firstOrNew([
                'shop_id' => $shop['shop_id'],
                'id' => $request->account_id ?? 0]);
            $account_details = $this->drip_library->get_account_details($request);
            if ($account_details == false || !isset($account_details->accounts)) {
                return response()->json(['code' => 401, 'status' => 'error',
                    'message' => "", 'errors' => [['message' => "Unable to authorize account.Please verify your api url,client id or secrent key."]],
                    'data' => new \stdClass()
                ], 200);
            }
            $account=$account_details->accounts[0]??[];
            $login_credentials = [
                'default_from_name' => $account->default_from_name,
                'default_from_email' => $account->default_from_email,
                'name' => $account->name,
                'url' => $account->url,
                'id' => $account->id,
                'api_token' => $request->api_token
            ];
            $drip_account->login_credentials = $login_credentials;
            $drip_account->shop_id = $shop['shop_id'];
            $drip_account->save();
            return response()->json(['code' => 200, 'status' => 'success',
                'message' => "Account saved successfully"
            ], 200);

        } catch (\Exception $e) {

            $error_msg = $e->getMessage();
            return response()->json(['code' => 422, 'status' => 'error',
                'message' => $error_msg, 'errors' => [['message' => $error_msg]],
                'data' => new \stdClass()
            ], 422);
        }
    }

    public function drip_account_login($id = 0)
    {
        $shop = session('shop');
        $account = null;
        if (!empty($id)) {
            $account = ChannelAccount::where('id', $id)->where('shop_id', $shop['shop_id'])->first();
        }
        $login_credentials = $account ? $account->login_credentials : [];
        return view('drip.login_window', compact('account', 'login_credentials'));
    }


}
