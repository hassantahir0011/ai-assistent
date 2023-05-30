<?php

namespace App\Http\Controllers;


use App\Entities\PlansHistory;
use App\Entities\ChannelConfig;
use App\Jobs\InstallAppNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Session;
use Oseintow\Shopify\Facades\Shopify;
use App\Services\ShopifyService;
use App\Entities\Shop;

class ShopifyController extends Controller
{
    private $shopify_service;
    private $api_version;

    public function __construct(ShopifyService $shopify_service)
    {
        $this->shopify_service = $shopify_service;
        $this->api_version = config('shopify.api_version');
    }

    public
    function logout()
    {
        session()->invalidate();
        return view('switch_store');

    }

    public function install_app(Request $request)
    {
        $shopUrl = $request->shop;
        if ($request->shop) {
            $scope = config('shopify.scope');
            $scope = explode(',', $scope);
            $redirectUrl = config('shopify.redirect_url');
            $shopify = Shopify::setShopUrl($shopUrl);

            // invalidate existing session & re-create one with a generated state
            session()->invalidate();
            session()->start();
            session()->put('auth_state', $state = uniqid());
            $url = $shopify->getAuthorizeUrl($scope, $redirectUrl, $state);
            return view('authorize', compact('url'));
        } elseif ($request->switch_account && session('shop')) {
            return view('switch_store');
        } else {
            return $this->badLogin('Store URL Missing');
        }

    }


    public
    function shopify_callback(Request $request)
    {
        // NOTE: integrity of input/hmac is verified in VerifyShopifyRequest middleware class
        // verify state

        $state = $request->state;
        $expected_state = session()->remove('auth_state');
        if (empty($state) || $state != $expected_state) {
            return $this->badLogin('invalid state');
        }
        // verify required input
        $shopUrl = $request->shop;
        $code = $request->code;
        if (empty($shopUrl) || empty($code)) {
            $this->badLogin('missing input');
        }
        // retrieve token and shop data
        $accessToken = Shopify::setShopUrl($shopUrl)->getAccessToken($code);
        if (!$accessToken || empty($accessToken))
            return $this->badLogin('Unable to retrieve shop access token.Please restart the app from apps listing.');
        $shop_data = Shopify::setShopUrl($shopUrl)->setAccessToken($accessToken)->get("admin/api/$this->api_version/shop.json");

        if (!$shop_data || empty($shop_data)) {
            return $this->badLogin('unable to retrieve shop data');
        } else {
            session()->put('shopify_token', $accessToken);
            $shop_saved_object = $this->shop_data($shopUrl, $shop_data, $accessToken);
//            $this->shopify_service->verify_webhooks($shop_saved_object);
            if ($shop_saved_object && !$shop_saved_object->is_webhooks_added) {
                $this->shopify_service->verify_webhooks($shop_saved_object);
            }
            if ($shop_saved_object && (!$shop_saved_object->current_plan_type || $shop_saved_object->is_deleted == 1)) {
                return redirect()->route('plans_listing');
            }
        }
        return redirect()->route('dashboard');
    }

    public
    function billing_page()
    {
        $shop = session('shop');

        $shopUrl = $shop['myshopify_domain'];
        $shop = Shop::where('myshopify_domain', $shopUrl)->first();
        if ($shop && $shop->confirmation_url) {
            $confirmation_url = $shop->confirmation_url;
            return view('billing.billing_page', compact('confirmation_url'));
        }
    }

