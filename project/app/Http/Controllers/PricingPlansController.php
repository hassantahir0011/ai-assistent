<?php

namespace App\Http\Controllers;

use App\Entities\CodeSnippet;
use App\Entities\Shop;
use App\Entities\ChannelConfig;
use Illuminate\Http\Request;
use Session;
use App\Services\ShopifyService;


class PricingPlansController extends Controller
{

    private $shopify_service;
    private $api_version;

    public function __construct(ShopifyService $shopify_service)
    {
        $this->shopify_service = $shopify_service;
        $this->api_version = env('SHOPIFY_API_VERSION') ?? '2019-10';
    }

    public
    function plans_listing(Request $request)
    {
        $shop = session('shop');
        $shop = Shop::where('shop_id', $shop['shop_id'])->first();
        return view('billing.plans', compact('shop'));


    }

    public
    function update_pricing_plan(Request $request)
    {
        $faqs_url=route('faqs');
        $shop = session('shop');
        if (isset($request->plan_type) && !empty($request->plan_type)) {
            $t_active_webhooks = ChannelConfig::where('shop_id', $shop['shop_id'])
                ->where('status', 1)
                ->count();

            $t_channels_used = ChannelConfig::distinct()
                    ->where('shop_id', $shop['shop_id'])
                    ->where('status', 1)
                    ->count('id');
            if ($request->plan_type == 'basic') {
                if ($t_active_webhooks > 2 || $t_channels_used > 2) {
                    $message = "Sorry,You cannot downgrade plan with more than 2 active webhooks or channels.Please remove exceeding limit webhooks or configured channels to downgrade.Please visit <a href=$faqs_url>Guides & FAQs</a> for more information.";
                    return view('billing.plan_downgrade_error', compact('message'));
                }
            } elseif ($request->plan_type == 'professional') {
                if ($t_active_webhooks >  10 || $t_channels_used > 6) {
                    $message = "Sorry,You cannot downgrade plan with more than 10 active webhooks or 6 channels.Please remove exceeding limit webhooks or configured channels to downgrade.Please visit <a href=$faqs_url>Guides & FAQs</a> for more information.";
                    return view('billing.plan_downgrade_error', compact('message'));
                }
            }
            $shop_obj = Shop::where('shop_id', $shop['shop_id'])->first();
            if ($shop_obj) {

                $shop_charge_api_generated = $this->shopify_service->generate_shop_charge_api($shop_obj, $request->plan_type);
                if ($shop_charge_api_generated) {
                    return redirect()->route('billing_page');

                } else {
                    Session::flash('message', 'Basic Free Plan activated');
                    return redirect()->back();
                }

            }


        }
        Session::flash('message', 'Unable to process request.Please try in a moment');
        return redirect()->back();

    }


}