    private
    function shop_data($domain, $shop_data, $access_token)
    {
        try {
            $new_store = false;
            $shop = Shop::firstOrNew(array('myshopify_domain' => $domain));
            // if store installed the app for the first time
            if (empty($shop->id)) {
                $new_store = true;
            }
            $shop->shop_id = $shop_data['id'];
            $shop->name = $shop_data['name'];
            $shop->email = $shop_data['email'];
            $shop->customer_email = $shop_data['customer_email'] ?? '';
            $shop->domain = $shop_data['domain'];
            $shop->myshopify_domain = $shop_data['myshopify_domain'];
            $shop->country = $shop_data['country'];
            $shop->address = $shop_data['address1'];
            $shop->address2 = $shop_data['address2'] ?? "";
            $shop->zip = $shop_data['zip'];
            $shop->city = $shop_data['city'];
            $shop->province = $shop_data['province'];
            $shop->country_name = $shop_data['country_name'];
            $shop->country_code = $shop_data['country_code'];
            $shop->phone = $shop_data['phone'];
            $shop->currency = $shop_data['currency'];
            $shop->shop_owner = $shop_data['shop_owner'];
            $shop->timezone = $shop_data['timezone'];
            $shop->iana_timezone = $shop_data['iana_timezone'];
            $shop->access_token = $access_token;
            $shop->shopify_plan_name = $shop_data['plan_name'];
            $shop->shopify_plan_display_name = $shop_data['plan_display_name'];
            $shop->primary_locale = $shop_data['primary_locale'];
            $shop->uninstalled_at = null;
            $shop->save();
            session()->put('shop_id', $shop->id);
            session()->put('current_plan_type', $shop->current_plan_type);
            session()->put('shop', $shop);
            // send welcome email to store owner
            if ($new_store) {
                $email_notification = (new InstallAppNotification($shop));
                dispatch_now($email_notification);
            }
            return $shop;
        } catch (Exception $e) {
            return false;
        }

    }


    public
    function removeApp()
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data);
        if (!empty($data)) {
            $shop = Shop::where('shop_id', $data->id)->first();
            if ($shop) {
                $shop->is_deleted = 1;
                $shop->current_plan_type = null;
                $shop->is_webhooks_added = 0;
                $shop->uninstalled_at = Carbon::now();
                $shop->save();
                //update all webhook statuses to disable
                ChannelConfig::where('shop_id', $shop->shop_id)->update(['status' => 0]);
                $email_notification = (new InstallAppNotification($shop));
                dispatch_now($email_notification);
                return response()->json(array('success' => true, 'message' => "received"), 200);
            }
        }

    }

    public function badLogin($message)
    {
        session()->invalidate();
        return view('errors.un_verrified_shopify_request', compact('message'));
    }


    public
    function confirmBilling(Request $request)
    {
        $charge_id = $request->charge_id;
        if (Session::has('shop') && isset($charge_id)) {
            $shop = session('shop');
            $shopUrl = $shop['myshopify_domain'];
            $accessToken = null;
            if (Session::has('shopify_token')) {
                $accessToken = session('shopify_token');
            } else {
                $accessToken = Shop::where('myshopify_domain', $shopUrl)->first();
                if ($accessToken) {
                    $accessToken = $accessToken->access_token;
                }
            }
            if ($accessToken) {
                $res = Shopify::setShopUrl($shopUrl)->setAccessToken($accessToken)->get("admin/api/$this->api_version/recurring_application_charges/" . $charge_id . ".json");
                if (isset($res['status']) && $res['status'] == 'active') {
                    $shop = Shop::firstOrNew(array('myshopify_domain' => $shopUrl));
                    $shop->charge_status = $res['status'];
                    $shop->current_plan_type = strtolower($res['name']);
                    $shop->save();

                    // updating plan history
                    $plan_history = PlansHistory::where('shop_id', $shop->shop_id)->where('charge_id', $charge_id)->first();
                    if ($plan_history) {
                        $plan_history->charge_status = $res['status'];
                        $plan_history->save();
                    }
                    session()->put('current_plan_type', $shop->current_plan_type);
                    Session::flash('message', 'Plan activated successfully.');
                    return redirect()->route('dashboard');

                } else {
                    //$shop = Shop::where('myshopify_domain', $shopUrl)->first();
//                    $shop->is_deleted = 1;
                    //  $shop->save();
                    Session::flush();
//                    return view('billing.rejected_billing_page', compact('shopUrl'));
                    return $this->badLogin('Payment Declined or Cancelled');

                }
            }
        }

        Session::flush();
        return $this->badLogin('Payment Declined or Cancelled');
    }

    public function un_verrified_shopify_request(Request $request)
    {
        $message = $request->message ?? "";
        return view('errors.un_verrified_shopify_request', compact('message'));
    }
}
